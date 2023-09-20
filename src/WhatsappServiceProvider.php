<?php

namespace MissaelAnda\Whatsapp;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
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
            Config::get('whatsapp.token'),
            Config::get('whatsapp.account_id'),
        ));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if (Config::get('whatsapp.webhook.enabled')) {
            Route::group([
                'prefix' => Config::get('whatsapp.webhook.path'),
                'as' => 'whatsapp.',
            ], function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/whatsapp.php' => $this->app->configPath('whatsapp.php'),
            ], 'config');
        }
    }
}
