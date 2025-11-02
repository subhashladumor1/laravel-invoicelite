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

        // Ensure company data is set
        if (!isset($this->data['company'])) {
            $this->data['company'] = [
                'name' => config('invoicelite.company.name', 'Your Company Name'),
                'address' => config('invoicelite.company.address', '123 Main Street'),
                'email' => config('invoicelite.company.email', 'info@company.com'),
                'phone' => config('invoicelite.company.phone', '+1 234 567 8900'),
                'website' => config('invoicelite.company.website', 'https://company.com'),
                'logo' => config('invoicelite.company.logo', ''),
            ];
        }

        // Add signature if enabled
        if (config('invoicelite.signature.enabled', false) && !isset($this->data['signature'])) {
            $this->data['signature'] = config('invoicelite.signature.path', '');
        }

        // Make sure all required data is present for templates
        $this->data['tax'] = $this->data['tax'] ?? 0;

        // Render template with format parameter
        $html = $this->templateManager->render($this->template, $this->data, $this->language, $this->format);

        // Export based on format
        switch ($this->format) {
            case 'pdf':
                return $this->pdfExporter->generate($html, $path);
            case 'html':
                return file_put_contents($path, $html) !== false;
            case 'png':
            case 'jpeg':
                // For image export, we need to use a proper image generation library
                return $this->generateImage($html, $path);
            default:
                throw new \InvalidArgumentException("Unsupported export format: {$this->format}");
        }
    }
    
    /**
     * Generate image from HTML content
     */
    protected function generateImage(string $html, string $path): bool
    {
        try {
            // Always generate PDF first, then convert to image
            $tempPdfPath = tempnam(sys_get_temp_dir(), 'invoice_') . '.pdf';
            
            // Generate PDF first
            if ($this->pdfExporter->generate($html, $tempPdfPath)) {
                // Convert PDF to image using Imagick if available
                if (extension_loaded('imagick')) {
                    try {
                        $imagick = new \Imagick();
                        $imagick->setResolution(150, 150);
                        $imagick->readImage($tempPdfPath . '[0]'); // First page only
                        $imagick->setImageFormat($this->format);
                        
                        // Adjust quality for JPEG
                        if ($this->format === 'jpeg') {
                            $imagick->setImageCompressionQuality(90);
                        }
                        
                        // Set proper colorspace
                        $imagick->setImageColorspace(\Imagick::COLORSPACE_RGB);
                        
                        $result = $imagick->writeImage($path);
                        $imagick->clear();
                        $imagick->destroy();
                        
                        // Clean up temporary PDF
                        if (file_exists($tempPdfPath)) {
                            unlink($tempPdfPath);
                        }
                        
                        return $result;
                    } catch (\Exception $e) {
                        // Clean up temporary PDF even if conversion fails
                        if (file_exists($tempPdfPath)) {
                            unlink($tempPdfPath);
                        }
                        return false;
                    }
                } else {
                    // If Imagick is not available, we can't properly convert PDF to image
                    // Clean up temporary PDF
                    if (file_exists($tempPdfPath)) {
                        unlink($tempPdfPath);
                    }
                    return false;
                }
            }
            
            // Clean up temporary PDF if PDF generation failed
            if (file_exists($tempPdfPath)) {
                unlink($tempPdfPath);
            }
            
            return false;
        } catch (\Exception $e) {
            // Log error or handle exception as needed
            return false;
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
        return config('invoicelite.supported_languages', ['en', 'fr', 'de', 'hi', 'es']);
    }

    /**
     * Get supported templates
     */
    public function getSupportedTemplates(): array
    {
        return $this->templateManager->getAvailableTemplates();
    }
}