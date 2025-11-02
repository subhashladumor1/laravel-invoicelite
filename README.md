# Laravel InvoiceLite 🧾

💼 **Laravel InvoiceLite** — Multi-language, multi-country, professional invoice generator with PDF/Image export, templates, taxes & sharing 🚀

[![Latest Version on Packagist](https://img.shields.io/packagist/v/subhashladumor1/laravel-invoicelite.svg?style=flat-square)](https://packagist.org/packages/subhashladumor1/laravel-invoicelite)
[![Total Downloads](https://img.shields.io/packagist/dt/subhashladumor1/laravel-invoicelite.svg?style=flat-square)](https://packagist.org/packages/subhashladumor1/laravel-invoicelite)
[![License](https://img.shields.io/packagist/l/subhashladumor1/laravel-invoicelite.svg?style=flat-square)](https://github.com/subhashladumor1/laravel-invoicelite/blob/main/LICENSE)

---

## 🎯 Introduction

**Laravel InvoiceLite** is a modern, advanced, multi-language 🌍, multi-country 🌎 invoice generator for Laravel applications. It allows developers to quickly generate, customize, export, share, and email invoices with support for multiple countries, languages, and templates.

This package is built for Laravel 10+ and provides a clean, developer-friendly API to generate professional invoices with minimal setup.

---

## ⚡ Features

- 🧮 **Dynamic Invoice Generation** - From arrays, models, or JSON data
- 🌍 **Multi-language Support** - English, French, German, Hindi and more
- 🌐 **Multi-country Tax Systems** - GST, VAT, Sales Tax, etc.
- 🧱 **Pre-built Templates** - Modern, Classic, Minimal designs
- 💾 **Multiple Export Formats** - PDF, Image (PNG/JPEG), HTML
- 📤 **Shareable Links** - Unique signed URLs for invoice sharing
- 🎨 **Custom Branding** - Logo, color, header/footer customization
- 💬 **Localized Templates** - Multi-language using JSON translations
- 💡 **Developer-Friendly** - Single function helper for quick generation
- ⚙️ **Performance Optimized** - Caching and optimization built-in
- 🧑‍💻 **Well Documented** - Comprehensive examples and documentation

---

## 🧩 Installation

You can install the package via composer:

```bash
composer require subhashladumor1/laravel-invoicelite
```

---

## ⚙️ Publish Configuration

Publish the configuration file to customize the package behavior:

```bash
php artisan vendor:publish --tag=invoicelite-config
```

Publish language files for customization:

```bash
php artisan vendor:publish --tag=invoicelite-lang
```

Publish template files for customization:

```bash
php artisan vendor:publish --tag=invoicelite-templates
```

---

## 🧾 Usage Example

```php
use SubhashLadumor1\InvoiceLite\Facades\InvoiceLite;

$data = [
    'invoice_no' => 'INV-2025-001',
    'customer' => ['name' => 'John Doe', 'email' => 'john@example.com'],
    'items' => [
        ['name' => 'Web Development', 'price' => 1200, 'qty' => 1],
        ['name' => 'Hosting', 'price' => 100, 'qty' => 12],
    ],
    'tax' => 18,
    'currency' => 'INR',
    'language' => 'en'
];

InvoiceLite::make($data)
    ->template('modern')
    ->currency('INR')
    ->export('pdf')
    ->save(storage_path('invoices/invoice.pdf'));
```

---

## 🌐 Multi-language Example

```php
InvoiceLite::make($data)
    ->language('fr') // French
    ->template('modern')
    ->export('pdf')
    ->save(storage_path('invoices/invoice-fr.pdf'));
```

Supported languages:
- English (`en`)
- French (`fr`)
- German (`de`)
- Hindi (`hi`)

---

## 🌎 Multi-country Tax Example

```php
$taxCalculator = new \SubhashLadumor1\InvoiceLite\Services\TaxCalculator();

// Get tax rules for India
$indiaTax = $taxCalculator->getCountryTaxRules('IN'); // ['name' => 'GST', 'rate' => 18.0]

// Get tax rules for United States
$usTax = $taxCalculator->getCountryTaxRules('US'); // ['name' => 'Sales Tax', 'rate' => 7.5]

// Use in invoice generation
InvoiceLite::make($data)
    ->template('modern')
    ->export('pdf')
    ->save(storage_path('invoices/invoice-with-tax.pdf'));
```

---

## 🎨 Template Customization Guide

The package comes with three built-in templates:
1. **Modern** - Clean, gradient design with modern aesthetics
2. **Classic** - Traditional invoice layout with borders
3. **Minimal** - Simple, minimalist design

To customize templates:
1. Publish the templates:
   ```bash
   php artisan vendor:publish --tag=invoicelite-templates
   ```
2. Edit the templates in `resources/views/vendor/invoicelite/`

---

## 📤 Invoice Share Link Example

Generate a shareable link for an invoice:

```php
$link = InvoiceLite::generateShareLink('INV-2025-001', now()->addDays(7)); // Expires in 7 days

// Or use default expiration (30 days)
$link = InvoiceLite::generateShareLink('INV-2025-001');
```

---

## ⚙️ Configuration Options

The configuration file allows you to customize:

```php
return [
    'default_template' => 'modern',
    'default_currency' => 'USD',
    'default_language' => 'en',
    'supported_currencies' => ['USD', 'EUR', 'GBP', 'INR', 'JPY', 'CAD', 'AUD', 'CHF', 'CNY', 'SEK'],
    'supported_languages' => ['en', 'fr', 'de', 'hi'],
    'supported_templates' => ['modern', 'classic', 'minimal'],
    'company' => [
        'name' => 'Your Company Name',
        'address' => '123 Main Street, City, Country',
        'email' => 'info@yourcompany.com',
        'phone' => '+1 234 567 8900',
        'website' => 'https://yourcompany.com',
        'logo' => '', // Path to your logo
    ],
    // ... more options
];
```

---

## 🧩 Contributing

Contributions are welcome! Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

---

## 🪪 License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

---

## 🙏 Acknowledgements

- [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) - For PDF generation
- [intervention/image](https://github.com/Intervention/image) - For image processing
- All contributors who have helped shape this package

---

## 📧 Contact

For support or feature requests, please [open an issue](https://github.com/subhashladumor1/laravel-invoicelite/issues) on GitHub.