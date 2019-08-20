<?php

namespace TinyPixel\Copernicus;

use Roots\Acorn\Application;
use Psr\Container\ContainerInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Illuminate\Events\Dispatcher as EventDispatcher;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcherContract;
use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;
use Illuminate\Filesystem\FilesystemManager as FilesystemManager;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;
use Illuminate\Contracts\Filesystem\Cloud as FilesystemCloudContract;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\Contracts\View\Factory as ViewContract;
use Illuminate\View\FileViewFinder as IlluminateFileViewFinder;
use Illuminate\Contracts\View\FileViewFinder as FileViewFinderContract;
use TinyPixel\Copernicus\Config;
use TinyPixel\Copernicus\PackageManifest;
use TinyPixel\Copernicus\ProviderRepository;
use TinyPixel\Copernicus\View\FileViewFinder;
use TinyPixel\Copernicus\Concerns\Bindings;
use TinyPixel\Copernicus\Concerns\Application as LaravelApplication;
use TinyPixel\Copernicus\Filesystem\Filesystem as CopernicusFilesystem;

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
class Copernicus extends Application implements ApplicationContract
{
    use LaravelApplication, Bindings;

    public const VERSION = 'Copernicus (1.0.0) (Patterned on Acorn 1.0.0)';

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases()
    {
        // phpcs:disable
        $this->alias([
            'app'              => [Copernicus::class, Container::class, ApplicationContract::class, ContainerInterface::class],
            'blade.compiler'   => [BladeCompiler::class],
            'cache'            => [CacheManager::class, CacheFactory::class],
            'cache.store'      => [CacheRepository::class, CacheContract::class],
            'config'           => [Config::class, ConfigRepository::class, ConfigContract::class],
            'events'           => [EventDispatcher::class, EventDispatcherContract::class],
            'files'            => [Filesystem::class, IlluminateFilesystem::class],
            'filesystem'       => [FilesystemManager::class, FilesystemFactory::class],
            'filesystem.disk'  => [FilesystemContract::class],
            'filesystem.cloud' => [FilesystemCloudContract::class],
            'view'             => [ViewFactory::class, ViewContract::class],
            'view.finder'      => [FileViewFinder::class, IlluminateFileViewFinder::class, FileViewFinderContract::class]
        ]);
        // phpcs:enable
    }
}
