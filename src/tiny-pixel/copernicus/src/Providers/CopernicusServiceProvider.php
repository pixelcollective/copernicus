<?php

namespace TinyPixel\Copernicus\Providers;

use Illuminate\Support\Collection;
use TinyPixel\Copernicus\Blocks\Block;
use TinyPixel\Copernicus\Blocks\BlockAsset;
use TinyPixel\Copernicus\Blocks\BlockManager;
use TinyPixel\Copernicus\Blocks\BlockAssetManager;
use TinyPixel\Copernicus\Blocks\BlockCategoryManager;
use Copernicus\App\Registry;
use TinyPixel\Copernicus\ServiceProvider;

class CopernicusServiceProvider extends ServiceProvider
{
    /**
     * Register the plugin with the application container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('block', function ($app) {
            return new Block();
        });

        $this->app->bind('block.asset', function ($app) {
            return new BlockAsset();
        });

        $this->app->bind('block.manager', function ($app) {
            return new BlockManager(
                $app,
                $app->make('block.assetManager'),
                $app->make('view'),
                $app['config']->get('blocks.namespace')
            );
        });

        $this->app->bind('block.assetManager', function ($app) {
            return new BlockAssetManager($app);
        });

        $this->app->bind('block.categoryManager', function ($app) {
            return new BlockCategoryManager();
        });

        $this->app->singleton('block.registry', function ($app) {
            return new Registry($app);
        });
    }

    /**
     * Boot the plugin from the application container.
     */
    public function boot()
    {
        $this->app->make('block.registry')->init();
    }
}
