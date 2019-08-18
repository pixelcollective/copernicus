<?php

namespace TinyPixel\Copernicus\View;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\View\ViewServiceProvider as ViewServiceProviderBase;

class ViewServiceProvider extends ViewServiceProviderBase
{
    public function register()
    {
        parent::register();
        $this->registerMacros();
    }

    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {
            $finder = new FileViewFinder($app['files'], array_unique($app['config']['view.paths']));
            foreach ($app['config']['view.namespaces'] as $namespace => $hints) {
                $finder->addNamespace($namespace, $hints);
            }
            return $finder;
        });
        $this->app->alias('view.finder', FileViewFinder::class);
    }

    public function registerMacros()
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

            return ($engine instanceof \Illuminate\View\Engines\CompilerEngine)
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
                file_put_contents($loader, "<?= \\Roots\\view('{$view}', \$data ?? get_defined_vars()); ?>");
            }
            return $loader;
        });
    }

    public function boot()
    {
        $this->attachDirectives();
        $this->attachComponents();
        $this->attachComposers();
    }

    public function preflight(Filesystem $files)
    {
        $compiled_dir = $this->app['config']['view.compiled'];

        if (! $files->exists($compiled_dir)) {
            $files->makeDirectory($compiled_dir, 0755, true);
        }
    }

    public function attachDirectives()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();
        $directives = $this->app['config']['view.directives'];
        foreach ($directives as $name => $handler) {
            if (! is_callable($handler)) {
                $handler = $this->app->make($handler);
            }
            $blade->directive($name, $handler);
        }
    }

    public function attachComponents()
    {
        $components = $this->app->config['view.components'];

        if (is_array($components) && Arr::isAssoc($components)) {
            $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();
            foreach ($components as $alias => $view) {
                $blade->component($view, $alias);
            }
        }
    }

    public function attachComposers()
    {
        $view = $this->app['view'];
        foreach ($this->app->config['view.composers'] as $composer) {
            $view->composer($composer::views(), $composer);
        }
    }
}
