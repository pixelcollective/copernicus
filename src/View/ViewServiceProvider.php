<?php

namespace TinyPixel\Base\View;

use Illuminate\View\View;
use Illuminate\View\Engines\CompilerEngine;
use Roots\Acorn\View\ViewServiceProvider as RootsViewServiceProvider;

class ViewServiceProvider extends RootsViewServiceProvider
{
    /**
     * Register view macros.
     *
     * @return void
     */
    public function registerMacros() : void
    {
        /**
         * Get the compiled path of the view
         *
         * @return string
         */
        View::macro('getCompiled', function () {
            /** @var string $file path to file */
            $file = $this->getPath();

            /** @var \Illuminate\Contracts\View\Engine $engine */
            $engine = $this->getEngine();

            return ($engine instanceof CompilerEngine)
                ? $engine->getCompiler()->getCompiledPath($file)
                : $file;
        });

        /**
         * Creates a loader for the view to be called later
         *
         * @return string
         */
        View::macro('makeLoader', function () {
            $view = $this->getName();
            $compiled = $this->getCompiled();
            $id = basename($compiled, '.php');
            $loader = dirname($compiled) . "/{$id}-loader.php";
            if (! file_exists($loader)) {
                file_put_contents($loader, "<?= \\TinyPixel\\Base\\view('{$view}', \$data ?? get_defined_vars()); ?>");
            }
            return $loader;
        });
    }

    /**
     * Boot view service.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->attachDirectives();
        $this->attachComponents();
        $this->attachComposers();
    }
}
