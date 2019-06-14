<?php

namespace BlockModules\Providers;

use \Roots\Acorn\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        collect($this->app['config']->get('blocks.paths'))->each(function ($view) {
            $this->app['view']->addLocation($view);
        });
    }
}
