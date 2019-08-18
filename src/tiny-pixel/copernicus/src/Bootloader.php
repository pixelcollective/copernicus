<?php

namespace TinyPixel\Copernicus;

use function Roots\add_filters;
use function Roots\env;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use TinyPixel\Copernicus\Copernicus as Application;

class Bootloader
{
    /** @var string Application to be instantiated at boot time */
    protected $application_class;

    /** @var string[] WordPress hooks that will boot application */
    protected $boot_hooks;

    /** @var callable[] Callbacks to be run when application boots */
    protected $queue = [];

    /** @var bool Signals that application is ready to boot */
    protected $ready = false;

    /**
     * Create a new bootloader instance
     *
     * @param string|iterable $boot_hooks WordPress hooks to boot application
     * @param string $application_class Application class
     */
    public function __construct(
        $boot_hooks = ['after_setup_theme', 'rest_api_init'],
        string $application_class = Application::class,
        string $basePath
    ) {
        $this->application_class = $application_class;
        $this->boot_hooks = (array) $boot_hooks;
        $this->basePath = $basePath;

        add_filters($this->boot_hooks, $this, 5);
    }

    /**
     * Enqueues callback to be loaded with application
     *
     * @param callable $callback
     * @return static;
     */
    public function call(callable $callback) : Bootloader
    {
        if (! $this->ready()) {
            $this->queue[] = $callback;
            return $this;
        }

        $this->app()->call($callback);
        return $this;
    }

    /**
     * Determines whether the application is ready to boot
     *
     * @return bool
     */
    public function ready() : bool
    {
        if ($this->ready) {
            return true;
        }

        foreach ($this->boot_hooks as $hook) {
            if (\did_action($hook) || \doing_action($hook)) {
                return $this->ready = true;
            }
        }

        return $this->ready = !! \apply_filters('copernicus/ready', false);
    }

    /**
     * Boot the Application
     */
    public function __invoke()
    {
        static $app;

        if (! $this->ready()) {
            return;
        }

        $app = $this->app();

        foreach ($this->queue as $callback) {
            $app->call($callback);
        }
        $this->queue = [];

        return $app->boot();
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

        $app = new $this->application_class($this->basePath);
        $app->bootstrapWith($bootstrap);

        return $app;
    }

    /**
     * Get the list of application bootstraps
     *
     * @return string[]
     */
    protected function bootstrap() : array
    {
        $bootstrap = [
            \TinyPixel\Copernicus\Bootstrap\LoadConfiguration::class,
            \TinyPixel\Copernicus\Bootstrap\LoadBindings::class,
            \TinyPixel\Copernicus\Bootstrap\RegisterProviders::class,
            \TinyPixel\Copernicus\Bootstrap\Console::class,
        ];

        return \apply_filters('copernicus/bootstrap', $bootstrap);
    }
}
