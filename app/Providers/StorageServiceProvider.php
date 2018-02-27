<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tapklik\Storage\Adapters\S3StorageAdapter;
use Tapklik\Storage\Contracts\AbstractStorage;
use Tapklik\Storage\Contracts\StorageInterface;

class StorageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
