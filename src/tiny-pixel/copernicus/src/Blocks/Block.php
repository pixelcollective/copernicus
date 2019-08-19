<?php

namespace TinyPixel\Copernicus\Blocks;

use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Block
 *
 */
class Block
{
    public function viewFactory($view) {
        $this->view = $view;

        return $this;
    }

    /**
     * Set block name.
     *
     * @param  string $namespace
     *
     * @return TinyPixel\Copernicus\Blocks\Block
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Set block name.
     *
     * @param string $name
     *
     * @return TinyPixel\Copernicus\Blocks\Block
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * With view template.
     *
     * @param  string $view
     *
     * @return void
     */
    public function with($viewTemplate)
    {
        if(isset($viewTemplate)) {
            $this->viewTemplate = $viewTemplate;
        }
    }

    /**
     * Register block with WordPress
     *
     * @return TinyPixel\Copernicus\Blocks\BlockManager
     */
    public function register() : Block
    {
        \register_block_type($this->blockName(), [
            'render_callback' => $this->viewTemplate ?
                [$this, 'render'] :
                null,
        ]);

        return $this;
    }

    /**
     * Render block.
     *
     * @param  $attributes
     * @param  $content
     *
     * @return Illuminate\View\View
     */
    public function render($attributes, $content)
    {
        return $this->view->make($this->viewTemplate, $this->data($attributes, $content));
    }

    /**
     * Formats data for easier work in composer
     *
     * @return array
     */
    private function data($attributes, $content) : array
    {
        return [
            'attr'    => $attributes,
            'content' => $content,
        ];
    }

    /**
     * Expose inner contents to Blade
     *
     * @return void
     */
    private function modifyBlockData() : void
    {
        add_filter('render_block_data', function ($block, $source_block) {
            $block['attrs']['source'] = $source_block;
            return $block;
        }, 10, 2);
    }

    /**
     * Return fully qualified block name.
     *
     * @return string
     */
    public function blockName() : string
    {
        return "{$this->namespace}/{$this->name}";
    }
}
