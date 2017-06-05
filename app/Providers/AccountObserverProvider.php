<?php

namespace App\Providers;

use App\Account;
use App\Observers\AccountObserver;
use Illuminate\Support\ServiceProvider;

class AccountObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Account::observe(AccountObserver::class);
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
