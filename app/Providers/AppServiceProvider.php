<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider as TelescopeServiceProviderVendor;
use Aws\S3\S3Client;
use Aws\TranscribeService\TranscribeServiceClient;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(TelescopeServiceProviderVendor::class);
            $this->app->register(TelescopeServiceProvider::class);
            $this->app->register(IdeHelperServiceProvider::class);
        }
        $this->app->bind(S3Client::class, function () {
            return new S3Client(config('services.aws'));
        });
        $this->app->bind(TranscribeServiceClient::class, function () {
            return new TranscribeServiceClient(config('services.aws'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
