<?php

namespace Copernicus\App\Plugin;

use TinyPixel\Copernicus\Plugin\Plugin;

/**
 * Plugin uninstall handler.
 *
 */
class Uninstall extends Plugin
{
    /**
     * Invoke uninstallation.
     *
     * @return void
     */
    public static function run() : void
    {
        dd('activate');
    }
}
