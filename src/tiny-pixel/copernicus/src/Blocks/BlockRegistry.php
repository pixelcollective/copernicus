<?php

namespace TinyPixel\Copernicus\Blocks;

use function \dd;
use function \add_action;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;

/**
 * Block editor registry.
 *
 */
class BlockRegistry
{
    /**
     * Constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->blockManager    = $this->app->make('block.manager');
        $this->assetManager    = $this->app->make('block.assetManager');
        $this->categoryManager = $this->app->make('block.categoryManager');
    }

    /**
     * Runs registration.
     *
     * @return void
     * @uses   \add_action
     */
    public function run() : void
    {
        $this->processBlocks();
        $this->processAssets();
        $this->processCategories();

        /**
         * Call debug, if enabled.
         */
        if ($this->app['config']->get('blocks.debug')) {
            \add_action('wp_enqueue_scripts', [$this, 'debug']);
        }
    }

    /**
     * Process blocks.
     *
     * @return void
     */
    public function processBlocks() : void
    {
        $this->blocks = $this->blocks($this->blockManager);

        $this->blocks->register();
    }

    /**
     * Process assets.
     *
     * @return void
     */
    public function processAssets() : void
    {
        $this->assets = $this->assets($this->assetManager);
    }

    /**
     * Process categories.
     *
     * @return void
     */
    public function processCategories() : void
    {
        $this->categories = $this->categories($this->categoryManager)->register();
    }

    /**
     * Convenience method to add blocks with matching
     * view and block names.
     *
     * @param  array $blocks
     * @return void
     */
    public function addSet(array $blocks) : void
    {
        foreach($blocks as $block) {
            $this->blocks->add($block)->withView($block);
        }
    }

    /**
     * Debug
     *
     * Dump-die wordpress asset globals.
     *
     * @param  void
     * @return void
     * @uses   \dd
     */
    public function debug()
    {
        global $wp_styles;
        global $wp_scripts;

        dd([$wp_styles, $wp_scripts]);
    }
}
