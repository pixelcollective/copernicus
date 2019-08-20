<?php

use function Roots\env;

return [

    /*
    |--------------------------------------------------------------------------
    | Preflight Checks
    |--------------------------------------------------------------------------
    |
    | This value allows service providers to execute preflight tasks after
    | booting. These tasks include creating directories, databases, and files,
    | or doing any other checks to ensure the service is functional.
    |
    */

    'preflight' => true,

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('WP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('WP_DEBUG', false),

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
        TinyPixel\Copernicus\View\ViewServiceProvider::class,
        TinyPixel\Copernicus\Providers\PluginServiceProvider::class,
        TinyPixel\Copernicus\Providers\CopernicusServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases (formerly "Facades")
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'View' => Illuminate\Support\Facades\View::class,
    ],
];
