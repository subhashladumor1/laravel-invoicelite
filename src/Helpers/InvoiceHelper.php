<?php

if (!function_exists('invoice_lite')) {
    /**
     * Helper function to access the InvoiceLite service
     */
    function invoice_lite(): \SubhashLadumor1\InvoiceLite\Services\InvoiceManager
    {
        return app('invoicelite');
    }
}

if (!function_exists('format_currency')) {
    /**
     * Helper function to format currency
     */
    function format_currency(float $amount, string $currency): string
    {
        return app('invoicelite.currency')->format($amount, $currency);
    }
}

if (!function_exists('calculate_tax')) {
    /**
     * Helper function to calculate tax
     */
    function calculate_tax(float $amount, float $taxRate): float
    {
        return app('invoicelite.tax')->calculateTaxAmount($amount, $taxRate);
    }
}