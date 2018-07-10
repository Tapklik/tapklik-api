<?php

namespace App\Providers;

use App\Invoice;
use App\Observers\InvoiceObserver;
use Illuminate\Support\ServiceProvider;

class InvoiceObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Invoice::observe(InvoiceObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
