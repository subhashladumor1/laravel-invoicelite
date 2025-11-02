<?php

namespace SubhashLadumor1\InvoiceLite\Services;

use SubhashLadumor1\InvoiceLite\Contracts\InvoiceGeneratorInterface;
use SubhashLadumor1\InvoiceLite\Support\PDFExporter;

class InvoiceManager implements InvoiceGeneratorInterface
{
    protected array $data = [];
    protected string $template = 'modern';
    protected string $currency = 'USD';
    protected string $language = 'en';
    protected string $format = 'pdf';
    
    protected TemplateManager $templateManager;
    protected CurrencyFormatter $currencyFormatter;
    protected TaxCalculator $taxCalculator;
    protected ShareLinkManager $shareLinkManager;
    protected PDFExporter $pdfExporter;

    public function __construct(
        TemplateManager $templateManager,
        CurrencyFormatter $currencyFormatter,
        TaxCalculator $taxCalculator,
        ShareLinkManager $shareLinkManager,
        PDFExporter $pdfExporter
    ) {
        $this->templateManager = $templateManager;
        $this->currencyFormatter = $currencyFormatter;
        $this->taxCalculator = $taxCalculator;
        $this->shareLinkManager = $shareLinkManager;
        $this->pdfExporter = $pdfExporter;
    }

    /**
     * Create a new invoice instance with data
     */
    public function make(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set the template for the invoice
     */
    public function template(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Set the currency for the invoice
     */
    public function currency(string $currency): self
    {
        $this->currency = strtoupper($currency);
        return $this;
    }

    /**
     * Set the language for the invoice
     */
    public function language(string $language): self
    {
        $this->language = strtolower($language);
        return $this;
    }

    /**
     * Export the invoice in the specified format
     */
    public function export(string $format): self
    {
        $this->format = strtolower($format);
        return $this;
    }

    /**
     * Save the exported invoice to a file
     */
    public function save(string $path): bool
    {
        // Process data with tax calculations
        if (isset($this->data['items']) && isset($this->data['tax'])) {
            $this->data['items'] = $this->taxCalculator->calculateItemsTax(
                $this->data['items'], 
                $this->data['tax']
            );
            
            $this->data['subtotal'] = $this->taxCalculator->calculateSubtotal($this->data['items']);
            $this->data['tax_amount'] = $this->taxCalculator->calculateTaxAmount(
                $this->data['subtotal'], 
                $this->data['tax']
            );
            $this->data['total'] = $this->taxCalculator->calculateTotal(
                $this->data['subtotal'], 
                $this->data['tax_amount']
            );
        }

        // Format currency
        if (isset($this->data['total'])) {
            $this->data['formatted_total'] = $this->currencyFormatter->format(
                $this->data['total'], 
                $this->currency
            );
        }

        // Render template
        $html = $this->templateManager->render($this->template, $this->data, $this->language);

        // Export based on format
        switch ($this->format) {
            case 'pdf':
                return $this->pdfExporter->generate($html, $path);
            case 'html':
                return file_put_contents($path, $html) !== false;
            case 'png':
            case 'jpeg':
                // For image export, we would use Intervention Image package
                // This is a simplified implementation
                return file_put_contents($path, $html) !== false;
            default:
                throw new \InvalidArgumentException("Unsupported export format: {$this->format}");
        }
    }

    /**
     * Generate a shareable link for the invoice
     */
    public function generateShareLink(string $invoiceId, \DateTime|int|null $expiration = null): string
    {
        return $this->shareLinkManager->generate($invoiceId, $expiration);
    }

    /**
     * Get supported currencies
     */
    public function getSupportedCurrencies(): array
    {
        return $this->currencyFormatter->getSupportedCurrencies();
    }

    /**
     * Get supported languages
     */
    public function getSupportedLanguages(): array
    {
        return ['en', 'fr', 'de', 'hi'];
    }

    /**
     * Get supported templates
     */
    public function getSupportedTemplates(): array
    {
        return $this->templateManager->getAvailableTemplates();
    }
}