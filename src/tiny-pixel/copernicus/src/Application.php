<?php

namespace TinyPixel\Copernicus;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use TinyPixel\Copernicus\Concerns\Application as LaravelApplication;
use TinyPixel\Copernicus\Concerns\Bindings;
use TinyPixel\Copernicus\Filesystem\Filesystem;
use TinyPixel\Copernicus\PackageManifest;
use TinyPixel\Copernicus\ProviderRepository;

/**
 * Application container
 *
 * Barebones version of Laravel's Application container.
 *
 * @copyright Tiny Pixel Collective, Roots Team, Taylor Otwell
 * @license   https://github.com/laravel/framework/blob/v5.8.4/LICENSE.md MIT
 * @license   https://github.com/laravel/lumen-framework/blob/v5.8.2/LICENSE.md MIT
 * @link      https://github.com/laravel/framework/blob/v5.8.4/src/Illuminate/Foundation/Application.php
 * @link      https://github.com/laravel/lumen-framework/blob/v5.8.2/src/Application.php
 */
class Copernicus extends Container implements ApplicationContract
{
    use LaravelApplication, Bindings;

    public const VERSION = 'Copernicus (1.0.0) (Patterned on Acorn 1.0.0)';

    /**  @var bool Indicates if the class aliases have been registered. */
    protected static $aliasesRegistered = false;

    /** @var array All of the loaded configuration files. */
    protected $loadedConfigurations = [];

