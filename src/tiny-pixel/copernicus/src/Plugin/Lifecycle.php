<?php

namespace TinyPixel\Copernicus\Plugin;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;

/**
 * Plugin lifecycle controller
 *
 * @author  Kelly Mears <kelly@tinypixel.dev>
 * @license MIT
 * @version 1.0.0
 * @since   1.0.0
 */
class Lifecycle
{
    /**
     * Lifecycle events
     *
     * @var \Illuminate\Support\Collection
     */
    protected $lifecycleEvents = [
        'activation',
        'deactivation',
        'uninstall',
    ];

    /**
     * Constructor.
     *
     * @param Illuminate\Framework\Contract\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->lifecycleEvents = Collection::make($this->lifecycleEvents);
    }

    /**
     * Resolve lifecycle classes and hook WordPress.
     *
     * @return void
     */
    public function init() : void
    {
        $this->lifecycleEvents->each(function ($event) {
            $eventClass = ucfirst($event);
        });
    }
}
