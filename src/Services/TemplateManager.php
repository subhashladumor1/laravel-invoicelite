<?php

namespace SubhashLadumor1\InvoiceLite\Services;

class TemplateManager
{
    /**
     * Render the invoice template with data
     */
    public function render(string $template, array $data, string $language = 'en'): string
    {
        // In a real implementation, this would render a Blade template
        // For this package, we'll simulate the rendering process
        
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
        $content = str_replace('{{ $customer.name }}', $data['customer']['name'] ?? '', $content);
        $content = str_replace('{{ $customer.email }}', $data['customer']['email'] ?? '', $content);
        
        // Add items table
        $itemsHtml = '';
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $itemsHtml .= "<tr>";
                $itemsHtml .= "<td>{$item['name']}</td>";
                $itemsHtml .= "<td>{$item['qty']}</td>";
                $itemsHtml .= "<td>" . ($item['price'] ?? 0) . "</td>";
                $itemsHtml .= "<td>" . (($item['price'] ?? 0) * ($item['qty'] ?? 1)) . "</td>";
                $itemsHtml .= "</tr>";
            }
        }
        
        $content = str_replace('@itemsTable', $itemsHtml, $content);
        
        // Replace totals
        $content = str_replace('{{ $subtotal }}', $data['subtotal'] ?? 0, $content);
        $content = str_replace('{{ $tax_amount }}', $data['tax_amount'] ?? 0, $content);
        $content = str_replace('{{ $total }}', $data['total'] ?? 0, $content);
        $content = str_replace('{{ $formatted_total }}', $data['formatted_total'] ?? 0, $content);
        
        return $content;
    }
    
    /**
     * Get available templates
     */
    public function getAvailableTemplates(): array
    {
        return ['modern', 'classic', 'minimal'];
    }
}