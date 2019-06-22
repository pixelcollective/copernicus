<?php

namespace Copernicus\Services;

use \Roots\Acorn\Application;

class BlockAsset
{
    public function __construct($app)
    {
        $this->app = $app;

        return $this;
    }

    public function setType($blockType)
    {
        $this->blockType = $blockType;

        $this->baseUrl = $this->app['config']->get('copernicus.assets.uri');
        $this->basePath = $this->app['config']->get('copernicus.assets.path');

        return $this;
    }

    public function addEditorStyles($file, $dependencies = [])
    {
        add_action('enqueue_block_editor_assets', function () use ($file, $dependencies) {
            if (file_exists($this->getPath($file))) {
                wp_enqueue_style(
                    "{$this->blockType}/editor/css",
                    $this->getUrl($file),
                    $dependencies,
                    'all',
                );
            }
        });

        return $this;
    }

    public function addEditorScript($file, $dependencies = [])
    {
        add_action('enqueue_block_editor_assets', function () use ($file, $dependencies) {
            if (file_exists($this->getPath($file))) {
                wp_enqueue_script(
                    "{$this->blockType}/editor/js",
                    $this->getUrl($file),
                    $this->getEditorDependencies($dependencies),
                    null,
                    true,
                );
            }
        });

        return $this;
    }

    public function addPublicStyles($file, $dependencies = [])
    {
        add_action('wp_enqueue_scripts', function () use ($file, $dependencies) {
            if (file_exists($this->getPath($file)) &&
                has_block($this->blockType)) {
                    wp_enqueue_style(
                        "{$this->blockType}/public/css",
                        $this->getUrl($file),
                        $dependencies,
                        'all',
                    );
            }
        });

        return $this;
    }

    public function addPublicScript($file, $dependencies = [])
    {
        add_action('wp_enqueue_scripts', function () use ($file, $dependencies) {
            if (file_exists($this->getPath($file)) &&
                has_block($this->blockType)) {
                    wp_enqueue_script(
                        "{$this->blockType}/public/js",
                        $this->getUrl($file),
                        $dependencies,
                        null,
                        true,
                    );
            }
        });

        return $this;
    }

    public function getPath($file)
    {
        return "{$this->basePath}/{$this->blockType}/{$file}";
    }

    public function getUrl($file)
    {
        return "{$this->baseUrl}/{$this->blockType}/{$file}";
    }

    public function getEditorDependencies($dependencies)
    {
        return ['wp-editor', 'wp-element', 'wp-blocks'];
    }
}
