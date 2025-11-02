<?php

namespace SubhashLadumor1\InvoiceLite\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;

class TemplateManager
{
    /**
     * Render the invoice template with data
     */
    public function render(string $template, array $data, string $language = 'en', string $format = 'html'): string
    {
        // Set the application locale
        app()->setLocale($language);
        
        // Ensure required data is present
        $data = array_merge([
            'invoice_no' => '',
            'date' => date('Y-m-d'),
            'due_date' => date('Y-m-d', strtotime('+30 days')),
            'customer' => [
                'name' => '',
                'email' => '',
                'address' => '',
                'phone' => ''
            ],
            'company' => [
                'name' => config('invoicelite.company.name', 'Your Company Name'),
                'address' => config('invoicelite.company.address', '123 Main Street'),
                'email' => config('invoicelite.company.email', 'info@company.com'),
                'phone' => config('invoicelite.company.phone', '+1 234 567 8900'),
                'website' => config('invoicelite.company.website', 'https://company.com'),
                'logo' => config('invoicelite.company.logo', ''),
            ],
            'items' => [],
            'subtotal' => 0,
            'tax' => 0,
            'tax_amount' => 0,
            'total' => 0,
            'formatted_total' => '$0.00',
            'currency' => config('invoicelite.default_currency', 'USD'),
            'notes' => '',
            'terms' => '',
            'signature' => '',
            'qr_code' => ''
        ], $data);
        
        // Convert images to base64 for PDF/image export
        if ($format !== 'html') {
            $data['company']['logo'] = $this->convertToBase64($data['company']['logo'] ?? '');
            $data['signature'] = $this->convertToBase64($data['signature'] ?? '');
        }
        
        // Generate QR code for the invoice using alternative method
        $data['qr_code'] = $this->generateQRCodeAlternative($data);
        
        // Generate items table HTML for both View system and fallback
        $data['itemsHtml'] = $this->generateItemsHtml($data['items'] ?? []);
        
        // Try to render using Laravel's view system
        try {
            // Check if custom template exists
            $viewName = "invoicelite::{$template}";
            if (!View::exists($viewName)) {
                // Fallback to modern template
                $viewName = 'invoicelite::modern';
            }
            
            // Render the view with data
            return View::make($viewName, $data)->render();
        } catch (\Exception $e) {
            // Fallback to file-based rendering if View system fails
            return $this->renderFromFile($template, $data, $format);
        }
    }
    
    /**
     * Generate QR code using alternative method (fallback if package not available)
     */
    protected function generateQRCodeAlternative(array $data): string
    {
        // First try the proper QR code package
        if (class_exists('\SimpleSoftwareIO\QrCode\Facades\QrCode')) {
            try {
                $qrData = "Invoice: {$data['invoice_no']}\n";
                $qrData .= "Amount: {$data['formatted_total']}\n";
                $qrData .= "Date: {$data['date']}\n";
                $qrData .= "Company: {$data['company']['name']}\n";
                $qrData .= "Customer: {$data['customer']['name']}";
                
                // Generate QR code
                $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($qrData);
                
                // Convert to base64 for all formats
                return base64_encode($qrCode);
            } catch (\Exception $e) {
                // If QR code generation fails, fall back to alternative method
                return $this->generatePlaceholderQRCode($data);
            }
        }
        
        // If package not available, generate a placeholder
        return $this->generatePlaceholderQRCode($data);
    }
    
