<?php

namespace Copernicus\App\Blocks;

use TinyPixel\Copernicus\Blocks\BlockRegistry;
use TinyPixel\Copernicus\Blocks\BlockManager;
use TinyPixel\Copernicus\Blocks\BlockAssetManager;
use TinyPixel\Copernicus\Blocks\BlockCategoryManager;

/**
 * Registry
 *
 */
class Registry extends BlockRegistry
{
    /**
     * Assets
     *
     * @param BlockAssetManager $assets
     */
    public function assets(BlockAssetManager $assets)
    {
        $assets
            ->add('demo/editor')
            ->loadWith('editor')
            ->script('demo-editor.js');

        $assets
            ->add('demo/editor')
            ->loadWith('editor')
            ->style('demo.css');

        $assets
            ->add('demo/public')
            ->loadWith('public')
            ->pairWith('demo')
            ->script('demo.js');

        return $assets;
    }

    /**
     * Blocks.
     *
     * @return void
     */
    public function blocks(BlockManager $blocks)
    {
        /**
         * Example: add a block and set its view:
         *
         * $this->blocks->add('demo')->withView('demo');
         **/

        /**
         * Example: add two blocks and set their views en masse:
         *
         * $this->blocks->add(['demo', 'demo2'], 'demo');
         **/

        /**
         * Example: if a block name matches a view filename,
         * you may add it as part of a group:
         *
         * $this->addSet(['my-block', 'demo']);
         */

        $blocks->add('demo')->withView('demo');

        return $blocks;
    }

    /**
     * Block categories.
     *
     * @return void
     */
    public function categories(BlockCategoryManager $categories)
    {
        // params: block slug, block title, block icon
        $categories->add('demo', 'Demo', 'general');

        return $categories;
    }
}
