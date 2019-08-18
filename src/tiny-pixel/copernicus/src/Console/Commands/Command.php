<?php

namespace TinyPixel\Copernicus\Console\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Command as CommandBase;

abstract class Command extends CommandBase
{
    /**
     * Holds an instance of the app.
     *
     * @var \TinyPixel\Copernicus\Application
     */
    protected $app;

    /**
     * {@inheritdoc}
     */
    public function schedule(Schedule $schedule)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setLaravel($laravel)
    {
        parent::setLaravel($this->app = $laravel);
    }

    /**
     * Displays the given string as title.
     *
     * @param  string $title
     * @return \TinyPixel\Copernicus\Console\Commands\Command
     */
    public function title($title)
    {
        $size = strlen($title);
        $spaces = str_repeat(' ', $size);

        $this->output->newLine();
        $this->output->writeln("<bg=blue;fg=white>$spaces$spaces$spaces</>");
        $this->output->writeln("<bg=blue;fg=white>$spaces$title$spaces</>");
        $this->output->writeln("<bg=blue;fg=white>$spaces$spaces$spaces</>");
        $this->output->newLine();

        return $this;
    }
}
