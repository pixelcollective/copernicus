<?php
namespace Plugin\Test\Blocks;

use TinyPixel\Copernicus\Blocks\Block;

class Demo extends Block
{
    /**
     * Name of this block.
     *
     * @var string
     */
    public $name = 'plugin/demo';

    /**
     * View used to render block.
     *
     * @var string
     */
    public $view = 'block::demo';

    /**
     * Data to be passed to the block before rendering.
     *
     * @param  array $data
     * @return array
     */
    public function with($attributes, $content) : array
    {
        return [
            'attributes' => $attributes,
            'html'       => $attributes->get('inner.html'),
            'text'       => $attributes->get('text'),
            'image'      => $attributes->get('media'),
        ];
    }
}
