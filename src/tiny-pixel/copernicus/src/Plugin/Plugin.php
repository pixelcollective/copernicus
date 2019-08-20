<?php

namespace TinyPixel\Copernicus\Plugin;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;

/**
 * Plugin
 *
 * @author  Kelly Mears <kelly@tinypixel.dev>
 * @license MIT
 * @version 1.0.0
 * @since   1.0.0
 */
class Plugin
{
    /**
     * Constructor.
     *
     * @param Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
