<?php

namespace SubhashLadumor1\InvoiceLite\Contracts;

interface InvoiceGeneratorInterface
{
    /**
     * Create a new invoice instance with data
     */
    public function make(array $data): self;

    /**
     * Set the template for the invoice
     */
    public function template(string $template): self;

    /**
     * Set the currency for the invoice
     */
    public function currency(string $currency): self;

    /**
     * Set the language for the invoice
     */
    public function language(string $language): self;

    /**
     * Export the invoice in the specified format
     */
    public function export(string $format): self;

    /**
     * Save the exported invoice to a file
     */
    public function save(string $path): bool;

    /**
     * Generate a shareable link for the invoice
     */
    public function generateShareLink(string $invoiceId, \DateTime|int|null $expiration = null): string;

    /**
     * Get supported currencies
     */
    public function getSupportedCurrencies(): array;

    /**
     * Get supported languages
     */
    public function getSupportedLanguages(): array;

    /**
     * Get supported templates
     */
    public function getSupportedTemplates(): array;
}