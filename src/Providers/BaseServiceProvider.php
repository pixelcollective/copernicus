<?php

namespace TinyPixel\Base\Providers;

use TinyPixel\Base\Base\Lifecycle;
use TinyPixel\Base\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;

/**
 * Plugin Service Provider
 */
class BaseServiceProvider extends ServiceProvider
{
    /**
     * Register the plugin with the application container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('base.lifecycle', function ($app) {
            return new Lifecycle($app);
        });

        \do_action('base\register', $this->app);
    }

    /**
     * Boot the plugin from the application container.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->app->make('base.lifecycle');

        \do_action('base\boot', $this->app);
    }
}
