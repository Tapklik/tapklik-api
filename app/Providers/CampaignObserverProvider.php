<?php

namespace App\Providers;

use App\Campaign;
use App\Observers\CampaignObserver;
use Illuminate\Support\ServiceProvider;

class CampaignObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Campaign::observe(CampaignObserver::class);
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
