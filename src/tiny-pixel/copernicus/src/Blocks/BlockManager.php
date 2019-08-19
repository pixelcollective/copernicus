<?php

namespace TinyPixel\Copernicus\Blocks;

use function \add_action;
use function \add_filter;
use function \register_block_type;

use Illuminate\Support\Collection;
use Illuminate\View\Factory as View;
use TinyPixel\Copernicus\Blocks\Block;
use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Block Manager
 *
 */
class BlockManager
{
    /**
     * Block name.
     *
     * @var string
     */
    public $name;

    /**
     * Block namespace.
     *
     * @var string
     */
    public $namespace;

    /**
     * Constructor.
     *
     * @param TinyPixel\Copernicus\BlockAssetManager $assetManager
     * @param Illuminate\View\Factory                $view
     * @param string                                 $namespace
     */
    public function __construct(Application $app, string $namespace) {
        $this->app       = $app;
        $this->namespace = $namespace;
        $this->blocks    = Collection::make();

        $this->view         = $app->make('view');
        $this->assetManager = $app->make('block.assetManager');

        return $this;
    }

    /**
     * Register block.
     *
     * @param  string $blockName
     * @return TinyPixel\Copernicus\Blocks\Block
     */
    public function add(String $blockName) : Block
    {
        /**
         * Create a new block.
         */
        $this->{$blockName} = $this->app->make('block');

        /**
         * Set the view factory instance.
         */
        $this->{$blockName}->viewFactory($this->view);

        /**
         * Set block name and namespace.
         */
        $this->{$blockName}
             ->setNamespace($this->namespace)
             ->setName($blockName);

        /**
         * Add block to stack of registered blocks.
         */
        $this->blocks->push($this->{$blockName});

        /**
         * Return block to child class for manipulation.
         */
        return $this->{$blockName};
    }

    /**
     * Register blocks
     */
    public function register()
    {
        /**
         * Call each block's registration method on init.
         */
        $this->blocks->each(function ($block) {
            \add_action('init', [$block, 'register']);
        });
    }
}
