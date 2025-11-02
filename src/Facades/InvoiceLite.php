<?php

namespace SubhashLadumor1\InvoiceLite\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \SubhashLadumor1\InvoiceLite\Services\InvoiceManager make(array $data)
 * @method static \SubhashLadumor1\InvoiceLite\Services\InvoiceManager template(string $template)
 * @method static \SubhashLadumor1\InvoiceLite\Services\InvoiceManager currency(string $currency)
 * @method static \SubhashLadumor1\InvoiceLite\Services\InvoiceManager language(string $language)
 * @method static \SubhashLadumor1\InvoiceLite\Services\InvoiceManager export(string $format)
 * @method static \SubhashLadumor1\InvoiceLite\Services\InvoiceManager save(string $path)
 * @method static string generateShareLink(string $invoiceId, \DateTime|int|null $expiration = null)
 * @method static array getSupportedCurrencies()
 * @method static array getSupportedLanguages()
 * @method static array getSupportedTemplates()
 *
 * @see \SubhashLadumor1\InvoiceLite\Services\InvoiceManager
 */
class InvoiceLite extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'invoicelite';
    }
}