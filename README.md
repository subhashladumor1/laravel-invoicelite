# Laravel InvoiceLite 🧾

💼 **Laravel InvoiceLite** — Multi-language, multi-country, professional invoice generator with PDF/Image export, templates, taxes & sharing 🚀

[![Latest Version on Packagist](https://img.shields.io/packagist/v/subhashladumor1/laravel-invoicelite.svg?style=flat-square)](https://packagist.org/packages/subhashladumor1/laravel-invoicelite)
[![Total Downloads](https://img.shields.io/packagist/dt/subhashladumor1/laravel-invoicelite.svg?style=flat-square)](https://packagist.org/packages/subhashladumor1/laravel-invoicelite)
[![License](https://img.shields.io/packagist/l/subhashladumor1/laravel-invoicelite.svg?style=flat-square)](https://github.com/subhashladumor1/laravel-invoicelite/blob/main/LICENSE)

---

## 🎯 Introduction

**Laravel InvoiceLite** is a modern, advanced, multi-language 🌍, multi-country 🌎 invoice generator for Laravel applications. It allows developers to quickly generate, customize, export, share, and email invoices with support for multiple countries, languages, and templates.

This package is built for Laravel 10+ and provides a clean, developer-friendly API to generate professional invoices with minimal setup. With support for 30+ languages and multiple currencies, it's perfect for international businesses.

---

## ⚡ Features

- 🧮 **Dynamic Invoice Generation** - From arrays, models, or JSON data
- 🌍 **Multi-language Support** - 30+ popular languages out of the box
- 🌐 **Multi-country Tax Systems** - GST, VAT, Sales Tax, etc.
- 🧱 **Pre-built Templates** - Modern, Classic, Minimal, Business, Corporate designs
- 💾 **Multiple Export Formats** - PDF, Image (PNG/JPEG), HTML
- 📤 **Shareable Links** - Unique signed URLs for invoice sharing
- 🎨 **Custom Branding** - Logo, color, header/footer customization
- 💬 **Localized Templates** - Multi-language using JSON translations
- 💡 **Developer-Friendly** - Single function helper for quick generation
- ⚙️ **Performance Optimized** - Caching and optimization built-in
- 🧑‍💻 **Well Documented** - Comprehensive examples and documentation
- 📧 **Email Integration** - Send invoices directly via email
- 💱 **Automatic Currency Conversion** - Real-time currency conversion
- 🚀 **Fully Customizable** - Extensible and configurable
- 📱 **QR Code Generation** - Automatic QR code for invoice verification
- ✍️ **Digital Signatures** - Add digital signatures to invoices
- 🖼️ **Professional Templates** - Based on modern design principles

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

## 🧾 Basic Usage Example

```php
use SubhashLadumor1\InvoiceLite\Facades\InvoiceLite;

$data = [
    'invoice_no' => 'INV-2025-001',
    'date' => '2025-01-15',
    'due_date' => '2025-02-15',
    'customer' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'address' => '123 Main St, New York, NY 10001',
        'phone' => '+1 234 567 8900'
    ],
    'items' => [
        ['name' => 'Web Development', 'price' => 1200, 'qty' => 1],
        ['name' => 'Hosting (12 months)', 'price' => 100, 'qty' => 12],
    ],
    'tax' => 18,
    'currency' => 'USD',
    'language' => 'en',
    'notes' => 'Thank you for your business. Payment is due within 30 days.',
    'terms' => 'Please make checks payable to Your Company Name. Late payments are subject to a 1.5% monthly finance charge.',
    'signature' => 'https://example.com/signature.png' // Optional digital signature
];

InvoiceLite::make($data)
    ->template('business') // Try our new professional business template!
    ->currency('USD')
    ->export('pdf')
    ->save(storage_path('invoices/invoice.pdf'));
```

---

## 🌐 Multi-language Support (30+ Languages)

Laravel InvoiceLite supports 30+ popular languages out of the box:

| Language | Code | Language | Code |
|----------|------|----------|------|
| English | `en` | Spanish | `es` |
| French | `fr` | Portuguese | `pt` |
| German | `de` | Russian | `ru` |
| Hindi | `hi` | Japanese | `ja` |
| Chinese | `zh` | Korean | `ko` |
| Arabic | `ar` | Italian | `it` |
| Dutch | `nl` | Turkish | `tr` |
| Polish | `pl` | Swedish | `sv` |
| Danish | `da` | Norwegian | `no` |
| Finnish | `fi` | Czech | `cs` |
| Hungarian | `hu` | Romanian | `ro` |
| Bulgarian | `bg` | Greek | `el` |
| Thai | `th` | Vietnamese | `vi` |
| Indonesian | `id` | Malay | `ms` |
| Hebrew | `he` | Ukrainian | `uk` |
| Slovak | `sk` | Croatian | `hr` |
| Lithuanian | `lt` | Latvian | `lv` |

### Multi-language Example

```php
// Generate invoice in Spanish
InvoiceLite::make($data)
    ->language('es')
    ->template('business')
    ->export('pdf')
    ->save(storage_path('invoices/invoice-es.pdf'));

// Generate invoice in Japanese
InvoiceLite::make($data)
    ->language('ja')
    ->template('corporate')
    ->export('pdf')
    ->save(storage_path('invoices/invoice-ja.pdf'));

// Generate invoice in Arabic (RTL support)
InvoiceLite::make($data)
    ->language('ar')
    ->template('modern')
    ->export('pdf')
    ->save(storage_path('invoices/invoice-ar.pdf'));
```

---

## 🎨 Professional Templates

We now offer 5 professional templates:

1. **Modern** - Clean, gradient design with modern aesthetics
2. **Classic** - Traditional invoice layout with borders
3. **Minimal** - Simple, minimalist design
4. **Business** - Professional business template with QR code
5. **Corporate** - Corporate-style template with branding options

---

## 📱 QR Code Generation

All invoices automatically include a QR code for easy verification:

```php
// QR code is automatically generated
InvoiceLite::make($data)
    ->template('business')
    ->export('pdf')
    ->save(storage_path('invoices/invoice-with-qr.pdf'));
```

---

## ✍️ Digital Signatures

Add digital signatures to your invoices:

```php
$data = [
    // ... other data
    'signature' => 'https://yourcompany.com/signature.png'
];

InvoiceLite::make($data)
    ->template('business')
    ->export('pdf')
    ->save(storage_path('invoices/invoice-with-signature.pdf'));
```

---

## 🌎 Multi-country Tax Support

Support for country-specific tax systems:

```php
$taxCalculator = new \SubhashLadumor1\InvoiceLite\Services\TaxCalculator();

// Get tax rules for different countries
$indiaTax = $taxCalculator->getCountryTaxRules('IN');    // India - GST (18%)
$ukTax = $taxCalculator->getCountryTaxRules('GB');       // UK - VAT (20%)
$germanyTax = $taxCalculator->getCountryTaxRules('DE');  // Germany - VAT (19%)
$usaTax = $taxCalculator->getCountryTaxRules('US');      // USA - Sales Tax (7.5%)
$canadaTax = $taxCalculator->getCountryTaxRules('CA');   // Canada - HST/GST (5%)
$australiaTax = $taxCalculator->getCountryTaxRules('AU'); // Australia - GST (10%)

// Use country-specific tax in invoice generation
InvoiceLite::make($data)
    ->template('corporate')
    ->export('pdf')
    ->save(storage_path('invoices/invoice-with-uk-tax.pdf'));
```

---

## 💾 Multiple Export Formats

### PDF Export (Default)
```php
InvoiceLite::make($data)
    ->template('business')
    ->export('pdf')
    ->save(storage_path('invoices/invoice.pdf'));
```

### HTML Export
```php
InvoiceLite::make($data)
    ->template('business')
    ->export('html')
    ->save(storage_path('invoices/invoice.html'));
```

### Image Export (PNG/JPEG)
```php
// PNG export
InvoiceLite::make($data)
    ->template('business')
    ->export('png')
    ->save(storage_path('invoices/invoice.png'));

// JPEG export
InvoiceLite::make($data)
    ->template('business')
    ->export('jpeg')
    ->save(storage_path('invoices/invoice.jpeg'));
```

---

## 📤 Shareable Invoice Links

Generate secure, time-limited shareable links for invoices:

```php
// Generate a link that expires in 7 days
$link = InvoiceLite::generateShareLink('INV-2025-001', now()->addDays(7));

// Generate a link that expires in 30 days (default)
$link = InvoiceLite::generateShareLink('INV-2025-001');

// Generate a link that expires in 24 hours
$link = InvoiceLite::generateShareLink('INV-2025-001', 24); // 24 hours

// Generate a link that expires on a specific date
$link = InvoiceLite::generateShareLink('INV-2025-001', now()->addMonths(3)); // 3 months
```

---

## 💱 Currency Support

Support for 20+ international currencies:

```php
// USD - US Dollar
InvoiceLite::make($data)->currency('USD');

// EUR - Euro
InvoiceLite::make($data)->currency('EUR');

// GBP - British Pound
InvoiceLite::make($data)->currency('GBP');

// INR - Indian Rupee
InvoiceLite::make($data)->currency('INR');

// JPY - Japanese Yen
InvoiceLite::make($data)->currency('JPY');

// CAD - Canadian Dollar
InvoiceLite::make($data)->currency('CAD');

// AUD - Australian Dollar
InvoiceLite::make($data)->currency('AUD');

// CHF - Swiss Franc
InvoiceLite::make($data)->currency('CHF');

// CNY - Chinese Yuan
InvoiceLite::make($data)->currency('CNY');

// And 10+ more currencies...
```

---

## 🧾 Advanced Usage Examples

### Multiple Invoices Batch Generation

```php
$invoices = [
    [
        'invoice_no' => 'INV-2025-001',
        'customer' => ['name' => 'John Doe', 'email' => 'john@example.com'],
        'items' => [
            ['name' => 'Web Development', 'price' => 1200, 'qty' => 1],
            ['name' => 'Hosting', 'price' => 100, 'qty' => 12],
        ],
        'tax' => 18,
        'currency' => 'USD',
        'language' => 'en'
    ],
    [
        'invoice_no' => 'INV-2025-002',
        'customer' => ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
        'items' => [
            ['name' => 'Consulting', 'price' => 800, 'qty' => 5],
            ['name' => 'Training', 'price' => 200, 'qty' => 3],
        ],
        'tax' => 15,
        'currency' => 'EUR',
        'language' => 'fr'
    ]
];

foreach ($invoices as $invoiceData) {
    InvoiceLite::make($invoiceData)
        ->template('business')
        ->export('pdf')
        ->save(storage_path("invoices/{$invoiceData['invoice_no']}.pdf"));
}
```

### Email Invoice Directly

```php
use Illuminate\Support\Facades\Mail;
use SubhashLadumor1\InvoiceLite\Facades\InvoiceLite;

// Generate invoice
$invoicePath = storage_path('invoices/invoice.pdf');
InvoiceLite::make($data)
    ->template('business')
    ->export('pdf')
    ->save($invoicePath);

// Send via email
Mail::send('emails.invoice', ['data' => $data], function ($message) use ($data, $invoicePath) {
    $message->to($data['customer']['email'])
            ->subject("Invoice {$data['invoice_no']}")
            ->attach($invoicePath);
});
```

---

## ⚙️ Configuration Options

The configuration file allows extensive customization:

```php
return [
    'default_template' => 'business',
    'default_currency' => 'USD',
    'default_language' => 'en',
    'supported_currencies' => [
        'USD', 'EUR', 'GBP', 'INR', 'JPY', 'CAD', 'AUD', 'CHF', 'CNY', 'SEK',
        'NZD', 'MXN', 'SGD', 'HKD', 'NOK', 'KRW', 'TRY', 'RUB', 'BRL', 'ZAR'
    ],
    'supported_languages' => [
        'en', 'fr', 'de', 'hi', 'es', 'pt', 'ru', 'ja', 'zh', 'ko', 
        'ar', 'it', 'nl', 'tr', 'pl', 'sv', 'da', 'no', 'fi', 'cs',
        'hu', 'ro', 'bg', 'el', 'th', 'vi', 'id', 'ms', 'he', 'uk',
        'sk', 'hr', 'lt', 'lv'
    ],
    'supported_templates' => ['modern', 'classic', 'minimal', 'business', 'corporate'],
    'company' => [
        'name' => 'Your Company Name',
        'address' => '123 Main Street, City, Country',
        'email' => 'info@yourcompany.com',
        'phone' => '+1 234 567 8900',
        'website' => 'https://yourcompany.com',
        'logo' => '', // Path to your logo
    ],
    'tax' => [
        'default_rate' => 0.0,
        'display_tax_breakdown' => true,
    ],
    'invoice_number' => [
        'prefix' => 'INV-',
        'length' => 8,
        'reset_yearly' => true,
    ],
    'share_links' => [
        'expire_days' => 30,
        'route_prefix' => 'invoice',
    ],
    'qr_code' => [
        'enabled' => true,
        'size' => 100,
        'format' => 'png',
    ],
    'signature' => [
        'enabled' => false,
        'path' => '', // Path to signature image
    ],
];
```

---

## 🧩 Helper Functions

The package provides several helpful global functions:

```php
// Generate an invoice using the helper
invoice_lite()->make($data)->template('business')->export('pdf')->save($path);

// Format currency
echo format_currency(1234.56, 'USD'); // $1,234.56
echo format_currency(1234.56, 'EUR'); // €1.234,56
echo format_currency(1234.56, 'JPY'); // ¥1,235

// Calculate tax
$taxAmount = calculate_tax(1000, 18); // 180.0
```

---

## 🧪 Testing

To run tests for the package:

```bash
composer test
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
- [simplesoftwareio/simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode) - For QR code generation
- All contributors who have helped shape this package

---

## 📧 Contact

For support or feature requests, please [open an issue](https://github.com/subhashladumor1/laravel-invoicelite/issues) on GitHub.
