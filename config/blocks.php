<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Block Namespace
    |--------------------------------------------------------------------------
    |
    | The namespace used to designate blocks
    |
    */

    'namespace' => 'copernicus',

    /*
    |--------------------------------------------------------------------------
    | Block Registry
    |--------------------------------------------------------------------------
    |
    | An array of blocknames.
    |
    | By default the registry is kept at PROJECT/blocks.json so that
    | its contents can be parsed by both the Acorn framework and Laravel Mix.
    |
    | Anything added to this file will be automatically registered with webpack
    | and WordPress as long as there are:
    |
    | Corresponding scripts in PROJECT/resources/assets/scripts/{namespace}/{block}:
    |   - editor.js is the main editor JS entrypoint
    |   - editor.scss is for editor styles
    |   - public.js will be enqueued only on pages which feature the block
    |   - react.js works like public.js but supports JSX (dependent on wp-element)
    |   - public.scss will be enqueued only on pages which feature the block
    |
    | Corresponding views in PROJECT/resources/views/blocks/{namespace}/{block}:
    |   - render.blade.php is the default view registered with WP
    |   - this can be extended with components, layouts, etc.
    |   - block attributes are available to your view with {!! $attr->yourAttrName !!}
    |   - if you use blocks with inner content (like columns, InnerBlocks, etc.)
    |     that output is available with {!! $content !!}
    |
    */

    'registry' => json_decode(file_get_contents(
        plugin_dir_path(__DIR__) . 'blocks.json'
    )),

    /*
    |--------------------------------------------------------------------------
    | Block Categories
    |--------------------------------------------------------------------------
    |
    | Additional categories for for the Block Editor inserter menu. The icon
    | can either be a dashicon or a path to an SVG file.
    |
    | @link https://developer.wordpress.org/block-editor/developers/filters/block-filters/#managing-block-categories
    |
    */

    'categories' => [
        [
            'slug'  => 'maps',
            'title' => __('Maps', 'tinypixel'),
            'icon'  => 'location-alt',
        ],
    ],
];
