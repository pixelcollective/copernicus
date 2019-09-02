<?php
namespace TinyPixel\Copernicus\Blocks;

use \add_action;
use \register_block_type;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Block
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;

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
        return $this->app['view']->make($this->view, $this->with(
            Collection::make($attributes),
            Collection::make($content)
        ));
    }

    /**
     * Register block with WordPress.
     *
     * @return void
     */
    public function register($data)
    {
        $name = explode('/', $this->name);

        register_block_type("{$name[0]}/{$name[1]}", [
            'render_callback' => isset($this->view)
                ? [$this, 'renderCallback'] : null,
        ]);
    }
}
