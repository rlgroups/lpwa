<?php

namespace LaravelMPWA\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelMPWAServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerIcons();
        $this->registerViews();
        $this->registerServiceworker();
        $this->registerDirective();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('laravelmultipwa.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'laravelmultipwa'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/vendor/laravelmultipwa');

        $sourcePath = __DIR__.'/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/vendor/laravelmultipwa';
        }, \Config::get('view.paths')), [$sourcePath]), 'laravelmultipwa');
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerIcons()
    {
        $iconsPath = public_path('images/icons');

        $sourcePath = __DIR__.'/../assets/images/icons';

        $this->publishes([
            $sourcePath => $iconsPath
        ], 'icons');
    }

    /**
     * Register serviceworker.js.
     *
     * @return void
     */
    protected function registerServiceworker()
    {
        $publicPath = public_path();

        $sourcePath = __DIR__.'/../assets/js';

        $this->publishes([
            $sourcePath => $publicPath
        ], 'serviceworker');
    }

    /**
     * Register directive.
     *
     * @return void
     */
    public function registerDirective()
    {
        Blade::directive('laravelPWA', function () {
            return (new \LaravelMPWA\Services\MetaService)->render();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
