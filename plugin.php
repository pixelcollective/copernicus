<?php

/**
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area.
 *
 * @wordpress-plugin
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

namespace Copernicus;

require __DIR__ .'/boot/boot.php';

$copernicus = bootCopernicus(__DIR__);

// EOF
