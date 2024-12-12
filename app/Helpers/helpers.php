<?php

use Carbon\Carbon;
use Facades\App\Http\Services\Invoice as InvoiceFacades;

/**
 * Write code on Method
 *
 * @return response()
 */

if (!function_exists('invoiceButtonText')) {
    function invoiceButtonText($orderId)
    {
        $detils =  InvoiceFacades::ifInvoiceFileExists($orderId);
        if (isset($detils['invoice_file_exists']) && $detils['invoice_file_exists']) {
            return 'Download';
        }
        return 'Generate';
    }
}
