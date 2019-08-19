<?php

namespace TinyPixel\Copernicus\Blocks;

use Illuminate\Support\Collection;
use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Block Asset
 *
 */
class BlockAsset
{
    /**
     * Loads alongside
     * @var string
     */
    protected $loadsAlongside;

    /**
     * Editor dependencies
     *
     * @var Illuminate\Support\Collection
     */
    protected $editorDependencies = [
        'wp-editor',
        'wp-element',
        'wp-blocks',
    ];

    /**
     * Dependencies
     *
     * @var Illuminate\Support\Collection
     */
    protected $dependencies;

    /**
     * Construct.
     *
     */
    public function __construct()
    {
        $this->editorDependencies = Collection::make(
            $this->editorDependencies
        );

        $this->dependsOn = Collection::make();

        return $this;
    }

    /**
     * Set base URL and directory
     *
     * @param  string $url
     * @param  string $path
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function setBase(string $url, string $path) : BlockAsset
    {
        $this->baseUrl = $url;
        $this->basePath = $path . 'dist';

        return $this;
    }

    /**
     * Label asset
     *
     * @param  string $assetLabel
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function label(string $assetLabel) : BlockAsset
    {
        $this->label = $assetLabel;

        return $this;
    }

    /**
     * Pair asset with a block for conditionally loading.
     *
     * @param  string $blockName
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function loadsAlongside(string $blockName) : BlockAsset
    {
        $this->loadsAlongside = $blockName;

        return $this;
    }

    /**
     * Set asset dependencies
     *
     * @param  array $dependencies
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function dependsOn(array $dependencies) : BlockAsset
    {
        $this->dependsOn->merge($dependencies);

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
    public function editorStyle(string $file) : BlockAsset
    {
        add_action('enqueue_block_editor_assets', function () use ($file) {
            if (file_exists($this->getPath($file))) {
                wp_enqueue_style(
                    $this->label,
                    $this->getUrl($file),
                    $this->dependencies(),
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
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function editorScript(string $file) : BlockAsset
    {
        add_action('enqueue_block_editor_assets', function () use ($file) {
            if (file_exists($this->getPath($file))) {
                wp_enqueue_script(
                    $this->label,
                    $this->getUrl($file),
                    $this->editorDependencies(),
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
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function style(string $file) : BlockAsset
    {
        add_action('wp_enqueue_scripts', function () use ($file) {
            if (file_exists($this->getPath($file))) {
                if (isset($this->loadsAlongside)
                && !has_block($this->loadsAlongside)) {
                    return;
                }

                wp_enqueue_style(
                    $this->label,
                    $this->getUrl($file),
                    $this->dependencies(),
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
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function script(string $file) : BlockAsset
    {
        add_action('wp_enqueue_scripts', function () use ($file) {
            if (file_exists($this->getPath($file))) {
                if(isset($this->loadsAlongside)
                && !has_block($this->loadsAlongside)) {
                    return;
                }

                wp_enqueue_script(
                    $this->label,
                    $this->getUrl($file),
                    $this->dependencies(),
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
     * @return string
     */
    public function getUrl(string $file) : string
    {
        return "{$this->baseUrl}{$file}";
    }

    /**
     * Path to asset.
     *
     * @param  string $file
     * @return string
     */
    public function getPath(string $file) : string
    {
        return "{$this->basePath}/{$file}";
    }

    /**
     * Dependencies
     *
     * @return array
     */
    public function dependencies() : array
    {
        return !$this->dependsOn->isEmpty() ?
            $this->dependsOn->toArray() :
            [];
    }

    /**
     * Get editor dependencies
     *
     * @param  string $file
     * @return array
     */
    public function editorDependencies() : array
    {
        if(isset($this->dependsOn)) {
            $this->editorDependencies->merge($this->dependsOn);
        }

        return $this->editorDependencies->toArray();
    }
}
