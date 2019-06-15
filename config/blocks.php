<?php

$blocks = plugin_dir_path(__DIR__) . '/blocks.json';

return [

    /*
    |--------------------------------------------------------------------------
    | Block Namespace
    |--------------------------------------------------------------------------
    |
    | The namespace used to designate blocks within JS assets
    |
    */
    'namespace' => 'mutombo',

    /*
    |--------------------------------------------------------------------------
    | Block Registry
    |--------------------------------------------------------------------------
    |
    | The namespace used to designate blocks within JS assets
    |
    */
    'registry' => json_decode(file_get_contents($blocks)),

    /*
    |--------------------------------------------------------------------------
    | Block Categories
    |--------------------------------------------------------------------------
    */
    'categories' => [
        [
            'slug'  => 'maps',
            'title' => __('Maps', 'tinypixel'),
            'icon'  => 'location-alt',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugin Assets
    |--------------------------------------------------------------------------
    |
    | These settings help the plugin find your excellent work and share it
    | with the world.
    |
    */

    'assets' => [
        /*
        |--------------------------------------------------------------------------
        | Assets Directory URL
        |--------------------------------------------------------------------------
        |
        | The asset manifest contains relative paths to your assets. This URL will
        | be prepended when using Clover's asset management system. Change this if
        | you are pushing to a CDN.
        |
        */

        'uri' => plugins_url('block-modules') . '/dist',

        /*
        |--------------------------------------------------------------------------
        | Assets Directory Path
        |--------------------------------------------------------------------------
        |
        | The asset manifest contains relative paths to your assets. This path will
        | be prepended when using Clover's asset management system.
        |
        */

        'path' => plugin_dir_path(__DIR__) . 'dist',

        /*
        |--------------------------------------------------------------------------
        | Assets Manifest
        |--------------------------------------------------------------------------
        |
        | Your asset manifest is used by Clover to assist WordPress and your views
        | with rendering the correct URLs for your assets. This is especially
        | useful for statically referencing assets with dynamically changing names
        | as in the case of cache-busting.
        |
        */

        'manifest' => dirname(__DIR__) . '/dist/assets.json',
    ],

    /*
    |--------------------------------------------------------------------------
    | View Storage Path
    |--------------------------------------------------------------------------
    |
    | Most template systems load templates from disk. Here you may specify
    | the location on your disk where your views are located.
    |
    */

    'views' => dirname(__DIR__) . '/resources/views/blocks',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [
        BlockModules\Providers\BlockModulesServiceProvider::class,
    ],

    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
    ],

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
        plugin_dir_path(__DIR__) . 'resources/views',
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the uploads
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => get_theme_file_path('/storage/framework/views'),

    /*
    |--------------------------------------------------------------------------
    | View Debugger
    |--------------------------------------------------------------------------
    |
    | Enabling this option will display the current view name and data. Giving
    | it a value of 'view' will only display view names. Giving it a value of
    | 'data' will only display current data. Giving it any other truthy value
    | will display both.
    |
    */

    'debug' => false,

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
        'BlockComponents' => plugin_dir_path(__DIR__) . 'resources/views/blocks/components',
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
        BlockModules\Composers\Block::class,
        BlockModules\Composers\Components\Heading::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | View Directives
    |--------------------------------------------------------------------------
    |
    | The namespaces where view components reside. Components can be referenced
    | with camelCase & dot notation.
    |
    */

    'directives' => [
        'block'      => \BlockModules\Directives\Block\Block::class,
        'endblock'   => \BlockModules\Directives\Block\EndBlock::class,
        'blockasset' => \BlockModules\Directives\BlockAsset::class,
    ],
];
