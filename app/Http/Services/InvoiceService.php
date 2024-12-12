<?php

namespace App\Http\Services;

use App\Http\Services\Invoice;
use App\Http\Traits\QuickBook;
use App\Models\Invoice as ModelsInvoice;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    use QuickBook;

    /**
     * @var \App\Servicess\Invoice
     */
    protected  $invoiceS;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoiceS)
    {
        $this->invoiceS = $invoiceS;
    }

    public function adminInvoiceDownload($order_id)
    {

        $order = Order::with('user', 'orderitem.product', 'orderitem.servicepackage', 'orderitem.workshop', 'orderitem.studiorental', 'orderitem.option', 'orderitem.addon')->where('id', $order_id)->first();

        $invoiceExists = self::ifInvoiceFileExists($order->id);
        if ($invoiceExists['invoice_generated'] && $invoiceExists['invoice_file_exists']) {
            //$invoiceDetails = ModelsInvoice::where('order_id', $order->id)->first();
            //return $this->invoiceResponse($invoiceExists['invoice_generated'], $invoiceExists['invoice_file_exists'], true, false, true, true, true, '', 0, [], [], $invoiceDetails);
            //return $this->invoiceResponse($invoiceExists['invoice_generated'], $invoiceExists['invoice_file_exists'], true);
        }


        $tokenCheck =  $this->setNewAccessToken();
        if (!$tokenCheck) {
            Log::info('Token issue');
            return '';
        }
        sleep(2);

        $email = $order->email;

        $customer = $this->getCustomerId($email);

        if ($customer['error'] || !$customer['customer_id']) {
            Log::info('customer not found in quick book!');
            info(json_encode($customer));
            $customer = $this->syncCustomerToQuickBooks($order);
            sleep(5);
            $customer = $this->getCustomerId($email);
            if (!$customer['customer_id']) {
                Log::info('customer creation issue!');
                return '';
            }
        }

        $customerId = $customer['customer_id'];

        $quickBook = $this->getQuickBookProductsBasedOnOrderItem($order->orderitem);
        if (!$quickBook['product'] || $quickBook['error']) {
            Log::info('Product not found in quick book!');

            $invoice = $this->createInvoice($customerId, [], $order->orderitem, $order);
            if (!$invoice['invoice'] || $invoice['error']) {
                $this->syncProductsToQuickBooks($invoice['missing_products']);
                sleep(5);
                $quickBook = $this->getQuickBookProductsBasedOnOrderItem($order->orderitem);
            }
        }

        $quickBookProducts = $quickBook['product'];
        $invoice = $this->createInvoice($customerId, $quickBookProducts, $order->orderitem, $order);
        if (!$invoice['invoice'] || $invoice['error']) {
            Log::info('after sync issue!');
            return '';
        }

        $invoiceId = $invoice['invoice'];
        $invoiceNumber = $invoice['invoice_number'];

        $filename = NULL;
        $invoice = $this->invoiceS->updateOrCreate($order->id, $invoiceId, $invoiceNumber, $filename);
        if ($invoice) {
            $invoiceExists = self::ifInvoiceFileExists($order->id);
            return $this->downloadInvoiceAndSaveDBANDLocation($order->id, optional($invoice)->quick_book_invoice_id, optional($invoice)->quick_book_invoice_number);
        }
    }

    public function downloadInvoiceAndSaveDBANDLocation($orderId, $invoiceId, $invoiceNumber)
    {
        $filename = $this->downloadInvoiceAndSendLocation($invoiceId);
        $invoice = $this->invoiceS->updateOrCreate($orderId, $invoiceId, $invoiceNumber, $filename);
        if ($invoice) {
            $invoiceExists = self::ifInvoiceFileExists($orderId, $filename);

            $invoiceDetails = ModelsInvoice::where('order_id', $orderId)->first();
            return $this->invoiceResponse($invoiceExists['invoice_generated'], $invoiceExists['invoice_file_exists'], true, false, true, true, true, '', 0, [], [], $invoiceDetails);
        }
    }

    public function syncProductsToQuickBooks($products)
    {
        $tokenCheck =  $this->setNewAccessToken();
        if (!$tokenCheck) {
            return $this->invoiceResponse(false, false, false);
        }

        $returnCount = 0;

        $error = false;
        $message = '<ul class="quickbooks_errors">';

        foreach ($products as $product) {
            //$productDetails = Products::find($product['id']);
            $orderItem = OrderItem::find($product['id']);
            $productDetails = $this->orderItemDetails($orderItem);
            $return = $this->syncProductToQuickBooks($productDetails);
            sleep(3);
            if (!$return['status']) {
                $returnCount = (int) $returnCount + 1;
                $message =  $message . '<li>' . optional($productDetails)->name . ' - ' . str_replace("Name", "UPC", $return['message']) . '</li>';
                $error = true;
            }
        }

        if (!$error) {
            $message = $message . '<li>Product(s) sync successfully</li>';
        }
        $message = $message . '</ul>';

        return '';

        // return response()->json([
        //     'message' => $message,
        //     'error' => $error,
        //     'generate' => ($returnCount > 0) ? false : true
        // ]);
    }

    public function printInvoice($orderId)
    {
        $orderId = Crypt::decrypt($orderId);
        $invoice = $this->invoiceS->getInvoice($orderId);
        if ($invoice) {
            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=filename.pdf");
            @readfile('storage/invoice/' . $invoice);
        } else {
            return redirect(url('/admin'));
        }
    }

    protected function invoiceResponse(
        $invoiceExists = true,
        $invoiceFileExists = false,
        $token = false,
        $error = false,
        $customer = true,
        $product = true,
        $invoiceCreate = true,
        $message = '',
        $syncProduct = 0,
        $missingProducts = [],
        $missingServices = [],
        $invoice = []
    ) {
        return response()->json([
            'invoice_exists' => $invoiceExists,
            'invoice_file_exists' => $invoiceFileExists,
            'token' => $token,
            'customer' => $customer,
            'product' => $product,
            'invoice_create' => $invoiceCreate,
            'error' => $error,
            'message' => $message,
            'sync_product' => $syncProduct,
            'missing_products' => $missingProducts,
            'missing_services' => $missingServices,
            'invoice' => $invoice,
        ]);
    }
}
