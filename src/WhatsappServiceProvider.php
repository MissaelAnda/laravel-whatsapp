<?php

namespace MissaelAnda\Whatsapp;

use Illuminate\Support\Facades\Config;
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
        $this->mergeConfigFrom(__DIR__ . '/../config/whatsapp.php', 'whatsapp');

        $this->app->singleton('whatsapp', fn () => new Whatsapp(
            Config::get('whatsapp.default_number_id'),
            Config::get('whatsapp.token')
        ));
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
