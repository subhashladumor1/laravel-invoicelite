<?php

namespace SubhashLadumor1\InvoiceLite\Services;

use Illuminate\Support\Facades\URL;

class ShareLinkManager
{
    /**
     * Generate a signed URL for sharing an invoice
     */
    public function generate(string $invoiceId, \DateTime|int|null $expiration = null): string
    {
        // If expiration is an integer, treat it as hours from now
        if (is_int($expiration)) {
            $expiration = now()->addHours($expiration);
        }
        
        // If no expiration, default to 30 days
        if ($expiration === null) {
            $expiration = now()->addDays(30);
        }
        
        // Generate signed URL
        return URL::temporarySignedRoute(
            'invoicelite.share',
            $expiration,
            ['invoice' => $invoiceId]
        );
    }
    
    /**
     * Verify if a share link is valid
     */
    public function isValid(string $signature, string $invoiceId): bool
    {
        // In a real implementation, this would verify the signature
        // For now, we'll just return true
        return true;
    }
}