<?php


namespace App\Http\Traits;

use App\Models\QuickBookSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Account;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Item;
use App\Models\Invoice as ModelsInvoice;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait QuickBook
{

    public function createInvoice($customerId, $quickBookProducts = [], $orderitems, $order)
    {
        try {
            $requiredServices = array();

            $quickBookProducts = $this->getQuickBookSkuAsKeyAndProductIdAsValue($quickBookProducts);
            $dataService  = $this->getDataService();
            $lineDetailsArray = $this->getProductLineDetails($orderitems, $quickBookProducts);

            if (count($lineDetailsArray['lineDetails']) != $orderitems->count()) {
                $missingProducts = $this->getMissingProductDetails($orderitems, $quickBookProducts);
                return [
                    'error' => false,
                    'invoice' => 0,
                    'invoice_number' => '',
                    'create_product' => 1,
                    'message' => 'Product(s) not found in QuickBooks',
                    'missing_products' => $missingProducts,
                    'missing_services' => []
                ];
            }

            $lineDetails = $this->getExtraPaymentsDetails($order, $lineDetailsArray, $quickBookProducts);
            $lineDetails = $this->getDiscountDetails($order, $lineDetails);

            if (!count($lineDetails)) {
                return [
                    'error' => false,
                    'invoice' => 0,
                    'invoice_number' => '',
                    'create_product' => 0,
                    'message' => '',
                    'missing_products' => [],
                    'missing_services' => []
                ];
            }

            $invoiceToCreate = Invoice::create([
                "Line" => $lineDetails,
                "CustomerRef" => [
                    "value" => $customerId,
                ],
                "DocNumber" => $order->invoice_no,
                "ShipAddr" => $this->getShipAddress($order),
                "BillAddr" => $this->getBillAddress($order)
            ]);

            $resultObj = $dataService->Add($invoiceToCreate);
            $error = $dataService->getLastError();
            if ($error) {
                $errorLog = array(
                    'action'            => 'Quick book API Invoice creation',
                    'Status code'       => $error->getHttpStatusCode(),
                    'Helper message'    => $error->getOAuthHelperError(),
                    'Response message'  => $error->getResponseBody(),
                    'file'              => __FILE__,
                    'method'            => __METHOD__,
                    'line'              => __LINE__,
                );

                Log::info(json_encode($errorLog));

                $xml = simplexml_load_string($error->getResponseBody()) or die("Error: Cannot create object");
                return [
                    'error' => false,
                    'invoice' => 0,
                    'invoice_number' => '',
                    'create_product' => 0,
                    'message' => ((array)$xml->Fault->Error->Message)[0],
                    'missing_products' => [],
                    'missing_services' => []
                ];
            } else {
                return [
                    'error' => false,
                    'invoice' => $resultObj->Id,
                    'invoice_number' => $resultObj->DocNumber,
                    'create_product' => 0,
                    'message' => '',
                    'missing_products' => [],
                    'missing_services' => []
                ];
            }
            return [
                'error' => false,
                'invoice' => 0,
                'invoice_number' => '',
                'create_product' => 0,
                'message' => '',
                'missing_products' => [],
                'missing_services' => []
            ];
        } catch (\Throwable $exception) {
            return [
                'error' => true,
                'invoice' => 0,
                'invoice_number' => '',
                'create_product' => 0,
                'message' => $exception->getMessage(),
                'missing_products' => [],
                'missing_services' => []
            ];
        }
    }

    public function getQuickBookSkuAsKeyAndProductIdAsValue($quickBookProducts)
    {
        $data = [];
        foreach ($quickBookProducts as $product) {
            $data[$product->Sku] = $product->Id;
        }
        return $data;
    }

    public function setSessionData($accessTokenObj)
    {
        $config = config('isc-intuit');
        QuickBookSetting::updateOrCreate(
            [
                'quick_books_config_qbo_realm_id' => $config['realm_id']
            ],
            [
                'quick_books_config_qbo_realm_id' => $config['realm_id'],
                'quick_books_api_refresh_token' => $accessTokenObj->getRefreshToken(),
                'quick_books_api_access_token' => $accessTokenObj->getAccessToken(),
            ]
        );
    }


    public function setNewAccessToken()
    {
        $refreshToken = $this->getRefreshToken();
        if (!$refreshToken) {
            return false;
        }

        try {

            $quickBookConfig = self::getConfig();
            $dataService = DataService::Configure(array(
                'auth_mode'     => $quickBookConfig['quick_books_config_auth_mode'],
                'ClientID'      => $quickBookConfig['quick_books_config_client_id'],
                'ClientSecret'  => $quickBookConfig['quick_books_config_client_secret'],
                'RedirectURI'   => $quickBookConfig['quick_books_config_redirect_uri'],
                'scope'         => $quickBookConfig['quick_books_config_scope'],
                'baseUrl'       => $quickBookConfig['quick_books_config_base_url'],
            ));
            Cache::forget('quickBookConfig');

            $oauth2LoginHelper = new OAuth2LoginHelper($quickBookConfig['quick_books_config_client_id'], $quickBookConfig['quick_books_config_client_secret']);
            $accessTokenObj = $oauth2LoginHelper->refreshAccessTokenWithRefreshToken($refreshToken);
            $this->setSessionData($accessTokenObj);
        } catch (\Throwable $exception) {
            $errorLog = array(
                'message'   => $exception->getMessage(),
                'action'    => 'Quick book API refresh token failed',
                'file'      => __FILE__,
                'method'    => __METHOD__,
                'line'      => __LINE__,
            );
            Log::error(json_encode($errorLog));
            return false;
        }

        return true;
    }

    public function getRefreshToken()
    {
        return optional(QuickBookSetting::first())->quick_books_api_refresh_token;
    }

    public function getDataService()
    {
        $quickBookConfig = self::getConfig();

        return DataService::Configure(array(
            'auth_mode'         => $quickBookConfig['quick_books_config_auth_mode'],
            'ClientID'          => $quickBookConfig['quick_books_config_client_id'],
            'ClientSecret'      => $quickBookConfig['quick_books_config_client_secret'],
            'baseUrl'           => $quickBookConfig['quick_books_config_base_url'],
            'accessTokenKey'    => $quickBookConfig['quick_books_api_access_token'],
            'refreshTokenKey'   => $quickBookConfig['quick_books_api_refresh_token'],
            'QBORealmID'        => $quickBookConfig['quick_books_config_qbo_realm_id'],
        ));
    }

    public function getCustomerId($email)
    {
        try {

            $dataService  = $this->getDataService();
            $sql = sprintf(
                "select id from Customer Where PrimaryEmailAddr = '%s'",
                $email
            );

            $customerData = $dataService->Query($sql);
            return [
                'error' => false,
                'customer_id' => isset($customerData[0]->Id) ? $customerData[0]->Id : 0,
                'message' => ''
            ];
        } catch (\Throwable $exception) {
            return [
                'error' => true,
                'customer_id' => 0,
                'message' => $exception->getMessage()
            ];
        }
    }


    public function getCustomerId1($displayName)
    {
        try {

            $dataService  = $this->getDataService();
            $sql = sprintf(
                "select id from Customer Where DisplayName = '%s'",
                $displayName
            );

            $customerData = $dataService->Query($sql);
            return [
                'error' => false,
                'customer_id' => isset($customerData[0]->Id) ? $customerData[0]->Id : 0,
                'message' => ''
            ];
        } catch (\Throwable $exception) {
            return [
                'error' => true,
                'customer_id' => 0,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function getQuickBookProductsBasedOnOrderItem($orderitems, $from = '')
    {
        try {

            $dataService  = $this->getDataService();

            $skus = collect();
            $orderitems->each(function ($orderitem, $key) use ($skus) {
                //$skus->push(optional($orderitem->product)->slug);
                $skus->push(optional($this->orderItemDetails($orderitem))->slug);
            });
            $skus = $skus->join('\',\'');

            $sql = sprintf(
                "select * from Item where sku in('%s')",
                $skus
            );

            $product =  $dataService->Query($sql);

            return [
                'error' => false,
                'product' => $product,
                'message' => ''
            ];
        } catch (\Throwable $exception) {
            return [
                'error' => true,
                'product' => '',
                'message' => $exception->getMessage()
            ];
        }
    }

    public function getProductLineDetails($orderitems, $quickBookProducts)
    {
        $lineDetails = [];
        $productQuantity = 0;
        foreach ($orderitems as $orderitem1) {
            $orderitem = $this->orderItemDetails($orderitem1);
            if (isset($quickBookProducts[optional($orderitem)->slug])) {
                $productQuantity = $productQuantity + $orderitem->qty;
                $lineDetails[] = array(
                    "Description"           => optional($orderitem)->description,
                    "Amount"                => floatval($orderitem->price) * intval($orderitem->qty),
                    "DetailType"            => "SalesItemLineDetail",
                    "SalesItemLineDetail"   => [
                        "ItemRef" => [
                            "name"  => optional($orderitem)->title,
                            "value" => $quickBookProducts[optional($orderitem)->slug],
                        ],
                        "TaxCodeRef" => [
                            "value" => config('isc-intuit.default_tax_id')
                        ],
                        "Qty" => intval($orderitem->qty),
                        "UnitPrice" => floatval($orderitem->price),
                    ]
                );
            }
        }

        return [
            'lineDetails' => $lineDetails,
            'productQuantity' => $productQuantity,
        ];
    }

    public function getMissingProductDetails($orderitems, $quickBookProducts)
    {
        $unwantedKey = ['PaymentMethodCost', 'ShippingCost', 'ASINLabellingCost'];
        foreach ($unwantedKey as $val) {
            if (array_key_exists($val, $quickBookProducts)) {
                unset($quickBookProducts[$val]);
            }
        }
        $lineDetails = [];
        foreach ($orderitems as $orderitem) {
            $orderItemDetails = $this->orderItemDetails($orderitem);
            // if (!isset($quickBookProducts[optional($orderitem->product)->slug]) && $orderitem->product) {
            //     $lineDetails[] = array(
            //         "id" => optional($orderitem->product)->id,
            //         "slug" => optional($orderitem->product)->slug,
            //         "title" => optional($orderitem->product)->title,
            //     );
            // }
            if (!isset($quickBookProducts[optional($orderItemDetails)->slug]) && $orderItemDetails) {
                $lineDetails[] = array(
                    "id" => optional($orderItemDetails)->id,
                    "slug" => optional($orderItemDetails)->slug,
                    "title" => optional($orderItemDetails)->title,
                );
            }
        }
        return $lineDetails;
    }

    public function orderItemDetails($item)
    {
        $slug = '';
        $description = '';

        if ($item->product_type == 'workshop') {
            $itemtype = $item->workshop;
            $slug = 'workshop-' . optional($item->workshop)->slug;
            $description = optional($item->workshop)->short_title;
        } elseif ($item->product_type == 'service') {
            $itemtype = $item->servicepackage->service;
            $slug = 'service-' . optional($item->servicepackage->service)->slug;

            $description = optional($item->servicepackage)->package_name;
            if (isset($item->option)) {
                $description .= ', ' . $item->option->option_name;
            }
            if (isset($item->addon)) {
                $description .= ', ' . $item->addon->addon_name;
            }
        } elseif ($item->product_type == 'studiorental') {
            $itemtype = $item->studiorental;
            $slug = 'studiorental-' . optional($item->studiorental)->slug;
            $description = optional($item->studiorental)->title;
        } else {
            $itemtype = $item->product;
            $slug = 'product-' . optional($item->product)->slug;
            $description = optional($item->product)->title;
        }
        $item->slug =  $slug;
        $item->upc =  $slug;
        $item->title =  optional($itemtype)->title;
        $item->name =  optional($itemtype)->title;
        $item->description =  $description;
        return $item;
    }

    public function getMissingServiceDetails($requiredKeys, $quickBookProducts)
    {
        $lineDetails = [];
        foreach ($requiredKeys as $key => $value) {
            if (!array_key_exists($key, $quickBookProducts)) {
                $lineDetails[] = array(
                    "id" => '',
                    "sku" => $key,
                    "name" => $value,
                );
            }
        }

        return $lineDetails;
    }

    public function getExtraPaymentsDetails($order, $lineDetailsArray, $quickBookProducts)
    {
        $lineDetails = $lineDetailsArray['lineDetails'];
        $productQuantity = $lineDetailsArray['productQuantity'];

        if ($order->shipping_cost && $order->shipping_cost != '') {
            $lineDetails[] = array(
                "Amount"                => floatval($order->shipping_cost),
                "DetailType"            => "SalesItemLineDetail",
                "SalesItemLineDetail"   => [
                    "ItemRef" => [
                        "value" => $quickBookProducts['ShippingCost'],
                    ],
                    "Qty" => 1,
                    "UnitPrice" => floatval($order->shipping_cost),
                ]
            );
        }

        if ($order->asin_labelling_cost && $order->asin_labelling_cost != '') {
            $lineDetails[] = array(
                "Amount"                => floatval($order->asin_labelling_cost),
                "DetailType"            => "SalesItemLineDetail",
                "SalesItemLineDetail"   => [
                    "ItemRef" => [
                        "value" => $quickBookProducts['ASINLabellingCost'],
                    ],
                    "Qty" => $productQuantity,
                    "UnitPrice" => floatval(config('general-config.ASIN_labelling_unit_cost')),
                ]
            );
        }

        if ($order->payment_method_cost && $order->payment_method_cost != '') {
            $lineDetails[] = array(
                "Amount"                => floatval($order->payment_method_cost),
                "DetailType"            => "SalesItemLineDetail",
                "SalesItemLineDetail"   => [
                    "ItemRef" => [
                        "value" => $quickBookProducts['PaymentMethodCost'],
                    ],
                    "Qty" => 1,
                    "UnitPrice" => floatval($order->payment_method_cost),
                ]
            );
        }

        return $lineDetails;
    }

    public function getDiscountDetails($order, $lineDetails)
    {
        if ($order->discount_amount && $order->discount_amount != '') {
            $lineDetails[] = array(
                "DetailType" => "DiscountLineDetail",
                "Amount" => $order->discount_amount ?? 0,
                "DiscountLineDetail" => [
                    "PercentBased" => false
                ]
            );
        }
        return $lineDetails;
    }

    public function getShipAddress($order)
    {
        return [
            "Line1" => $order->name,
            "Line2" => $order->adress,
            "Line3" => '',
            "City" => '',
            "Line4" => '',
            "PostalCode" => $order->post_code,
            "Country" => 'UAE',
        ];
    }

    public function getBillAddress($order)
    {
        return [
            "Line1" => $order->name,
            "Line2" => $order->adress,
            "Line3" => '',
            "City" => '',
            "Line4" => '',
            "PostalCode" => $order->post_code,
            "Country" => 'UAE',
        ];
    }

    public function downloadInvoiceAndSendLocation($id, $type = '')
    {

        $dataService = $this->getDataService();

        $fileName = '';
        try {
            $dataService = $this->getDataService();
            $dataService->throwExceptionOnError(false);
            $invoice = Invoice::create([
                "Id" => $id
            ]);

            if (!Storage::disk('public')->exists('invoice/')) {
                File::makeDirectory(storage_path('app/public/invoice'), $mode = 0777, true, true);
            }
            $directoryForThePDF = $dataService->DownloadPDF($invoice, storage_path('app/public/invoice'));
            $fileName = Str::afterLast($directoryForThePDF, '/');
        } catch (\Throwable $exception) {
            $errorLog = array(
                'message'       => $exception->getMessage(),
                'action'        => 'Quick book API Invoice PDF Download',
                'Invoice Id'    => $id,
                'file'          => __FILE__,
                'method'        => __METHOD__,
                'line'          => __LINE__,
            );
            Log::error(json_encode($errorLog));
        }
        return $fileName;
    }



    public static function ifInvoiceFileExists($orderId, $file = '')
    {
        $return = [
            'invoice_generated' => false,
            'invoice_file_exists' => false,
            'invoice_detals' => [],
        ];

        if ($file) {
            $invoice = ModelsInvoice::where('order_id', $orderId)->first();
            if ($invoice) {
                $return['invoice_generated'] = true;
                $return['invoice_detals'] = $invoice->toArray();
            }
            if (Storage::disk('public')->exists('invoice/' . $file)) {
                $return['invoice_file_exists'] = true;
            }
            /* Assigning the value of the variable  to the array . */
        } else {
            $invoice = ModelsInvoice::where('order_id', $orderId)->first();
            if ($invoice) {
                $return['invoice_generated'] = true;

                if ($invoice->file_location && Storage::disk('public')->exists('invoice/' . $invoice->file_location)) {
                    $return['invoice_file_exists'] = true;
                }

                $return['invoice_detals'] = $invoice->toArray();
            }
        }

        return $return;
    }

    public function syncProductToQuickBooks($product, $from = '')
    {
        $quickBookConfig = self::getConfig();
        if (!$quickBookConfig['quick_books_config_default_income_account_ref']) {
            $this->syncToDefaultAccountIds($quickBookConfig['quick_books_config_qbo_realm_id']);
        }
        try {
            if ($product) {
                $productCheck = $this->checkProductExists($product->slug, $from);
                $dataService  = $this->getDataService();
                $dataService->throwExceptionOnError(false);
                if ($productCheck) {
                    /*$productData = Item::update($productCheck, [
                        "TrackQtyOnHand" => true,
                        "QtyOnHand" => $product->pallet_stock ?? 0,
                        "InvStartDate" => "2022-01-01",
                        "Type" => "Inventory"
                    ]);*/
                    return 1;
                } else {
                    //"2022-01-01"

                    $productData = Item::create([
                        "TrackQtyOnHand" => true,
                        "Name" => $product->title,
                        "Description" => $product->description,
                        "Sku" => $product->slug,
                        "QtyOnHand" => 10000,
                        "InvStartDate" => Carbon::now()->subDays(2)->format('Y-m-d'),
                        "Type" => "Inventory",
                        "IncomeAccountRef" => [
                            "name" => "Sales of Product Income",
                            "value" => $quickBookConfig['quick_books_config_default_income_account_ref']
                        ],
                        "AssetAccountRef" => [
                            "name" => "Inventory Asset",
                            "value" => $quickBookConfig['quick_books_config_default_asset_account_ref']
                        ],
                        "ExpenseAccountRef" => [
                            "name" => "Cost of Product Sold",
                            "value" => $quickBookConfig['quick_books_config_default_expense_account_ref']
                        ]
                    ]);
                    $resultObj = $dataService->Add($productData);
                    if ($resultObj) {
                        return [
                            'status' => true,
                            'message' => ''
                        ];
                    }
                    $error = $dataService->getLastError();
                    if ($error) {
                        $xml = simplexml_load_string($error->getResponseBody());
                        $json = json_encode($xml);
                        $array = json_decode($json, TRUE);
                        if (isset($array['Fault']['Error']['Detail'])) {
                            return [
                                'status' => false,
                                'message' => $array['Fault']['Error']['Detail']
                            ];
                        }
                    } else {
                        return [
                            'status' => false,
                            'message' => 'Something went wrong'
                        ];
                    }
                }
            }
        } catch (\Throwable $exception) {
            $errorLog = array(
                'message'       => $exception->getMessage(),
                'action'        => 'Quick book API create product',
                'file'          => __FILE__,
                'method'        => __METHOD__,
                'line'          => __LINE__,
            );
            if ($from == 'bulkinvoice') {
                Log::channel('bulkinvoice')->info(json_encode($errorLog));
            } else {
                Log::error(json_encode($errorLog));
            }
            return 0;
        }
    }



    public function createOrCheckdefaultAccountIds($type = 'income')
    {
        //echo Carbon::now()->subDays(2)->format('Y-m-d');
        $quickBookConfig = self::getConfig();

        $dataService = $this->getDataService();
        $dataService->throwExceptionOnError(false);

        if ($type == 'income') {
            $accountData = [
                "Name" => "Sales of Product Income",
                "AccountType" => "Income",
                "AccountSubType" => "SalesOfProductIncome"
            ];
        } else if ($type == 'asset') {
            $accountData = [
                "Name" => "Inventory Asset",
                "AccountType" => "Other Current Asset",
                "AccountSubType" => "Inventory"
            ];
        } else {
            $accountData = [
                "Name" => "Cost of Goods Sold new create 86",
                "AccountType" => "Cost of Goods Sold",
                "AccountSubType" => "SuppliesMaterialsCogs"
            ];
        }
        try {

            $serviceData = Account::create($accountData);
            $resultObj = $dataService->Add($serviceData);
            if ($resultObj) {
                return 'Id=' . $resultObj->Id;
            }
            $error = $dataService->getLastError();
            if ($error) {
                $xml = simplexml_load_string($error->getResponseBody());
                $json = json_encode($xml);
                $array = json_decode($json, TRUE);
                if (isset($array['Fault']['Error']['Detail'])) {
                    return $array['Fault']['Error']['Detail'];
                }
            }
            return '';
        } catch (\Throwable $exception) {
            $errorLog = array(
                'message'       => $exception->getMessage(),
                'action'        => 'Quick book account create',
                'file'          => __FILE__,
                'method'        => __METHOD__,
                'line'          => __LINE__,
            );
            Log::error(json_encode($errorLog));
            return '';
        }
    }

    public function checkProductExists($slug, $from = '')
    {
        $dataService  = $this->getDataService();
        $sql = sprintf("select * from Item where sku ='$slug'",);
        return $dataService->Query($sql);
    }

    public function getTaxCodeDetails()
    {
        $dataService  = $this->getDataService();
        $sql = sprintf("SELECT * FROM TaxCode",);
        return $dataService->Query($sql);
    }

    public static function getConfig()
    {
        $config = config('isc-intuit');
        //$setting = Setting::inRandomOrder()->first();
        $setting = QuickBookSetting::where('quick_books_config_qbo_realm_id', $config['realm_id'])->first();
        return [
            'quick_books_config_auth_mode' => $config['auth_mode'],
            'quick_books_config_client_id' => $config['client_id'],
            'quick_books_config_client_secret' => $config['client_secret'],
            'quick_books_config_redirect_uri' => $config['oauth_redirect_uri'],
            'quick_books_config_scope' => $config['oauth_scope'],
            'quick_books_config_base_url' => $config['base_url'],
            'quick_books_config_qbo_realm_id' => optional($setting)->quick_books_config_qbo_realm_id ?? $config['realm_id'],
            'quick_books_config_default_customer_email_id' => $config['default_email'],
            'quick_books_config_default_income_account_ref' => optional($setting)->income_account_ref,
            'quick_books_config_default_asset_account_ref' => optional($setting)->asset_account_ref,
            'quick_books_config_default_expense_account_ref' => optional($setting)->expense_account_ref,
            'quick_books_api_access_token' => optional($setting)->quick_books_api_access_token,
            'quick_books_api_refresh_token' => optional($setting)->quick_books_api_refresh_token,
        ];
    }

    public function syncDefaultCustomerToQuickBooks($email = 'admin@strapstudios.com')
    {
        $dataService  = $this->getDataService();
        $dataService->throwExceptionOnError(false);
        $accName = rand(10, 99);
        $customerData = Customer::create([
            "FullyQualifiedName" => "Strapstudios Accounting-" . $accName,
            "PrimaryEmailAddr" => [
                "Address" => $email
            ],
            "DisplayName" => "Strap Studios Accounting-" . $accName,
            "Suffix" => "Jr",
            "Title" => "Mr",
            "MiddleName" => "",
            "Notes" => "",
            "FamilyName" => "",
            "PrimaryPhone" => [
                "FreeFormNumber" => ""
            ],
            "CompanyName" => "Strap Studios-" . $accName,
            "BillAddr" => [
                "CountrySubDivisionCode" => "",
                "City" => "Kottayam",
                "PostalCode" => "1704",
                "Line1" => "ADCP Business Tower",
                "Country" => "UAE"
            ],
            "GivenName" => ""

        ]);

        $resultObj = $dataService->Add($customerData);
        if ($resultObj) {
            return ['customer_id' => $resultObj->Id];
        }
        return ['customer_id' => ''];
    }

    public function syncCustomerToQuickBooks($order)
    {
        $dataService  = $this->getDataService();
        $dataService->throwExceptionOnError(false);
        $accName = rand(10, 99);
        $customerData = Customer::create([
            "FullyQualifiedName" => $order->name,
            "PrimaryEmailAddr" => [
                "Address" => $order->email
            ],
            "DisplayName" => $order->name . ' (' . $order->email . ')',
            //"DisplayName" => $order->name,
            "Suffix" => "Jr",
            "Title" => "Mr",
            "MiddleName" => "",
            "Notes" => "",
            "FamilyName" => "",
            "PrimaryPhone" => [
                "FreeFormNumber" => ""
            ],
            "CompanyName" => "Strap Studios",
            "BillAddr" => [
                "CountrySubDivisionCode" => "",
                "City" => $order->state_id,
                "PostalCode" => $order->post_code,
                "Line1" => $order->adress,
                "Country" => "UAE"
            ],
            "GivenName" => ""

        ]);

        $resultObj = $dataService->Add($customerData);
        if ($resultObj) {
            return ['customer_id' => $resultObj->Id];
        }
        return ['customer_id' => ''];
    }

    public function syncToDefaultAccountIds($realmId)
    {
        $dataService = $this->getDataService();
        $dataService->throwExceptionOnError(false);

        $types = ['income_account_ref', 'asset_account_ref', 'expense_account_ref'];

        foreach ($types as $type) {
            if ($type == 'income_account_ref') {
                $accountData = [
                    "Name" => "Sales of Product Income",
                    "AccountType" => "Income",
                    "AccountSubType" => "SalesOfProductIncome"
                ];
            } elseif ($type == 'asset_account_ref') {
                $accountData = [
                    "Name" => "Inventory Asset",
                    "AccountType" => "Other Current Asset",
                    "AccountSubType" => "Inventory"
                ];
            } else {
                $accountData = [
                    "Name" => "Cost of Goods Sold new create 86",
                    "AccountType" => "Cost of Goods Sold",
                    "AccountSubType" => "SuppliesMaterialsCogs"
                ];
            }

            $msg = '';

            $serviceData = Account::create($accountData);
            $resultObj = $dataService->Add($serviceData);
            if ($resultObj) {
                $msg = 'Id=' . $resultObj->Id;
            }
            $error = $dataService->getLastError();
            if ($error) {
                $xml = simplexml_load_string($error->getResponseBody());
                $json = json_encode($xml);
                $array = json_decode($json, TRUE);
                if (isset($array['Fault']['Error']['Detail'])) {
                    $msg = $array['Fault']['Error']['Detail'];
                }
            }
            if (str_contains($msg, 'Id=')) {
                $returnId = substr($msg, strpos($msg, "Id=") + 3);
                QuickBookSetting::where('quick_books_config_qbo_realm_id', $realmId)->update([$type => $returnId]);
            }
        }
    }
}
