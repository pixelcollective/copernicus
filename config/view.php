<?php

$base = plugin_dir_path(__DIR__);

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most template systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views.
    |
    */

    'paths' => [
        "{$base}resources/views",
    ],

    /*
    |--------------------------------------------------------------------------
    | View Namespaces
    |--------------------------------------------------------------------------
    |
    | Blade has an underutilized feature that allows developers to add
    | supplemental view paths that may contain conflictingly named views.
    | These paths are prefixed with a namespace to get around the conflicts.
    | A use case might be including views from within a plugin folder.
    |
    */

    'namespaces' => [
        'block' => "{$base}resources/views/blocks",
    ],

    /*
    |--------------------------------------------------------------------------
    | View Composers
    |--------------------------------------------------------------------------
    |
    | View composers allow data to always be passed to certain views. This can
    | be useful when passing data to components such as hero elements,
    | navigation, banners, etc.
    |
    */

    'composers' => [

        /*
        |--------------------------------------------------------------------------
        | Global
        |--------------------------------------------------------------------------
        |
        */

        Copernicus\Composers\Block::class,

        /*
        |--------------------------------------------------------------------------
        | Blocks
        |--------------------------------------------------------------------------
        |
        */

        /*
        |--------------------------------------------------------------------------
        | Components
        |--------------------------------------------------------------------------
        |
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Blade Directives
    |--------------------------------------------------------------------------
    |
    */

    'directives' => [],

    /*
    |--------------------------------------------------------------------------
    | Blade Directives by filepath
    |--------------------------------------------------------------------------
    |
    */

    'directive_libraries' => [
        "{$base}app/Directives/Block.php",
        "{$base}app/Directives/SVGDirectives.php",
        "{$base}app/Directives/StyleDirectives.php",
        "{$base}app/Directives/BladeDirectives/BladeDirectives.php",
    ],
];
