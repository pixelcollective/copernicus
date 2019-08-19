<?php

namespace TinyPixel\Copernicus\Blocks;

use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Block Asset Manager
 *
 */
class BlockAsset
{
    /**
     * Construct.
     */
    public function __construct()
    {
        return $this;
    }

    /**
     * Set base.
     */
    public function setBase($url, $path)
    {
        $this->baseUrl = $url;
        $this->basePath = $path . 'dist';

        return $this;
    }

    /**
     * Label asset
     */
    public function label($assetLabel)
    {
        $this->label = $assetLabel;

        return $this;
    }

    /**
     * Add editor styles.
     *
     * @param string $file
     * @param array  $dependencies
     *
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function editorStyle(string $file, array $dependencies = []) : BlockAsset
    {
        add_action('enqueue_block_editor_assets', function () use ($file, $dependencies) {
            if (file_exists($this->getPath($file))) {
                wp_enqueue_style(
                    $this->label,
                    $this->getUrl($file),
                    $dependencies,
                    'all'
                );
            }
        });

        return $this;
    }

    /**
     * Add editor scripts.
     *
     * @param string $file
     * @param array  $dependencies
     *
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function editorScript(string $file, array $dependencies = []) : BlockAsset
    {
        add_action('enqueue_block_editor_assets', function () use ($file, $dependencies) {
            if (file_exists($this->getPath($file))) {
                wp_enqueue_script(
                    $this->label,
                    $this->getUrl($file),
                    $this->getEditorDependencies($dependencies),
                    null,
                    true
                );
            }
        });

        return $this;
    }

    /**
     * Add public stylesheet.
     *
     * @param string $file
     * @param array  $dependencies
     *
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function style($file, $dependencies = []) : BlockAsset
    {
        add_action('wp_enqueue_scripts', function () use ($file, $dependencies) {
            if (file_exists($this->getPath($file))) {
                wp_enqueue_style(
                    $this->label,
                    $this->getUrl($file),
                    $dependencies,
                    'all'
                );
            }
        });

        return $this;
    }

    /**
     * Add public script.
     *
     * @param string $file
     * @param array  $dependencies
     *
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function script(string $file, array $dependencies = []) : BlockAsset
    {
        add_action('wp_enqueue_scripts', function () use ($file, $dependencies) {
            if (file_exists($this->getPath($file))) {
                wp_enqueue_script(
                    $this->label,
                    $this->getUrl($file),
                    $dependencies,
                    null,
                    true
                );
            }
        });

        return $this;
    }

    /**
     * URL of asset
     *
     * @param  string $file
     *
     * @return string
     */
    public function getUrl($file) : string
    {
        return "{$this->baseUrl}{$file}";
    }

    /**
     * Path to asset.
     *
     * @param  string $file
     *
     * @return string
     */
    public function getPath(string $file) : string
    {
        return "{$this->basePath}/{$file}";
    }

    /**
     * Get editor dependencies
     *
     * @param string $file
     *
     * @return string
     */
    public function getEditorDependencies($dependencies)
    {
        return ['wp-editor', 'wp-element', 'wp-blocks'];
    }
}
