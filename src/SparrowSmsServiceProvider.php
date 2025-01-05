<?php

namespace Bibekshrestha\SparrowSms;

use Illuminate\Support\ServiceProvider;

class SparrowSmsServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sparrow-sms.php', 'sparrow-sms');

        $this->app->bind(\Bibekshrestha\SparrowSms\Contracts\SparrowSmsInterface::class, \Bibekshrestha\SparrowSms\Services\SparrowSmsService::class);

        $this->app->singleton('sparrow-sms', function ($app) {
            return $app->make(\Bibekshrestha\SparrowSms\Services\SparrowSmsService::class);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/sparrow-sms.php' => config_path('sparrow-sms.php'),
        ], 'sparrow-sms');
    }
}
