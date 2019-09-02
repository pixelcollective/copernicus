<?php
namespace Plugin\Test\Assets;

use TinyPixel\Copernicus\Blocks\Assets;

class Demo extends Assets
{
    /**
     * Internally identifies assets.
     *
     * @var array
     */
    public $name = 'demo';

    /**
     * Conditionally load assets with listed block(s).
     *
     * You may remove this declaration if you
     * always want to load these assets.
     *
     * @var array
     */
    public $blocks = ['plugin/demo'];

    /**
     * Assets used in the editor interface.
     *
     * @var array
     */
    public $editor = [
        'scripts' => ['dist/scripts/editor.js'],
        'styles'  => ['dist/styles/editor.css'],
    ];

    /**
     * Assets used in the application.
     *
     * @var array
     */
    public $app = [
        'scripts' => ['dist/scripts/app.js'],
        'styles'  => ['dist/styles/app.css'],
    ];
}
