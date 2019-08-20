<?php

namespace TinyPixel\Copernicus\Concerns;

use Illuminate\Log\LogManager;
use Illuminate\Support\Composer;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Contracts\Filesystem\Cloud as FilesystemCloud;
use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;
use Illuminate\Contracts\Console\Kernel as IlluminateKernel;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\Foundation\Application;
use TinyPixel\Copernicus\Console\Kernel as CopernicusKernel;
use TinyPixel\Copernicus\Filesystem\Filesystem as CopernicusFilesystem;
use TinyPixel\Copernicus\Filesystem\FilesystemServiceProvider as CopernicusFilesystemServiceProvider;
use TinyPixel\Copernicus\Plugin\PluginServiceProvider;

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
            'registerCacheBindings'      => ['cache', 'cache.store', CacheFactory::class, CacheRepository::class],
            'registerConfigBindings'     => ['config'],
            'registerConsoleBindings'    => ['artisan', 'console', CopernicusKernel::class, IlluminateKernel::class],
            'registerEventBindings'      => ['events', EventDispatcher::class],
            'registerFilesBindings'      => ['files', CopernicusFilesystem::class, IlluminateFilesystem::class],
            'registerFilesystemBindings' => ['filesystem', 'filesystem.cloud', 'filesystem.disk', FilesystemFactory::class, FilesystemCloud::class, FilesystemContract::class],
            'registerViewBindings'       => ['view', ViewFactory::class],
            'registerPluginBindings'     => ['plugin']
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
            return $this->loadComponent('cache', CacheServiceProvider::class);
        });

        $this->singleton('cache.store', function () {
            return $this->loadComponent('cache', CacheServiceProvider::class, 'cache.store');
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
        $this->singleton('console', CopernicusKernel::class);
    }

    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerEventBindings()
    {
        $this->singleton('events', function () {
            $this->register(EventServiceProvider::class);

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
            return new CopernicusFilesystem();
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
                CopernicusFilesystemServiceProvider::class,
                'filesystem'
            );
        });

        $this->singleton('filesystem.disk', function () {
            return $this->loadComponent(
                'filesystems',
                CopernicusFilesystemServiceProvider::class,
                'filesystem.disk'
            );
        });

        $this->singleton('filesystem.cloud', function () {
            return $this->loadComponent(
                'filesystems',
                CopernicusFilesystemServiceProvider::class,
                'filesystem.cloud'
            );
        });
    }

    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerPluginBindings()
    {
        $this->singleton('plugin', function () {
            return new PluginServiceProvider();
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
            return $this->loadComponent('view', ViewServiceProvider::class);
        });
    }
}
