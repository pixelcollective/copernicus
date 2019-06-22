<?php

namespace Copernicus\Providers;

use \Copernicus\Services\Block;
use \Copernicus\Services\BlockAsset;

use Roots\Acorn\ServiceProvider;

class BlocksServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Collect blocks from config
         */
        $this->registry = collect(
            $this->app['config']->get('blocks.registry')
        );

        /**
         * Registers Block service
         */
        $this->app->bind('block', function () {
            return new Block($this->app);
        });

        /**
         * Register block assets service
         */
        $this->app->bind('block.assets', function () {
            return new BlockAsset($this->app);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Instantiates container service for
         * each block in registry
         */
        $this->registry->each(function ($block) {
            $this->app->make('block')->register($block);
        });
    }
}
