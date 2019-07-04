<?php

namespace Copernicus\Providers;

use Roots\Acorn\ServiceProvider;

class BladeDirectivesServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->collectedDirectives = collect();

        $this->collectedDirectives->push(
            collect($this->app['config']->get(
                'copernicus.view.directives'
            ))
        );

        collect($this->app['config']->get(
            'copernicus.view.directive_libraries'
        ))->each(function ($library) {
            $this->collectedDirectives->push(
                collect(require $library)
            );
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->collectedDirectives->each(function ($set) {
            $set->each(function ($handler, $directive) {
                \Blade::directive($directive, $handler);
            });
        });
    }
}
