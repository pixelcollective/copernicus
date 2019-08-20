<?php

namespace TinyPixel\Copernicus\Providers;

use Illuminate\Support\Collection;
use Copernicus\App\Blocks\Registry;
use TinyPixel\Copernicus\Blocks\Block;
use TinyPixel\Copernicus\Blocks\BlockAsset;
use TinyPixel\Copernicus\Blocks\BlockManager;
use TinyPixel\Copernicus\Blocks\BlockAssetManager;
use TinyPixel\Copernicus\Blocks\BlockCategoryManager;
use TinyPixel\Copernicus\ServiceProvider;

/**
 * Copernicus Service Provider.
 *
 */
class CopernicusServiceProvider extends ServiceProvider
{
    /**
     * Register the block-specific classes from the Application container.
     *
     * @return void
     */
    public function register() : void
    {
        /**
         * Individual block.
         */
        $this->app->bind('block', function ($app) {
            return new Block();
        });

        /**
         * Individual block asset.
         */
        $this->app->bind('block.asset', function ($app) {
            return new BlockAsset($app);
        });

        /**
         * Block manager.
         */
        $this->app->bind('block.manager', function ($app) {
            return new BlockManager($app, $app['config']->get('blocks.namespace'));
        });

        /**
         * Block asset manager.
         */
        $this->app->bind('block.assetManager', function ($app) {
            return new BlockAssetManager($app);
        });

        /**
         * Block category manager.
         */
        $this->app->bind('block.categoryManager', function ($app) {
            return new BlockCategoryManager();
        });

        /**
         * Block registry.
         */
        $this->app->singleton('block.registry', function ($app) {
            return new Registry($app);
        });
    }

    /**
     * Boot the block-specific classes from the application container.
     */
    public function boot() : void
    {
        /**
         * Create the registry.
         */
        $blockRegistry = $this->app->make('block.registry');

        /**
         * Run block editor registration.
         */
        $blockRegistry->run();
    }
}
