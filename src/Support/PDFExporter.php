<?php

namespace SubhashLadumor1\InvoiceLite\Support;

use Barryvdh\DomPDF\Facade\Pdf;

class PDFExporter
{
    /**
     * Generate PDF from HTML content
     */
    public function generate(string $html, string $path): bool
    {
        try {
            $pdf = Pdf::loadHTML($html);
            $pdf->save($path);
            return true;
        } catch (\Exception $e) {
            // Log error or handle exception as needed
            return false;
        }
    }
    
    /**
     * Generate PDF and return as string
     */
    public function output(string $html): string
    {
        $pdf = Pdf::loadHTML($html);
        return $pdf->output();
    }
}