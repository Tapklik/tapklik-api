<?php

namespace App\Providers;

use Aws\S3\S3Client;
use Illuminate\Support\ServiceProvider;

class S3Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Uploader', function ($app) {
            return S3Client::factory([
                    'region' => getenv('AWS_REGION'),
                    'version' => '2006-03-01',
                    'credentials' => [
                        'key' => getenv('AWS_ACCESS_KEY'),
                        'secret' => getenv('AWS_SECRET_KEY')
                    ]
            ]);
        });
    }
}
