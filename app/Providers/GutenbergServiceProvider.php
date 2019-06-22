<?php

namespace Copernicus\Providers;

use Roots\Acorn\ServiceProvider;
use \Copernicus\Services\Gutenberg;

class GutenbergServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Registers Block service
         */
        $this->app->bind('gutenberg', function () {
            return new Gutenberg($this->app);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make('gutenberg')->configureEditor(
            $this->app['config']->get('gutenberg')
        );
    }
}
