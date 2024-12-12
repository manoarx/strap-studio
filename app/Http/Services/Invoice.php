<?php

namespace App\Http\Services;

use App\Models\Invoice as InvoiceModel;
use App\Http\Traits\QuickBook;

class Invoice
{
    use QuickBook;
    /**
     * @var \App\Models\Invoice
     */
    protected  $invoiceModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InvoiceModel $invoiceModel)
    {
        $this->invoiceModel = $invoiceModel;
    }

    public function getInvoice($orderId)
    {
        return  $this->invoiceModel->where('order_id', $orderId)->value('file_location') ?? '';
    }

    public function updateOrCreate($orderId, $invoiceId, $invoiceNumber, $filename)
    {
        if ($invoiceId) {
            return $this->invoiceModel->updateOrCreate(
                ['order_id' => $orderId],
                [
                    'quick_book_invoice_id' =>  $invoiceId,
                    'quick_book_invoice_number' =>  $invoiceNumber,
                    'file_location' =>   $filename ?? ''
                ]
            );
        }
        return '';
    }
}
