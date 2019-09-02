<?php

namespace TinyPixel\Copernicus\Providers;

use function \apply_filters;
use function \add_filter;
use Roots\Acorn\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;

class CopernicusServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->blocks = Collection::make(
            apply_filters('copernicus\blocks', [])
        );

        $this->assets = Collection::make(
            apply_filters('copernicus\assets', [])
        );


        $this->blocks->each(function ($block) {
            $this->app->singleton($block, function ($app) use ($block) {
                return (new $block($app));
            });
        });

        $this->assets->each(function ($asset, $baseDir) {
            $this->app->singleton($asset, function ($app) use ($asset, $baseDir) {
                return (new $asset($app))(plugins_url($baseDir));
            });
        });

        $this->app->singleton('copernicus.filters', function () {
            add_filter('render_block_data', function ($block, $source) {
                $block['attrs']['inner'] = (object) [
                    'html'    => $source['innerHTML'],
                    'content' => $source['innerContent'],
                ];

                return $block;
            }, 10, 2);
        });
    }

    /**
     * Boot any application services.s
     *
     * @return void
     */
    public function boot($views = []) : void
    {
        $this->views = Collection::make(
            apply_filters('copernicus\views', [])
        );

        if (!$this->views->isEmpty()) {
            $this->views->each(function ($path, $namespace) {
                $this->loadViewsFrom($path, $namespace);
            });
        }

        $this->commands([
            \TinyPixel\Copernicus\Console\Commands\MakeBlockCommand::class,
        ]);

        $this->blocks->each(function ($block) {
            $this->app->make($block);
        });

        $this->assets->each(function ($asset) {
            $this->app->make($asset);
        });

        $this->app->make('copernicus.filters');
    }
}
