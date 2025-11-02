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
            $pdf->setOptions([
                'isRemoteEnabled' => true,
                'isPhpEnabled' => false,
                'isJavascriptEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'defaultMediaType' => 'screen',
                'defaultFont' => 'sans-serif',
                'dpi' => 150,
                'enable_php' => false,
                'enable_remote' => true,
                'font_height_ratio' => 1.1,
                'isFontSubsettingEnabled' => true,
                'chroot' => base_path(),
                'tempDir' => storage_path('app/temp'),
                'logOutputFile' => storage_path('logs/dompdf.log'),
                'isCssFloatEnabled' => true,
                'isCssPositioningEnabled' => true,
                'isCssPercentageHeightEnabled' => true,
            ]);
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
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isPhpEnabled' => false,
            'isJavascriptEnabled' => false,
            'isHtml5ParserEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'defaultMediaType' => 'screen',
            'defaultFont' => 'sans-serif',
            'dpi' => 150,
            'enable_php' => false,
            'enable_remote' => true,
            'font_height_ratio' => 1.1,
            'isFontSubsettingEnabled' => true,
            'chroot' => base_path(),
            'tempDir' => storage_path('app/temp'),
            'isCssFloatEnabled' => true,
            'isCssPositioningEnabled' => true,
            'isCssPercentageHeightEnabled' => true,
        ]);
        return $pdf->output();
    }
}