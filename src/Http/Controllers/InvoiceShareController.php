<?php

namespace SubhashLadumor1\InvoiceLite\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceShareController extends Controller
{
    /**
     * Display the shared invoice
     */
    public function show(Request $request, string $invoiceId): Response
    {
        // In a real implementation, you would retrieve the invoice data
        // from your database or storage based on the invoice ID
        
        // For this example, we'll return a simple response
        return response()->view('invoicelite::modern', [
            'invoice_no' => $invoiceId,
            'customer' => [
                'name' => 'John Doe',
                'email' => 'john@example.com'
            ],
            'items' => [
                ['name' => 'Web Development', 'price' => 1200, 'qty' => 1],
                ['name' => 'Hosting', 'price' => 100, 'qty' => 12],
            ],
            'tax' => 18,
            'currency' => 'USD',
            'language' => 'en',
            'subtotal' => 2400,
            'tax_amount' => 432,
            'total' => 2832,
            'formatted_total' => '$2,832.00'
        ]);
    }
}