    /**
     * Get the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        return static::$instance;
    }

    /**
     * Create a new Acorn application instance.
     *
     * @return void
     */
    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->basePath = $basePath;
        }

        $this->registerContainerBindings();
        $this->bootstrapContainer();
    }

    /**
     * Bootstrap the application container.
     *
     * @return void
     */
    protected function bootstrapContainer()
    {
        static::setInstance($this);

        $this->instance('app', $this);
        $this->instance(Container::class, $this);

        $this->instance(parent::class, $this);
        $this->instance(self::class, $this);
        $this->instance(static::class, $this);

        $this->instance(PackageManifest::class, new PackageManifest(
            new Filesystem(),
            $this->basePath(),
            $this->getCachedPackagesPath()
        ));

        $this->registerCoreContainerAliases();
    }

    /**
     * Prepare the application to execute a console command.
     *
     * @param  bool  $aliases
     * @return void
     */
    public function prepareForConsoleCommand($aliases = true)
    {
        $this->withAliases($aliases);

        $this->make('cache');

        $this->configure('database');

        $this->register('Illuminate\Database\MigrationServiceProvider');
    }

    /**
     * Configure and load the given component and provider.
     *
     * @param  string  $config
     * @param  \Illuminate\Support\ServiceProvider[]|\Illuminate\Support\ServiceProvider  $providers
     * @param  string|null  $return
     * @return mixed
     */
    public function loadComponent($config, $providers, $return = null)
    {
        $this->configure($config);

        foreach ((array) $providers as $provider) {
            $this->register($provider);
        }

        return $this->make($return ?: $config);
    }

    /**
     * Load a configuration file into the application.
     *
     * @param  string  $name
     * @return void
     */
    public function configure($name)
    {
        if (isset($this->loadedConfigurations[$name])) {
            return;
        }

        $this->loadedConfigurations[$name] = true;

        $path = $this->getConfigurationPath($name);

        if ($path) {
            $this->make('config')->set($name, require $path);
        }
    }

    /**
     * Get the path to the given configuration file.
     *
     * If no name is provided, then we'll return the path to the config folder.
     *
     * @param  string|null  $name
     * @return string
     */
    public function getConfigurationPath($name = null)
    {
        if (! $name) {
            $appConfigDir = $this->basePath('config') . '/';
            if (file_exists($appConfigDir)) {
                return $appConfigDir;
            } elseif (file_exists($path = dirname(dirname(__DIR__)) . '/config/')) {
                return $path;
            }
        } else {
            $appConfigPath = $this->basePath('config') . "/{$name}.php";
            if (file_exists($appConfigPath)) {
                return $appConfigPath;
            } elseif (file_exists($path = dirname(dirname(__DIR__)) . "/config/{$name}.php")) {
                return $path;
            }
        }
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        $providers = Collection::make($this->config['app.providers'])
            ->partition(function ($provider) {
                return Str::startsWith($provider, ['Illuminate\\', 'TinyPixel\\']);
            });

        $providers->splice(1, 0, [
            $this->make(PackageManifest::class)->providers()
        ]);

        (new ProviderRepository($this, new Filesystem(), $this->getCachedServicesPath()))
            ->load($providers->collapse()->toArray());
    }

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases()
    {
        // phpcs:disable
        $this->alias([
            'app'                  => [\TinyPixel\Copernicus\Copernicus::class, \Illuminate\Contracts\Container\Container::class, \Illuminate\Contracts\Foundation\Application::class, \Psr\Container\ContainerInterface::class],
            'blade.compiler'       => [\Illuminate\View\Compilers\BladeCompiler::class],
            'cache'                => [\Illuminate\Cache\CacheManager::class, \Illuminate\Contracts\Cache\Factory::class],
            'cache.store'          => [\Illuminate\Cache\Repository::class, \Illuminate\Contracts\Cache\Repository::class],
            'config'               => [\TinyPixel\Copernicus\Config::class, \Illuminate\Config\Repository::class, \Illuminate\Contracts\Config\Repository::class],
            'events'               => [\Illuminate\Events\Dispatcher::class, \Illuminate\Contracts\Events\Dispatcher::class],
            'files'                => [\TinyPixel\Filesystem\Filesystem::class, \Illuminate\Filesystem\Filesystem::class],
            'filesystem'           => [\Illuminate\Filesystem\FilesystemManager::class, \Illuminate\Contracts\Filesystem\Factory::class],
            'filesystem.disk'      => [\Illuminate\Contracts\Filesystem\Filesystem::class],
            'filesystem.cloud'     => [\Illuminate\Contracts\Filesystem\Cloud::class],
            'view'                 => [\Illuminate\View\Factory::class, \Illuminate\Contracts\View\Factory::class],
            'view.finder'          => [\TinyPixel\View\FileViewFinder::class, \Illuminate\View\FileViewFinder::class, \Illuminate\Contracts\View\FileViewFinder::class]
        ]);
        // phpcs:enable
    }

    /**
     * {@inheritDoc}
     *
     * Also accepts an array of aliases as the first parameter
     */
    public function alias($key, $alias = null)
    {
        if (is_iterable($key)) {
            array_map([$this, 'alias'], array_keys($key), array_values($key));
            return;
        }

        if (is_iterable($alias)) {
            array_map([$this, 'alias'], array_fill(0, count($alias), $key), $alias);
            return;
        }

        parent::alias($key, $alias);
    }

    /**
     * Resolve the given type from the container.
     *
     * @param  string $abstract
     * @param  array  $parameters
     * @return mixed
     */
    public function make($abstract, array $parameters = [])
    {
        $abstract = $this->getAlias($abstract);

        if (! $this->bound($abstract)) {
            $this->makeWithBinding($abstract);
        }

        return parent::make($abstract, $parameters);
    }

    /**
     * Register the aliases (AKA "Facades") for the application.
     *
     * @return void
     */
    public function withAliases()
    {
        if (static::$aliasesRegistered) {
            return;
        }

        $aliases = $this->make(PackageManifest::class)->aliases();

        spl_autoload_register(function ($alias) use ($aliases) {
            $aliases = array_merge($this->config['app.aliases'], $aliases);

            if (isset($aliases[$alias])) {
                return \class_alias($aliases[$alias], $alias);
            }
        }, true, true);

        require_once dirname(__DIR__) . '/globals.php';

        static::$aliasesRegistered = true;
    }
}
