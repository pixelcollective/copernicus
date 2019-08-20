<?php

namespace Copernicus\App\Plugin;

use TinyPixel\Copernicus\Plugin\Plugin;

/**
 * Plugin deactivation handler.
 *
 */
class Deactivation extends Plugin
{
    /**
     * Invoke deactivation.
     *
     * @return void
     */
    public static function run() : void
    {
        dd('activate');
    }
}
