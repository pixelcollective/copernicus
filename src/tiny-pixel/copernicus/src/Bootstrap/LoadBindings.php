<?php

namespace TinyPixel\Copernicus\Bootstrap;

use Illuminate\Contracts\Foundation\Application;

class LoadBindings
{
    /**
     * Bootstrap the given application.
     *
     * @param  \TinyPixel\Copernicus\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if (class_uses($app, TinyPixel\Copernicus\Concerns\Bindings::class)) {
            $app->registerContainerBindings();
        }
    }
}
