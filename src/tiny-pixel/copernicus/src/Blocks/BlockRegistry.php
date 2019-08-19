<?php

namespace TinyPixel\Copernicus\Blocks;

use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Registry
 *
 * Registers blocks, categories and assets.
 *
 */
class BlockRegistry
{
    /**
     * Constructor.
     *
     * @param TinyPixel\Copernicus\Copernicus $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->blocks = $this->app->make('block.manager');
        $this->assets = $this->app->make('block.assetManager');
        $this->categories = $this->app->make('block.categoryManager');
    }

    /**
     * Initialize registry.
     *
     * @return void
     */
    public function init() : void
    {
        /**
         * Call userland blocks method.
         */
        $this->blocks();

        /**
         * Call userland assets method.
         */
        $this->assets();

        /**
         * Call userland categories method.
         */
        $this->categories();

        /**
         * Call debug, if enabled.
         */
        if ($this->app['config']->get('blocks.debug')) {
            add_action('wp_enqueue_scripts', [$this, 'debug']);
        }
    }

    /**
     * Register blocks and categories
     *
     * @return void
     */
    public function register() : void
    {
        $this->blocks->register();
        $this->categories->register();
    }

    /**
     * Debug
     *
     * Dump-die wordpress asset globals.
     *
     * @param  void
     * @return void
     */
    public function debug()
    {
        global $wp_styles;
        global $wp_scripts;

        dd([$wp_styles, $wp_scripts]);
    }
}
