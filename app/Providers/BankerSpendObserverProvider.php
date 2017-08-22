<?php

namespace App\Providers;

use App\BankerSpend;
use App\Observers\BankerSpendObserver;
use Illuminate\Support\ServiceProvider;

class BankerSpendObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        BankerSpend::observe(BankerSpendObserver::class);
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
