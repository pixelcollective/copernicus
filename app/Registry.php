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
        $this->assets->add('demo/js')
               ->editorScript('demo-editor.js');

        $this->assets->add('demo/css')
               ->editorStyle('demo.css');

        $this->assets->add('demo/public/js')
               ->script('demo.js')
               ->dependsOn(['react'])
               ->loadsAlongside('demo');
    }

    /**
     * Blocks.
     *
     * @return void
     */
    public function blocks()
    {
        $this->blocks->add('demo')
                     ->withView('demo');
    }

    /**
     * Block categories.
     *
     * @return void
     */
    public function categories()
    {
        $this->categories->add('demo', 'Demo', 'general');
    }
}
