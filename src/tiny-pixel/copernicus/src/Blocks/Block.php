<?php

namespace TinyPixel\Copernicus\Blocks;

use function \add_filter;
use Illuminate\View\View;

/**
 * Block
 *
 */
class Block
{
    /**
     * View factory
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * Name
     * @var string
     */
    protected $name;

    /**
     * Namespace
     * @var string
     */
    protected $namespace;

    /**
     * View template
     * @var string
     */
    protected $viewTemplate;

    /**
     * Return fully qualified block name.
     *
     * @return string
     */
    public function blockName() : string
    {
        return "{$this->namespace}/{$this->name}";
    }

    /**
     * Set block namespace.
     *
     * @param  string $namespace
     * @return TinyPixel\Copernicus\Blocks\Block
     */
    public function setNamespace($namespace) : Block
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
    public function setName($name) : Block
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set view factory.
     *
     * @param Illuminate\View\Factory $view
     *
     * @return TinyPixel\Copernicus\Blocks\Block
     */
    public function viewFactory($view) : Block
    {
        $this->view = $view;

        return $this;
    }

    /**
     * With view template.
     *
     * @param  string $view
     *
     * @return TinyPixel\Copernicus\Blocks\Block
     */
    public function withView(string $viewTemplate) : Block
    {
        $this->viewTemplate = $viewTemplate;

        return $this;
    }

    /**
     * Register block with WordPress.
     *
     * @return TinyPixel\Copernicus\Blocks\BlockManager
     * @uses   \register_block_type
     */
    public function register() : Block
    {
        \register_block_type($this->blockName(), [
            'render_callback' =>
                isset($this->viewTemplate) ?
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
    public function render($attributes, $content) : View
    {
        return $this->view->make(
            $this->viewTemplate,
            $this->data($attributes, $content)
        );
    }

    /**
     * Formats data for easier work in composer.
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
     * Expose inner contents.
     *
     * @uses   add_filter
     * @return void
     */
    private function modifyBlockData() : void
    {
        \add_filter('render_block_data', function ($block, $source) {
            $block['attrs']['source'] = $source;

            return $block;
        }, 10, 2);
    }
}
