<?php

namespace MissaelAnda\Whatsapp;

use Illuminate\Support\ServiceProvider;

class WhatsappServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('whatsapp', fn () => new Whatsapp);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/whatsapp.php' => $this->app->configPath('whatsapp.php'),
        ], 'config');
    }
}
