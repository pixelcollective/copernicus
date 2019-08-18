<?php

namespace TinyPixel\Copernicus\Bootstrap;

use TinyPixel\Copernicus\Copernicus as Application;
use TinyPixel\Copernicus\Console\Kernel;
use Illuminate\Contracts\Debug\ExceptionHandler;
use TinyPixel\Copernicus\Exceptions\Handler;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

use WP_CLI;

class Console
{
    protected $app;

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
                    \Illuminate\Contracts\Debug\ExceptionHandler::class,
                    \TinyPixel\Copernicus\Exceptions\Handler::class
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
