<?php

namespace Copernicus\Providers;

use \Copernicus\Services\BlockCategory;

use Roots\Acorn\ServiceProvider;

class BlockCategoriesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Registers Block Category service
         *
         */
        $this->app->bind('blocks.category', function () {
            return new BlockCategory();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $categories = $this->app['config']->get('blocks.categories');

        collect($categories)->each(function ($category) {
            $this->app->make('blocks.category')->register($category);
        });
    }
}
