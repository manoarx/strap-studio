<?php

use Carbon\Carbon;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\OpenGraph;
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


if (! function_exists('seoTool')) {
    function seoTool($title = null, $description = null, $keywords = null, $ogimage = null)
    {
        SEOTools::setTitle($title ?? setting('title'));
        SEOTools::setDescription($description ?? setting('description'));
        SEOTools::setCanonical(url()->current());
        SEOTools::twitter()->setTitle(url()->current());
        SEOTools::twitter()->setSite('@StrapStudios');
        SEOMeta::addKeyword($keywords ?? setting('keyword'));
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'ProfessionalService');
        OpenGraph::addImage($ogimage ?? setting('ogimage'));
        OpenGraph::setDescription($description ?? setting('description'));
        SEOTools::jsonLd()->addImage($ogimage ?? setting('ogimage'));
    }
}
