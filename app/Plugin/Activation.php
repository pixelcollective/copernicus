<?php

namespace Copernicus\App\Plugin;

use TinyPixel\Copernicus\Plugin\Plugin;

/**
 * Plugin activation handler.
 *
 */
class Activation extends Plugin
{
    /**
     * Invoke activation.
     *
     * @return void
     */
    public static function run() : void
    {
        dd('activate');
    }
}
