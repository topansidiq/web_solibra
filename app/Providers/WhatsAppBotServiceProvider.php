<?php

namespace App\Providers;

use App\Services\WhatsAppBotService;
use Illuminate\Support\ServiceProvider;

class WhatsAppBotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(WhatsAppBotService::class, function ($app) {
            return new WhatsAppBotService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
