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
 * Block
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
        $this->app          = $app;
        $this->view         = $app->make('view');
        $this->namespace    = $namespace;
        $this->assetManager = $app->make('block.assetManager');
        $this->blocks       = Collection::make();

        return $this;
    }

    /**
     * Register block.
     *
     * @param  string $blockName
     *
     * @return TinyPixel\Copernicus\Blocks\Block
     */
    public function register(String $blockName) : Block
    {
        $this->{$blockName} = $this->app->make('block')->viewFactory($this->view);

        $this->{$blockName}
             ->setNamespace($this->namespace)
             ->setName($blockName);

        $this->blocks->push($this->{$blockName});

        return $this->{$blockName};
    }

    /**
     * Register blocks
     */
    public function registerBlocks()
    {
        $this->blocks->each(function ($block) {
            \add_action('init', [$block, 'register']);
        });
    }
}
