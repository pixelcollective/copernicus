<?php
namespace TinyPixel\Base\Blocks;

use \add_action;
use \register_block_type;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Block
{
    /**
     * Namespace
     *
     * @var string
     */
    public $namespace = 'plugin';

    /**
     * Blade engine
     *
     * @var \Illuminate Blade??
     */
    public static $blade;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($app)
    {
        self::$blade = $app['view'];

        add_action('init', [$this, 'register']);
    }

    /**
     * Render callback
     *
     * @param  array $attributes
     * @param  array $content
     *
     * @return Illuminate\View\View
     */
    public function renderCallback($attributes, $content) : View
    {
        $data = [
            'attributes' => $attributes,
            'content'    => $content,
        ];

        return self::$blade->make($this->view, $this->with($data));
    }

    /**
     * Register block with WordPress.
     *
     * @return void
     */
    public function register($data)
    {
        register_block_type("{$this->namespace}/{$this->name}", [
            'render_callback' => isset($this->view) ? [$this, 'renderCallback'] : null
        ]);
    }
}
