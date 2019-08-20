<?php

namespace TinyPixel\Copernicus\Console\Commands;

class BlockMakeCommand extends GeneratorCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:block {name* : The name of your Block.}
                           {--views= : List of views served by the composer}
                           {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Block';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Block';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/block.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Composers';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        return $this->replaceViews($stub, explode(' ', $this->option('views')));
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  array   $views
     * @return string
     */
    protected function replaceViews($stub, $views)
    {
        $views = implode("',\n        '", $views);

        return str_replace('DummyViews', empty($views) ? '//' : "'{$views}'", $stub);
    }
}
