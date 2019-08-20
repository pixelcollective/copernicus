<?php

/**
 * Plugin Name:     Copernicus Block Framework
 * Plugin URI:      https://github.com/pixelcollective/copernicus
 * Description:     A WordPress editor extension framework
 * Version:         0.2.0
 * Author:          Tiny Pixel Collective
 * Author URI:      https://tinypixel.dev
 * License:         MIT
 * License URI:     https://github.com/pixelcollective/copernicus/tree/master/LICENSE.md
 * Text Domain:     copernicus
 * Domain Path:     resources/languages
 */

require_once __DIR__ . '/vendor/autoload.php';

use TinyPixel\Copernicus\Copernicus;
use TinyPixel\Copernicus\Bootloader;

(new class {
    public function __invoke(string $basePath)
    {
        (new Bootloader(Copernicus::class, $basePath))();
    }
})(__DIR__);
