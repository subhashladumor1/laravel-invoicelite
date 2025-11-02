<?php

namespace SubhashLadumor1\InvoiceLite\Services;

class TaxCalculator
{
    /**
     * Calculate tax for each item
     */
    public function calculateItemsTax(array $items, float $taxRate): array
    {
        foreach ($items as &$item) {
            $item['tax_rate'] = $taxRate;
            $item['tax_amount'] = $this->calculateTaxAmount($item['price'] * $item['qty'], $taxRate);
            $item['total'] = ($item['price'] * $item['qty']) + $item['tax_amount'];
        }
        
        return $items;
    }

    /**
     * Calculate subtotal from items
     */
    public function calculateSubtotal(array $items): float
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += ($item['price'] ?? 0) * ($item['qty'] ?? 1);
        }
        return $subtotal;
    }

    /**
     * Calculate tax amount
     */
    public function calculateTaxAmount(float $amount, float $taxRate): float
    {
        return $amount * ($taxRate / 100);
    }

    /**
     * Calculate total amount
     */
    public function calculateTotal(float $subtotal, float $taxAmount): float
    {
        return $subtotal + $taxAmount;
    }

    /**
     * Get country-specific tax rules
     */
    public function getCountryTaxRules(string $countryCode): array
    {
        $taxRules = [
            'IN' => ['name' => 'GST', 'rate' => 18.0],      // India - GST
            'US' => ['name' => 'Sales Tax', 'rate' => 7.5], // USA - Sales Tax (varies by state)
            'GB' => ['name' => 'VAT', 'rate' => 20.0],      // UK - VAT
            'DE' => ['name' => 'VAT', 'rate' => 19.0],      // Germany - VAT
            'FR' => ['name' => 'VAT', 'rate' => 20.0],      // France - VAT
            'CA' => ['name' => 'HST/GST', 'rate' => 5.0],   // Canada - Federal GST
            'AU' => ['name' => 'GST', 'rate' => 10.0],      // Australia - GST
        ];
        
        return $taxRules[strtoupper($countryCode)] ?? ['name' => 'Tax', 'rate' => 0.0];
    }
}