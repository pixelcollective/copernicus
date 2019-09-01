<?php

namespace TinyPixel\Base\Console;

use \Exception;
use \Throwable;
use \RuntimeException;
use \ReflectionClass;
use Roots\Acorn\Console\Kernel as RootsKernel;

class Kernel extends RootsKernel
{
    /**
     * The Console commands provided by the application.
     *
     * @var array
     */
    protected $commands = [
        'TinyPixel\Base\Console\Commands\BlockMakeCommand',
    ];

    /**
     * Run the console application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    public function handle($input, $output = null)
    {
        try {
            return $this->getConsole()->run($input, $output);
        } catch (Exception $e) {
            $this->renderException($output, $e);

            return 1;
        } catch (Throwable $e) {
            $this->renderException($output, new Exception($e));

            return 1;
        }
    }
}
