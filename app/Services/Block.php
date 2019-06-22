<?php

namespace Copernicus\Services;

use \Roots\Acorn\Application;

class Block
{
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function register(String $blockName)
    {
        /**
         * Sets up block references
         */
        $this->blockName = $blockName;
        $this->namespace = $this->app['config']->get('blocks.namespace');
        $this->blockType = "{$this->namespace}/{$blockName}";

        /**
         * Registers blocks on init
         */
        add_action('init', function () {
            $this->registerBlock();
        });

        /**
         * Expose inner content to blade composers
         */
        $this->modifyBlockData();

        /**
         * Enqueue assets with the Assets service provider
         */
        $this->app
            ->make('block.assets')
            ->setType($this->blockType)
            ->addEditorScript('editor.js')
            ->addEditorStyles('editor.css')
            ->addPublicStyles('public.css')
            ->addPublicScript('public.js')
            ->addPublicScript('react.js', [
                'wp-element'
            ]);
    }

    /**
     * Register block with WordPress
     */
    public function registerBlock()
    {
        register_block_type($this->blockType, [
            'render_callback' => function ($attributes, $content) {
                return $this->app['view']->make(
                    "block::{$this->blockName}",
                    $this->data($attributes, $content),
                );
            },
        ]);
    }

    /**
     * Formats data for easier work in composer
     */
    private function data($attributes, $content)
    {
        return [
            'attr' => (object) $attributes,
            'content' => $content
        ];
    }

    /**
     * Expose inner contents to Blade
     */
    private function modifyBlockData()
    {
        add_filter('render_block_data', function ($block, $source_block) {
            $block['attrs']['source'] = $source_block;
            return $block;
        }, 10, 2);
    }
}
