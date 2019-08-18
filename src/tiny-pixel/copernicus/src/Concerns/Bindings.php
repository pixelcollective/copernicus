<?php

namespace TinyPixel\Copernicus\Concerns;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\LogManager;
use Illuminate\Support\Composer;
use Zend\Diactoros\Response as PsrResponse;

trait Bindings
{
    /** @var string[] The service binding methods that have been executed.*/
    protected $ranServiceBinders = [];

    /** @var array The available container bindings and their respective load methods. */
    public $availableBindings = [];

    /**
     * Register available core container bindings and their respective load methods.
     *
     * @return void
     */
    public function registerContainerBindings()
    {
        // phpcs:disable
        foreach([
            'registerCacheBindings' => ['cache', 'cache.store', \Illuminate\Contracts\Cache\Factory::class, \Illuminate\Contracts\Cache\Repository::class],
            'registerConfigBindings' => ['config'],
            'registerConsoleBindings' => ['artisan', 'console', \Acorn\Console\Kernel::class, \Illuminate\Contracts\Console\Kernel::class],
            'registerEventBindings' => ['events', \Illuminate\Contracts\Events\Dispatcher::class],
            'registerFilesBindings' => ['files', \TinyPixel\Copernicus\Filesystem\Filesystem::class, \Illuminate\Filesystem\Filesystem::class],
            'registerFilesystemBindings' => ['filesystem', 'filesystem.cloud', 'filesystem.disk', \Illuminate\Contracts\Filesystem\Factory::class, \Illuminate\Contracts\Filesystem\Cloud::class, \Illuminate\Contracts\Filesystem\Filesystem::class],
            'registerViewBindings' => ['view', \Illuminate\Contracts\View\Factory::class],
        ] as $method => $abstracts) {
            foreach($abstracts as $abstract) {
                $this->availableBindings[$abstract] = $method;
            }
        }
        // phpcs:enable
    }

    /**
     * Resolve the given type from a binding.
     *
     * @param string $abstract
     * @return void
     */
    public function makeWithBinding($abstract)
    {
        if (array_key_exists($abstract, $this->availableBindings)
            && ! array_key_exists($this->availableBindings[$abstract], $this->ranServiceBinders)
        ) {
            $this->{$method = $this->availableBindings[$abstract]}();
            $this->ranServiceBinders[$method] = true;
        }
    }

    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerCacheBindings()
    {
        $this->singleton('cache', function () {
            return $this->loadComponent('cache', \Illuminate\Cache\CacheServiceProvider::class);
        });

        $this->singleton('cache.store', function () {
            return $this->loadComponent('cache', \Illuminate\Cache\CacheServiceProvider::class, 'cache.store');
        });
    }

    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerConfigBindings()
    {
        $this->singleton('config', function () {
            return new ConfigRepository();
        });
    }

    /**
     * Registeer container bindings for the application.
     *
     * @return void
     */
    protected function registerConsoleBindings()
    {
        $this->singleton('console', \TinyPixel\Copernicus\Console\Kernel::class);
    }

    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerEventBindings()
    {
        $this->singleton('events', function () {
            $this->register(\Illuminate\Events\EventServiceProvider::class);
            return $this->make('events');
        });
    }


    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerFilesBindings()
    {
        $this->singleton('files', function () {
            return new \TinyPixel\Copernicus\Filesystem\Filesystem();
        });
    }

    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerFilesystemBindings()
    {
        $this->singleton('filesystem', function () {
            return $this->loadComponent(
                'filesystems',
                \TinyPixel\Copernicus\Filesystem\FilesystemServiceProvider::class,
                'filesystem'
            );
        });

        $this->singleton('filesystem.disk', function () {
            return $this->loadComponent(
                'filesystems',
                \TinyPixel\Copernicus\Filesystem\FilesystemServiceProvider::class,
                'filesystem.disk'
            );
        });

        $this->singleton('filesystem.cloud', function () {
            return $this->loadComponent(
                'filesystems',
                \TinyPixel\Copernicus\Filesystem\FilesystemServiceProvider::class,
                'filesystem.cloud'
            );
        });
    }

    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerViewBindings()
    {
        $this->singleton('view', function () {
            return $this->loadComponent('view', \Illuminate\View\ViewServiceProvider::class);
        });
    }
}
