<?php

namespace TinyPixel\Copernicus\Providers;

use TinyPixel\CopernicusServices\BlockCategory;

use TinyPixel\Copernicus\ServiceProvider;

class BlockCategoriesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('blocks.category', function () {
            return new BlockCategory();
        });

        dd($this);
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
