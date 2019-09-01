<?php

namespace TinyPixel\Base\Console\Commands;

use Illuminate\Support\Str;
use TinyPixel\Base\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TinyPixel\Base\Console\Commands\Command;
use Symphony\Component\Process\Process;

class BlockMakeCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \TinyPixel\Base\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:block
                            {name : The name of your Block.}
                            {title : The title of your Block.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Block';

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->getInputs();

        $path = getcwd() . '/' . strtolower($this->name);

        $this->paths = (object) [
            'base' => $path,
            'stubs' => $path . '/stubs',
            'components' => $path . '/components',
        ];

        if (!$this->files->isDirectory($this->paths->base)) {
            $this->files->makeDirectory($this->paths->base, 0777, true, true);
        }

        if (! $this->files->isDirectory($this->paths->components)) {
            $this->files->makeDirectory($this->paths->components, 0777, true, true);
        }

        $this->writeFiles();

        $this->info("{$this->namespace}/{$this->name}" . ' created successfully.');
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getInputs()
    {
        $blockName = explode('/', $this->argument('name'));
        $this->namespace = $blockName[0];
        $this->name = $blockName[1];

        $this->title = $this->argument('title');
    }

    /**
     * Build the class with the given name.
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function writeFiles()
    {
        $this->files->put($this->paths->base . '/block.js', $this->replaceDummies($this->files->get(__DIR__ . '/stubs/block.stub')));
        $this->files->put($this->paths->components . '/edit.js', $this->replaceDummies($this->files->get(__DIR__ . '/stubs/components/edit.stub')));
        $this->files->put($this->paths->components . '/index.js', $this->replaceDummies($this->files->get(__DIR__ . '/stubs/components/index.stub')));
        $this->files->put($this->paths->components . '/media.js', $this->replaceDummies($this->files->get(__DIR__ . '/stubs/components/media.stub')));
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceDummies($stub)
    {
        $stub = str_replace('dummyBlockName', $this->name, $stub);
        $stub = str_replace('dummyNamespace', $this->namespace, $stub);
        $stub = str_replace('dummyBlockTitle', $this->title, $stub);

        return $stub;
    }
}
