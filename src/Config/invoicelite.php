<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Template
    |--------------------------------------------------------------------------
    |
    | This option controls the default template that will be used when
    | generating invoices. You can change this to 'classic' or 'minimal'.
    |
    */
    'default_template' => 'modern',

    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | This option controls the default currency that will be used when
    | generating invoices. You can change this to any supported currency.
    |
    */
    'default_currency' => 'USD',

    /*
    |--------------------------------------------------------------------------
    | Default Language
    |--------------------------------------------------------------------------
    |
    | This option controls the default language that will be used when
    | generating invoices. You can change this to any supported language.
    |
    */
    'default_language' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Supported Currencies
    |--------------------------------------------------------------------------
    |
    | Here you can define all the supported currencies for your invoices.
    |
    */
    'supported_currencies' => [
        'USD', 'EUR', 'GBP', 'INR', 'JPY', 'CAD', 'AUD', 'CHF', 'CNY', 'SEK'
    ],

    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    |
    | Here you can define all the supported languages for your invoices.
    |
    */
    'supported_languages' => [
        'en', 'fr', 'de', 'hi'
    ],

    /*
    |--------------------------------------------------------------------------
    | Supported Templates
    |--------------------------------------------------------------------------
    |
    | Here you can define all the supported templates for your invoices.
    |
    */
    'supported_templates' => [
        'modern', 'classic', 'minimal'
    ],

    /*
    |--------------------------------------------------------------------------
    | Company Details
    |--------------------------------------------------------------------------
    |
    | Here you can define your company details that will be used in invoices.
    |
    */
    'company' => [
        'name' => 'Your Company Name',
        'address' => '123 Main Street, City, Country',
        'email' => 'info@yourcompany.com',
        'phone' => '+1 234 567 8900',
        'website' => 'https://yourcompany.com',
        'logo' => '', // Path to your logo
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax Settings
    |--------------------------------------------------------------------------
    |
    | Configure default tax settings for your invoices.
    |
    */
    'tax' => [
        'default_rate' => 0.0,
        'display_tax_breakdown' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice Number Settings
    |--------------------------------------------------------------------------
    |
    | Configure how invoice numbers are generated.
    |
    */
    'invoice_number' => [
        'prefix' => 'INV-',
        'length' => 8,
        'reset_yearly' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Share Link Settings
    |--------------------------------------------------------------------------
    |
    | Configure settings for shareable invoice links.
    |
    */
    'share_links' => [
        'expire_days' => 30,
        'route_prefix' => 'invoice',
    ],
];