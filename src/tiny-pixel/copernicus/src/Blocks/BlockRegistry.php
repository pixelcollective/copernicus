<?php

namespace TinyPixel\Copernicus\Blocks;

use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Registry
 *
 */
class BlockRegistry
{
    /**
     * Constructor.
     *
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function init()
    {
        $this->blocks($this->app->make('block.manager'));
        $this->assets($this->app->make('block.assetManager'));

        // add_action('wp_enqueue_scripts', [$this, 'debug']);
    }

    public function debug()
    {
        global $wp_styles;
        global $wp_scripts;

        dd([$wp_styles, $wp_scripts]);
    }
}
