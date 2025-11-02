<?php

use Illuminate\Support\Facades\Route;
use SubhashLadumor1\InvoiceLite\Http\Controllers\InvoiceShareController;

// Shareable invoice routes
Route::group(['prefix' => config('invoicelite.share_links.route_prefix', 'invoice')], function () {
    Route::get('/{invoice}', [InvoiceShareController::class, 'show'])
        ->name('invoicelite.share');
});