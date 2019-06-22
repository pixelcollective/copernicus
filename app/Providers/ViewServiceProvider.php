<?php

namespace Copernicus\Providers;

use Roots\Acorn\ServiceProvider;
use \Copernicus\Services\Block;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register directives, view paths, composers
     * with the Roots application container
     *
     * @return void
     */
    public function register()
    {
        /**
         * Registers view finder
         */
        $namespaces = $this->app['config']->get('copernicus.view.namespaces');

        foreach ($namespaces as $namespace => $hints) {
            $this->app['view']->addNamespace($namespace, $hints);
        }

        /**
         * Adds views to Acorn
         */
        $views = $this->app['config']->get('copernicus.view.paths');
        $this->loadViewsFrom($views, 'blocks');

        /**
         * Registers view composers
         */
        foreach ($this->app['config']->get('copernicus.view.composers') as $composer) {
            $this->app['view']->composer($composer::views(), $composer);
        }
    }

    public function boot()
    {
    }
}