    /**
     * Generate a placeholder QR code as fallback
     */
    protected function generatePlaceholderQRCode(array $data): string
    {
        // Create a simple SVG placeholder that looks like a QR code
        $invoiceInfo = "INV:{$data['invoice_no']}|AMT:{$data['formatted_total']}|DATE:{$data['date']}";
        
        // Simple SVG that looks like a QR code
        $svg = '<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">';
        $svg .= '<rect width="100" height="100" fill="#000"/>';
        $svg .= '<rect x="10" y="10" width="20" height="20" fill="#fff"/>';
        $svg .= '<rect x="40" y="10" width="20" height="20" fill="#fff"/>';
        $svg .= '<rect x="70" y="10" width="20" height="20" fill="#fff"/>';
        $svg .= '<rect x="10" y="40" width="20" height="20" fill="#fff"/>';
        $svg .= '<rect x="40" y="40" width="20" height="20" fill="#fff"/>';
        $svg .= '<rect x="70" y="40" width="20" height="20" fill="#fff"/>';
        $svg .= '<rect x="10" y="70" width="20" height="20" fill="#fff"/>';
        $svg .= '<rect x="40" y="70" width="20" height="20" fill="#fff"/>';
        $svg .= '<rect x="70" y="70" width="20" height="20" fill="#fff"/>';
        $svg .= '</svg>';
        
        // Convert SVG to base64
        return base64_encode($svg);
    }
    
    /**
     * Convert image path/URL to base64 data URL
     */
    public function convertToBase64(string $imagePath): string
    {
        if (empty($imagePath)) {
            return '';
        }
        
        // If it's already a data URL, return as is
        if (strpos($imagePath, 'data:image') === 0) {
            return $imagePath;
        }
        
        try {
            // Handle local file paths
            if (file_exists($imagePath)) {
                $type = pathinfo($imagePath, PATHINFO_EXTENSION);
                if (empty($type)) {
                    $type = 'png'; // Default to PNG
                }
                $data = file_get_contents($imagePath);
                if ($data !== false) {
                    return 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
            }
            
            // Handle URLs
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $imageData = @file_get_contents($imagePath);
                if ($imageData !== false) {
                    // Try to determine image type from headers or content
                    $headers = @get_headers($imagePath, 1);
                    $contentType = is_array($headers) && isset($headers['Content-Type']) ? $headers['Content-Type'] : '';
                    
                    if (is_array($contentType)) {
                        $contentType = end($contentType);
                    }
                    
                    if (strpos($contentType, 'image/') !== false) {
                        $type = str_replace('image/', '', $contentType);
                    } else {
                        // Fallback to guessing from content
                        $imageInfo = @getimagesizefromstring($imageData);
                        if ($imageInfo !== false) {
                            $type = image_type_to_extension($imageInfo[2], false);
                        } else {
                            $type = 'png'; // Default to PNG
                        }
                    }
                    
                    return 'data:image/' . $type . ';base64,' . base64_encode($imageData);
                }
            }
        } catch (\Exception $e) {
            // If anything fails, return empty string
            return '';
        }
        
        return '';
    }
    
    /**
     * Generate HTML for items table
     */
    public function generateItemsHtml(array $items): string
    {
        $itemsHtml = '';
        if (isset($items) && is_array($items)) {
            foreach ($items as $item) {
                $itemName = $item['name'] ?? '';
                $itemQty = $item['qty'] ?? 0;
                $itemPrice = $item['price'] ?? 0;
                $itemTotal = (($item['price'] ?? 0) * ($item['qty'] ?? 1));
                
                $itemsHtml .= "<tr>";
                $itemsHtml .= "<td style=\"padding: 12px; border-bottom: 1px solid #eee;\">{$itemName}</td>";
                $itemsHtml .= "<td style=\"padding: 12px; border-bottom: 1px solid #eee;\">{$itemQty}</td>";
                $itemsHtml .= "<td style=\"padding: 12px; border-bottom: 1px solid #eee;\">" . number_format($itemPrice, 2) . "</td>";
                $itemsHtml .= "<td style=\"padding: 12px; border-bottom: 1px solid #eee;\">" . number_format($itemTotal, 2) . "</td>";
                $itemsHtml .= "</tr>";
            }
        }
        return $itemsHtml;
    }
    
