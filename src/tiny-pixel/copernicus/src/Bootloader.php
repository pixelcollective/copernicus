<?php

namespace TinyPixel\Copernicus;

use function \doing_action;
use function \did_action;
use function \apply_filters;
use function Roots\add_filters;
use function Roots\env;
use TinyPixel\Copernicus\Copernicus;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Roots\Acorn\Bootloader as RootsBootloader;

/**
 * Copernicus Bootloader
 *
 * Barebones version of Acorn's bootloader.
 */
class Bootloader extends RootsBootloader
{
    /**
     * Boot hooks
     * @var array
     */
    public $bootHooks = [
        'after_setup_theme',
        'rest_api_init',
    ];

    /**
     * Bootstrap
     * @var array
     */
    public $bootstrap = [
        \TinyPixel\Copernicus\Bootstrap\LoadConfiguration::class,
        \TinyPixel\Copernicus\Bootstrap\LoadBindings::class,
        \TinyPixel\Copernicus\Bootstrap\RegisterProviders::class,
        \TinyPixel\Copernicus\Bootstrap\Console::class,
    ];

    /**
     * Create a new bootloader instance
     *
     * @param string $application_class Copernicus
     * @param string $basePath
     * @uses  \Roots\add_filters
     */
    public function __construct(
        string $applicationClass = Copernicus::class,
        string $basePath
    ) {
        $this->applicationClass = $applicationClass;
        $this->basePath = $basePath;

        add_filters($this->bootHooks, $this, 5);
    }

    /**
     * Boot the Application
     *
     * @return null
     */
    public function __invoke() : void
    {
        if (!$this->ready()) {
            return;
        }

        $this->app()->boot();
    }

    /**
     * Determines whether the application is ready to boot
     *
     * @return bool
     * @uses   \did_action
     * @uses   \doing_action
     * @uses   \apply_filters
     */
    public function ready() : bool
    {
        if ($this->ready) {
            return true;
        }

        foreach ($this->bootHooks as $hook) {
            if (\did_action($hook) || \doing_action($hook)) {
                return $this->ready = true;
            }
        }

        return $this->ready = !! \apply_filters(
            'copernicus/ready',
            false
        );
    }

    /**
     * Get application instance
     *
     * @return \Illuminate\Contracts\Foundation\Application
     */
    protected function app() : ApplicationContract
    {
        static $app;

        if ($app) {
            return $app;
        }

        $bootstrap = $this->bootstrap();

        $app = new $this->applicationClass($this->basePath);
        $app->bootstrapWith($bootstrap);

        return $app;
    }

    /**
     * Get the list of application bootstraps
     *
     * @return array
     * @uses   \apply_filters
     */
    protected function bootstrap() : array
    {
        return \apply_filters(
            'copernicus/bootstrap',
            $this->bootstrap
        );
    }
}
