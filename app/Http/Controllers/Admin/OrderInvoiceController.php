<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Products;
use DB;
use App\Http\Traits\QuickBook;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Invoice as InvoiceService;
use App\Models\Invoice;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Crypt;

class OrderInvoiceController extends Controller
{
    use QuickBook;

    /**
     * @var \App\Servicess\Invoice
     */
    protected  $invoiceService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function adminInvoiceDownload($order_id)
    {
        //$dd =$this->getTaxCodeDetails();
        $order = Order::with('user', 'orderitem.product','orderitem.servicepackage','orderitem.workshop','orderitem.studiorental','orderitem.option', 'orderitem.addon')->where('id', $order_id)->first();
        //$orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();

        $invoiceExists = self::ifInvoiceFileExists($order->id);
        if ($invoiceExists['invoice_generated'] && $invoiceExists['invoice_file_exists']) {
            $invoiceDetails = Invoice::where('order_id', $order->id)->first();
            return $this->invoiceResponse($invoiceExists['invoice_generated'], $invoiceExists['invoice_file_exists'], true, false, true, true, true, '', 0, [], [], $invoiceDetails);
            //return $this->invoiceResponse($invoiceExists['invoice_generated'], $invoiceExists['invoice_file_exists'], true);
        }


        $tokenCheck =  $this->setNewAccessToken();
        if (!$tokenCheck) {
            return $this->invoiceResponse(false, false, false);
        }
        sleep(2);

        $quickBookConfig = self::getConfig();
        //$email = $quickBookConfig['quick_books_config_default_customer_email_id'];
        $email = $order->email;

        $customer = $this->getCustomerId($email);

        if ($customer['error'] || !$customer['customer_id']) {
            Log::info('customer not found in quick book!');
            info(json_encode($customer));
            $customer = $this->syncCustomerToQuickBooks($order);
            sleep(5);
            $customer = $this->getCustomerId($email);
            if (!$customer['customer_id']) {
                return  $this->invoiceResponse(false, false, true, $customer['error'], false);
            }
        }

        $customerId = $customer['customer_id'];

        $quickBook = $this->getQuickBookProductsBasedOnOrderItem($order->orderitem);
        if (!$quickBook['product'] || $quickBook['error']) {
            Log::info('Product not found in quick book!');

            $invoice = $this->createInvoice($customerId, [], $order->orderitem, $order);
            if (!$invoice['invoice'] || $invoice['error']) {
                return  $this->invoiceResponse(false, false, true, $invoice['error'], true, true, false, $invoice['message'], $invoice['create_product'], $invoice['missing_products'], $invoice['missing_services']);
            }
        }

        $quickBookProducts = $quickBook['product'];
        $invoice = $this->createInvoice($customerId, $quickBookProducts, $order->orderitem, $order);
        if (!$invoice['invoice'] || $invoice['error']) {
            return  $this->invoiceResponse(false, false, true, $invoice['error'], true, true, false, $invoice['message'], $invoice['create_product'], $invoice['missing_products'], $invoice['missing_services']);
        }

        $invoiceId = $invoice['invoice'];
        $invoiceNumber = $invoice['invoice_number'];

        $filename = NULL;
        $invoice = $this->invoiceService->updateOrCreate($order->id, $invoiceId, $invoiceNumber, $filename);
        if ($invoice) {
            $invoiceExists = self::ifInvoiceFileExists($order->id);
            return $this->downloadInvoiceAndSaveDBANDLocation($order->id, optional($invoice)->quick_book_invoice_id, optional($invoice)->quick_book_invoice_number);
        }
    }

    public function downloadInvoiceAndSaveDBANDLocation($orderId, $invoiceId, $invoiceNumber)
    {
        $filename = $this->downloadInvoiceAndSendLocation($invoiceId);
        $invoice = $this->invoiceService->updateOrCreate($orderId, $invoiceId, $invoiceNumber, $filename);
        if ($invoice) {
            $invoiceExists = self::ifInvoiceFileExists($orderId, $filename);

            $invoiceDetails = Invoice::where('order_id', $orderId)->first();
            return $this->invoiceResponse($invoiceExists['invoice_generated'], $invoiceExists['invoice_file_exists'], true, false, true, true, true, '', 0, [], [], $invoiceDetails);
        }
    }

    public function syncProductsToQuickBooks(Request $request)
    {
        $tokenCheck =  $this->setNewAccessToken();
        if (!$tokenCheck) {
            return $this->invoiceResponse(false, false, false);
        }

        $returnCount = 0;

        $error = false;
        $message = '<ul class="quickbooks_errors">';

        foreach ($request->products as $product) {
            //$productDetails = Products::find($product['id']);
            $orderItem = OrderItem::find($product['id']);
            $productDetails = $this->orderItemDetails($orderItem);
            $return = $this->syncProductToQuickBooks($productDetails);
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

        return response()->json([
            'message' => $message,
            'error' => $error,
            'generate' => ($returnCount > 0) ? false : true
        ]);
    }

    public function printInvoice($orderId)
    {
        $orderId = Crypt::decrypt($orderId);
        $invoice = $this->invoiceService->getInvoice($orderId);
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
