<?php

namespace Copernicus\Providers;

use \Illuminate\Support\Collection;
use \Roots\Acorn\ServiceProvider;

class CopernicusServiceProvider extends ServiceProvider
{
    /**
     * Register the plugin with the application container.
     *
     * @return void
     */
    public function register()
    {
        $configPath = plugin_dir_path(__DIR__) . '../config';

        /**
         * Merges configuration with Acorn's
         */
        $configFiles = [
            'copernicus' => 'copernicus',
            'assets'     => 'copernicus.assets',
            'view'       => 'copernicus.view',
            'gutenberg'  => 'gutenberg',
            'blocks'     => 'blocks',
        ];

        foreach ($configFiles as $config => $binding) {
            $this->mergeConfigFrom("{$configPath}/{$config}.php", $binding);
        }

        $this->registerCopernicusProviders(
            collect($this->app['config']->get('copernicus.providers'))
        );

        $this->registerMacros();
    }

    /**
     * Run the plugin
     *
     * @return void
     */
    public function boot()
    {
    }

    private function registerCopernicusProviders(Collection $providers)
    {
        $providers->each(function ($provider) {
            $this->app->register($provider);
        });
    }

    /**
     * Register Collection macros
     */
    private function registerMacros()
    {
        \Illuminate\Support\Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });
    }
}
