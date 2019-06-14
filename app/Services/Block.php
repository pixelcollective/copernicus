<?php

namespace BlockModules\Services;

class Block
{
    public function __construct($app)
    {
        $this->app = $app;

        $this->baseUrl = $this->app['config']->get('blocks.assets.uri');
        $this->basePath = $this->app['config']->get('blocks.assets.path');
        $this->viewPath = $this->app['config']->get('blocks.view.paths');
        $this->namespace = $this->app['config']->get('blocks.namespace');
    }

    public function register($blockName)
    {
        $this->blockName = $blockName;
        $this->blockType = "{$this->namespace}/{$blockName}";

        add_action('enqueue_block_editor_assets', function () {
            $this->enqueueEditorScript();
            $this->enqueueEditorStyle();
        });

        add_action('wp_enqueue_scripts', function () {
            $this->enqueuePublicScript();
            $this->enqueuePublicElement();
            $this->enqueuePublicStyle();
        });

        add_action('init', function () {
            $this->registerBlock();
        });

        $this->modifyBlockData();
    }

    public function enqueueEditorStyle()
    {
        $style = $this->asset('editor.css');

        if (file_exists($style->path)) {
            wp_enqueue_style(
                "{$this->blockType}/editor/css",
                $style->url,
                false,
                'all',
            );
        }
    }

    public function enqueueEditorScript()
    {
        $script = $this->asset('editor.js');

        if (file_exists($script->path)) {
            wp_enqueue_script(
                "{$this->blockType}/editor/js",
                $script->url,
                ['wp-editor', 'wp-element', 'wp-blocks'],
                null,
                true,
            );
        }
    }

    public function enqueuePublicStyle()
    {
        $style = $this->asset('public.css');

        if (file_exists($style->path)
            && has_block($this->blockType)) {
            wp_enqueue_style(
                    "{$this->blockType}/public/css",
                    $style->url,
                    false,
                    'all',
                );
        }
    }

    public function enqueuePublicScript()
    {
        $script = $this->asset('public.js');

        if (file_exists($script->path)
            && has_block($this->blockType)) {
            wp_enqueue_script(
                    "{$this->blockType}/public/js",
                    $script->url,
                    null,
                    null,
                    true,
                );
        }
    }

    public function enqueuePublicElement()
    {
        $react = $this->asset('react.js');

        if (file_exists($react->path)
            && has_block($this->blockType)) {
            wp_enqueue_script(
                    "{$this->blockType}/public/react",
                    $react->url,
                    ['wp-element'],
                    null,
                    true,
                );
        }
    }

    public function registerBlock()
    {
        register_block_type($this->blockType, [
            'render_callback' => function ($attributes, $content) {
                return $this->app['view']->make(
                    "blocks::{$this->blockType}.render",
                    $this->data($attributes, $content),
                );
            }
        ]);
    }

    private function data($attributes, $content)
    {
        return [
            'attr'    => (object) $attributes,
            'content' => $content,
        ];
    }

    private function modifyBlockData()
    {
        add_filter('render_block_data', function ($block, $source_block) {
            $block['attrs']['source'] = $source_block;
            return $block;
        }, 10, 2);
    }

    private function asset($file)
    {
        return (object) [
            'path' => "{$this->basePath}/{$this->blockType}/{$file}",
            'url'  => "{$this->baseUrl}/{$this->blockType}/{$file}",
        ];
    }
}
