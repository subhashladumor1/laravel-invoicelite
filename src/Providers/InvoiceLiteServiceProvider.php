<?php

namespace SubhashLadumor1\InvoiceLite\Providers;

use Illuminate\Support\ServiceProvider;
use SubhashLadumor1\InvoiceLite\Contracts\InvoiceGeneratorInterface;
use SubhashLadumor1\InvoiceLite\Services\InvoiceManager;
use SubhashLadumor1\InvoiceLite\Services\TemplateManager;
use SubhashLadumor1\InvoiceLite\Services\CurrencyFormatter;
use SubhashLadumor1\InvoiceLite\Services\TaxCalculator;
use SubhashLadumor1\InvoiceLite\Services\ShareLinkManager;
use SubhashLadumor1\InvoiceLite\Support\PDFExporter;

class InvoiceLiteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish config file
        $this->publishes([
            __DIR__.'/../Config/invoicelite.php' => config_path('invoicelite.php'),
        ], 'invoicelite-config');

        // Publish language files
        $this->publishes([
            __DIR__.'/../Lang' => resource_path('lang/vendor/invoicelite'),
        ], 'invoicelite-lang');

        // Publish template files
        $this->publishes([
            __DIR__.'/../Templates' => resource_path('views/vendor/invoicelite'),
        ], 'invoicelite-templates');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../Templates', 'invoicelite');

        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/../Lang', 'invoicelite');

        // Load routes for shareable links
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../Config/invoicelite.php', 'invoicelite'
        );

        // Bind contracts to implementations
        $this->app->bind(InvoiceGeneratorInterface::class, InvoiceManager::class);
        
        // Register services
        $this->app->singleton('invoicelite.manager', function ($app) {
            return new InvoiceManager(
                $app->make(TemplateManager::class),
                $app->make(CurrencyFormatter::class),
                $app->make(TaxCalculator::class),
                $app->make(ShareLinkManager::class),
                $app->make(PDFExporter::class)
            );
        });

        $this->app->singleton('invoicelite.template', function ($app) {
            return new TemplateManager();
        });

        $this->app->singleton('invoicelite.currency', function ($app) {
            return new CurrencyFormatter();
        });

        $this->app->singleton('invoicelite.tax', function ($app) {
            return new TaxCalculator();
        });

        $this->app->singleton('invoicelite.share', function ($app) {
            return new ShareLinkManager();
        });

        $this->app->singleton('invoicelite.pdf', function ($app) {
            return new PDFExporter();
        });

        // Register facade
        $this->app->bind('invoicelite', function ($app) {
            return $app->make('invoicelite.manager');
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            'invoicelite',
            'invoicelite.manager',
            'invoicelite.template',
            'invoicelite.currency',
            'invoicelite.tax',
            'invoicelite.share',
            'invoicelite.pdf'
        ];
    }
}