<?php
namespace TinyPixel\Base\Base;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;

/**
 * Base lifecycle controller
 *
 * @author  Kelly Mears <kelly@tinypixel.dev>
 * @license MIT
 * @version 1.0.0
 * @since   1.0.0
 */
class Hooks
{
    /**
     * Lifecycle events
     *
     * @var \Illuminate\Support\Collection
     */
    protected static $hooks = [

    ];

    /** @var \Illuminate\Framework\Contract\Application $app */
    protected static $app;

    /**
     * Constructor.
     *
     * @param \Illuminate\Framework\Contract\Application $app
     */
    public function __construct(Application $app)
    {
        self::$app = $app;
    }

    /**
     * Invoke class
     *
     * @return void
     */
    public function __invoke() : void
    {
        // ---
    }
}
