<?php

/**
 * Plugin name: Copernicus Test
 */

require __DIR__ . '/vendor/autoload.php';

/**
 * Filter for block definitions.
 */
add_filter('copernicus\blocks', function ($blocks) {
    return array_merge($blocks, [
        \Plugin\Test\Blocks\Demo::class,
    ]);
});

/**
 * Filter for asset defintions.
 */
add_filter('copernicus\assets', function ($assets) {
    return array_merge($assets, [
        'copernicus-test' => \Plugin\Test\Assets\Demo::class,
    ]);
});

/**
 * Filter to register new view namespaces.
 */
add_filter('copernicus\views', function ($views) {
    return array_merge($views, [
        'block' => __DIR__ . '/assets/views',
    ]);
});
