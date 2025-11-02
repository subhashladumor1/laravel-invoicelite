<?php

namespace SubhashLadumor1\InvoiceLite\Services;

class CurrencyFormatter
{
    /**
     * Supported currencies with their symbols and formatting rules
     */
    protected array $currencies = [
        'USD' => ['$' , 2, '.', ','],   // US Dollar
        'EUR' => ['€' , 2, ',', '.'],   // Euro
        'GBP' => ['£' , 2, '.', ','],   // British Pound
        'INR' => ['₹' , 2, '.', ','],   // Indian Rupee
        'JPY' => ['¥' , 0, '.', ','],   // Japanese Yen
        'CAD' => ['C$', 2, '.', ','],   // Canadian Dollar
        'AUD' => ['A$', 2, '.', ','],   // Australian Dollar
        'CHF' => ['CHF', 2, '.', '\''], // Swiss Franc
        'CNY' => ['¥' , 2, '.', ','],   // Chinese Yuan
        'SEK' => ['kr', 2, ',', ' '],   // Swedish Krona
    ];

    /**
     * Format amount according to currency rules
     */
    public function format(float $amount, string $currency): string
    {
        $currency = strtoupper($currency);
        
        if (!isset($this->currencies[$currency])) {
            // Default to USD if currency not supported
            $currency = 'USD';
        }
        
        [$symbol, $decimals, $decimalPoint, $thousandsSeparator] = $this->currencies[$currency];
        
        $formatted = number_format($amount, $decimals, $decimalPoint, $thousandsSeparator);
        
        // Position symbol based on currency (prefix or suffix)
        if (in_array($currency, ['EUR', 'GBP', 'INR', 'JPY', 'CNY'])) {
            return $symbol . $formatted;
        }
        
        return $formatted . ' ' . $symbol;
    }

    /**
     * Get supported currencies
     */
    public function getSupportedCurrencies(): array
    {
        return array_keys($this->currencies);
    }
    
    /**
     * Get currency symbol
     */
    public function getSymbol(string $currency): string
    {
        $currency = strtoupper($currency);
        return $this->currencies[$currency][0] ?? '$';
    }
}