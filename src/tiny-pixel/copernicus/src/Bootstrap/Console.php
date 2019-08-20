<?php

namespace TinyPixel\Copernicus\Bootstrap;

use WP_CLI;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use TinyPixel\Copernicus\Exceptions\Handler;
use TinyPixel\Copernicus\Console\Kernel;

class Console
{
    /**
     * Container instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Bootstrap console.
     *
     * @param  Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $this->app = $app;

        if ($this->app->runningInConsole()) {
            WP_CLI::add_command('copernicus', function () {
                $args = [];

                if (! empty($_SERVER['argv'])) {
                    $args = array_slice($_SERVER['argv'], 2);
                    array_unshift($args, $_SERVER['argv'][0]);
                }

                $this->app->singleton(
                    ExceptionHandler::class,
                    Handler::class
                );

                $kernel = $this->app->make(Kernel::class);

                $kernel->commands();

                $status = $kernel->handle(
                    $input = new ArgvInput($args),
                    new ConsoleOutput()
                );

                $kernel->terminate($input, $status);

                exit($status);
            });
        }
    }
}
