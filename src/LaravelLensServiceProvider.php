<?php

namespace Odat\LaravelLens;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Odat\LaravelLens\View\Components\RoutesTable;

class LaravelLensServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-lens');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-lens');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-lens.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-lens'),
            ], 'views')->tag;

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-lens'),
            ], 'assets');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-lens'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-lens');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-lens', function ($app) {
            return new LaravelLensManager($app);
        });
    }

    public function provides()
    {
        return ['laravel-lens'];
    }
}
