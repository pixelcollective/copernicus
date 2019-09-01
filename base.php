<?php
/**
 * Plugin Name:     Base
 * Plugin URI:      https://github.com/pixelcollective/Base
 * Description:     Acorn framework.
 * Version:         0.2.0
 * Author:          Tiny Pixel Collective
 * Author URI:      https://tinypixel.dev
 * License:         MIT
 * License URI:     https://github.com/pixelcollective/Base/tree/master/LICENSE.md
 * Text Domain:     Base
 * Domain Path:     resources/languages
 */

namespace TinyPixel;

require_once __DIR__ . '/vendor/autoload.php';

use TinyPixel\Base\Base;
use TinyPixel\Base\Bootloader;

(new class {
    public function __invoke(string $basePath)
    {
        (new Bootloader($basePath, Base::class))();
    }
})(__DIR__);
