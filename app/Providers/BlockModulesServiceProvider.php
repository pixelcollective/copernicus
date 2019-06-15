<?php

namespace BlockModules\Providers;

use \Roots\Acorn\ServiceProvider;
use \BlockModules\Services\Block;

class BlockModulesServiceProvider extends ServiceProvider
{
    /**
     * Register the plugin with the application container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMacros();

        $configPath = plugin_dir_path(__DIR__) . '/../config/blocks.php';

        /**
         * Registers Block service
         *
         */
        $this->app->bind('blocks', function () {
            return new Block($this->app);
        });

        /**
         * Merges configuration with Acorn
         */
        $this->mergeConfigFrom($configPath, 'blocks');

        /**
         * Registers view composers
         */
        foreach ($this->app->config['blocks.composers'] as $composer) {
            $this->app['view']->composer($composer::views(), $composer);
        }

        /**
         * Registers directives
         */
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $directives = $this->app['config']['blocks.directives'];
        foreach ($directives as $name => $handler) {
            if (!is_callable($handler)) {
                $handler = $this->app->make($handler);
            }
            $blade->directive($name, $handler);
        }

        /**
         * Registers view finder
         */
        $namespaces = $this->app['config']['blocks.namespaces'];
        foreach ($namespaces as $namespace => $hints) {
            $this->app['view']->addNamespace($namespace, $hints);
        }

        /**
         * Adds views to Acorn
         */
        $views = $this->app['config']->get('blocks.views');
        $this->loadViewsFrom($views, 'blocks');
    }

    /**
     * Run the plugin
     *
     * @return void
     */
    public function boot()
    {
        $registry = $this->app['config']->get('blocks.registry');
        $this->blocks = collect($registry) ?? null;

        if ($this->blocks) {
            $this->blocks->each(function ($block) {
                $this->app->make('blocks')->register($block);
            });
        }
    }

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
