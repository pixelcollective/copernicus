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
    public function assets(BlockAssetManager $assets)
    {
        $assets->new('demo/js')->editorScript('demo-editor.js');
        $assets->new('demo/css')->editorStyle('demo.css');
        $assets->new('demo/public/css')->script('demo.js', [
            'react',
        ]);
    }

    /**
     * Blocks.
     *
     * @param  BlockManager $blocks
     *
     * @return void
     */
    public function blocks(BlockManager $blocks)
    {
        $blocks->register('demo')->with('demo');
    }
}
