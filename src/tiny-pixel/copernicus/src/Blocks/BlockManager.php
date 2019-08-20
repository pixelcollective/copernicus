<?php

namespace TinyPixel\Copernicus\Blocks;

use function \add_action;
use function \add_filter;
use function \register_block_type;
use Illuminate\Support\Collection;
use Illuminate\View\Factory as View;
use TinyPixel\Copernicus\Blocks\Block;
use Illuminate\Contracts\Foundation\Application;

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
     * @param Illuminate\Contracts\Foundation\Application $app
     * @param string $namespace
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
     * Accepts a string or array of blocks to register.
     *  - Arrays return void.
     *  - Strings return the block object.
     *
     * @param  {array|string} $blocks
     * @return {TinyPixel\Copernicus\Blocks\Block|void}
     */
    public function add($blocks, string $viewTemplate = null)
    {
        if (is_string($blocks)) {
            return $this->addBlock($blocks, isset($viewTemplate) ?
                $viewTemplate : null
            );
        }

        if (is_array($blocks)) {
            Collection::make($blocks)->each(function ($block) use ($viewTemplate) {
                return $this->addBlock($block, isset($viewTemplate) ?
                    $viewTemplate : null
                );
            });
        }
    }

    /**
     * Add block.
     *
     * @param  string $blockName
     * @param  string $viewTemplate
     * @return TinyPixel\Copernicus\Blocks\Block
     */
    public function addBlock(string $blockName, string $viewTemplate = null) : Block
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
         * Set view template if specified
         */
        if(isset($viewTemplate)) {
            $this->{$blockName}->withView($viewTemplate);
        }

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
     *
     * @return void
     * @uses   \add_action
     */
    public function register() : void
    {
        /**
         * Call each block's registration method on init.
         */
        $this->blocks->each(function ($block) {
            \add_action('init', [$block, 'register']);
        });
    }
}
