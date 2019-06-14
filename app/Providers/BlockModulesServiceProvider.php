<?php

namespace BlockModules\Providers;

use \Roots\Acorn\ServiceProvider;
use \BlockModules\Services\Block;

class BlockModulesServiceProvider extends ServiceProvider
{
    /**
     * Register the plugin with the application container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('blocks', function () {
            return new Block($this->app);
        });

        $this->blocks = collect($this->app['config']->get('blocks.registry')) ?? null;
    }

    /**
     * Run the plugin
     *
     * @return void
     */
    public function boot()
    {
        if ($this->blocks) {
            $this->blocks->each(function ($block) {
                $this->app->make('blocks')->register($block);
            });
        }
    }
}