    /**
     * Fallback rendering method using file content
     */
    protected function renderFromFile(string $template, array $data, string $format = 'html'): string
    {
        $templatePath = __DIR__."/../Templates/{$template}.blade.php";
        
        // Check if custom template exists in published views
        $publishedTemplate = resource_path("views/vendor/invoicelite/{$template}.blade.php");
        if (file_exists($publishedTemplate)) {
            $templatePath = $publishedTemplate;
        }
        
        // If template doesn't exist, fallback to modern
        if (!file_exists($templatePath)) {
            $templatePath = __DIR__.'/../Templates/modern.blade.php';
        }
        
        // Simulate rendering by replacing placeholders
        $content = file_get_contents($templatePath);
        
        // Replace basic placeholders
        $content = str_replace('{{ $invoice_no }}', $data['invoice_no'] ?? '', $content);
        $content = str_replace('{{ $date }}', $data['date'] ?? date('Y-m-d'), $content);
        $content = str_replace('{{ $due_date }}', $data['due_date'] ?? date('Y-m-d', strtotime('+30 days')), $content);
        $content = str_replace('{{ $customer.name }}', $data['customer']['name'] ?? '', $content);
        $content = str_replace('{{ $customer.email }}', $data['customer']['email'] ?? '', $content);
        $content = str_replace('{{ $customer.address }}', $data['customer']['address'] ?? '', $content);
        $content = str_replace('{{ $customer.phone }}', $data['customer']['phone'] ?? '', $content);
        
        // Company information
        $content = str_replace('{{ $company.name }}', $data['company']['name'] ?? '', $content);
        $content = str_replace('{{ $company.address }}', $data['company']['address'] ?? '', $content);
        $content = str_replace('{{ $company.email }}', $data['company']['email'] ?? '', $content);
        $content = str_replace('{{ $company.phone }}', $data['company']['phone'] ?? '', $content);
        $content = str_replace('{{ $company.website }}', $data['company']['website'] ?? '', $content);
        
        // Handle company logo for different formats
        if ($format !== 'html' && !empty($data['company']['logo'])) {
            $content = str_replace('{{ $company.logo }}', $this->convertToBase64($data['company']['logo']), $content);
        } else {
            $content = str_replace('{{ $company.logo }}', $data['company']['logo'] ?? '', $content);
        }
        
        // Tax information
        $content = str_replace('{{ $tax }}', $data['tax'] ?? 0, $content);
        
        // Add items table
        $content = str_replace('{!! $itemsHtml !!}', $data['itemsHtml'] ?? '', $content);
        
        // Replace totals with proper formatting
        $content = str_replace('{{ $subtotal }}', number_format($data['subtotal'] ?? 0, 2), $content);
        $content = str_replace('{{ $tax_amount }}', number_format($data['tax_amount'] ?? 0, 2), $content);
        $content = str_replace('{{ $total }}', number_format($data['total'] ?? 0, 2), $content);
        $content = str_replace('{{ $formatted_total }}', $data['formatted_total'] ?? '', $content);
        $content = str_replace('{{ $notes }}', $data['notes'] ?? '', $content);
        $content = str_replace('{{ $terms }}', $data['terms'] ?? '', $content);
        
        // Handle signature for different formats
        if ($format !== 'html' && !empty($data['signature'])) {
            $content = str_replace('{{ $signature }}', $this->convertToBase64($data['signature']), $content);
        } else {
            $content = str_replace('{{ $signature }}', $data['signature'] ?? '', $content);
        }
        
        // QR Code - handle both cases in templates
        if (!empty($data['qr_code'])) {
            // Replace the full data URL
            $content = str_replace('data:image/png;base64,{{ $qr_code }}', 'data:image/png;base64,' . $data['qr_code'], $content);
            // Also replace just the variable for templates that might use it differently
            $content = str_replace('{{ $qr_code }}', $data['qr_code'], $content);
        } else {
            $content = str_replace('data:image/png;base64,{{ $qr_code }}', '', $content);
            $content = str_replace('<img src="data:image/png;base64,{{ $qr_code }}"', '<!-- QR Code placeholder -->', $content);
            $content = str_replace('{{ $qr_code }}', '', $content);
        }
        
        return $content;
    }
    
    /**
     * Get available templates
     */
    public function getAvailableTemplates(): array
    {
        return ['modern', 'classic', 'minimal', 'business', 'corporate'];
    }
}