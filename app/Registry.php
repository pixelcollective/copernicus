<?php

namespace Copernicus\App;

use TinyPixel\Copernicus\Blocks\BlockRegistry;
use TinyPixel\Copernicus\Blocks\BlockManager;
use TinyPixel\Copernicus\Blocks\BlockAssetManager;

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
    public function assets()
    {
        $this->assets->add('demo.editor.js')
                ->editorScript('index.js');

        $this->assets->add('demo.editor.css')
                ->editorStyle('demo.css');
    }

    /**
     * Blocks.
     *
     * @return void
     */
    public function blocks()
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
         * $this->add(['my-block', 'demo']);
         */

        $this->blocks->add('demo')->withView('demo');
    }

    /**
     * Block categories.
     *
     * @return void
     */
    public function categories()
    {
        // params: block slug, block title, block icon
        $this->categories->add('demo', 'Demo', 'general');
    }
}
