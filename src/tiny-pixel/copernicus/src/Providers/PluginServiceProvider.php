<?php

namespace TinyPixel\Copernicus\Providers;

use Copernicus\App\Plugin\Activation;
use Copernicus\App\Plugin\Deactivation;
use Copernicus\App\Plugin\Uninstall;

use Illuminate\Support\Collection;
use TinyPixel\Copernicus\Plugin\Lifecycle;
use TinyPixel\Copernicus\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

/**
 * Plugin Service Provider
 *
 */
class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register the plugin with the application container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('plugin.lifecycle', function (Application $app) {
            return new Lifecycle($app);
        });

        $this->app->bind('plugin.activation', function (Application $app) {
            return new Activation($app);
        });

        $this->app->bind('plugin.deactivation', function (Application $app) {
            return new Deactivation($app);
        });

        $this->app->bind('plugin.uninstall', function (Application $app) {
            return new Uninstall($app);
        });
    }

    /**
     * Boot the plugin from the application container.
     *
     * @return void
     */
    public function boot() : void
    {
        $pluginLifecycle = $this->app->make('plugin.lifecycle');

        $pluginLifecycle->init();
    }
}
