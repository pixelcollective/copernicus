<?php

namespace TinyPixel\Copernicus\Blocks;

use function \add_action;
use function \wp_enqueue_script;
use function \wp_enqueue_style;
use Illuminate\Support\Collection;
use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Block Asset
 *
 */
class BlockAsset
{
    /**
     * Asset label.
     * @var string
     */
    protected $label;

    /**
     * Distributables base URL.
     * @var string
     */
    protected $distUrl;

    /**
     * Distributables base path.
     * @var string
     */
    protected $distPath;

    /**
     * Asset filename.
     * @var string
     */
    protected $fileName;

    /**
     * Paired block (conditionally load asset when block is used)
     * @var string
     */
    protected $pairedBlock;

    /**
     * Associated block namespace.
     * @var string
     */
    protected $namespace;

    /**
     * Asset dependencies.
     * @var \Illuminate\Support\Collection
     */
    protected $dependencies;

    /**
     * WordPress action utilized to enqueue asset.
     * @var string
     */
    protected $enqueueAction;

    /**
     * Actions lookup table.
     * @var array
     */
    protected $actions = [
        'public' => 'wp_enqueue_scripts',
        'editor' => 'enqueue_block_editor_assets',
        'admin'  => 'admin_enqueue_scripts',
    ];

    /**
     * General editor dependencies
     * @var \Illuminate\Support\Collection
     */
    protected $editorDependencies = [
        'wp-editor',
        'wp-element',
        'wp-blocks',
    ];

    /**
     * Constructor.
     *
     * @param TinyPixel\Copernicus\Copernicus $app
     */
    public function __construct(Application $app)
    {
        $this->app                = $app;
        $this->namespace          = $app['config']->get('blocks.namespace');

        $this->editorDependencies = Collection::make($this->editorDependencies);
        $this->dependencies       = Collection::make();

        return $this;
    }

    /**
     * Setter: Asset label.
     *
     * @param  string $assetLabel
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function setLabel(string $assetLabel) : BlockAsset
    {
        $this->label = $assetLabel;

        return $this;
    }

    /**
     * Setter: Conditionally load asset with specified block.
     *
     * @param  string $blockName
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function pairWith(string $blockName) : BlockAsset
    {
        $this->pairedBlock = $blockName;

        return $this;
    }

    /**
     * Setter: Action to enqueue with.
     *
     * @param  string $action key
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function loadWith(string $action) : BlockAsset
    {
        $this->enqueueAction = $action;

        return $this;
    }

    /**
     * Setter: Asset dependencies.
     *
     * @param  array $dependencies
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function dependsOn(array $dependencies) : BlockAsset
    {
        Collection::make($dependencies)->each(function ($dependency) {
            $this->dependencies->push($dependency);
        });

        return $this;
    }

    /**
     * Setter: Distributables URL and path.
     *
     * @param  string $url
     * @param  string $path
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function setDist(string $url, string $path) : BlockAsset
    {
        $this->distUrl = $url;
        $this->distPath = $path . 'dist';

        return $this;
    }

    /**
     * Handles style asset registration.
     *
     * @param string $fileName
     *
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function style(string $fileName)
    {
        /**
         * Bail if requested file isn't available.
         */
        if (! $this->assetExists($this->fileName = $fileName)) {
            return;
        }

        /**
         * Enqueue stylesheet.
         */
        add_action($this->action(), [$this, 'enqueueStyle']);

        return $this;
    }

    /**
     * Handles script asset registration.
     *
     * @param  string $fileName
     * @return {void|TinyPixel\Copernicus\Blocks\BlockAsset}
     * @uses   \add_action
     */
    public function script(string $fileName)
    {
        /**
         * Bail if requested file isn't available.
         */
        if (! $this->assetExists($this->fileName = $fileName)) {
            return;
        }

        /**
         * Bail if block is set to load conditionally and is
         * not utilized on page.
         */
        if ($this->assetShouldBeEnqueued()) {
            return;
        }

        /**
         * Enqueue script.
         */
        \add_action($this->actions[$this->enqueueAction], [$this, 'enqueueScript']);

        return $this;
    }

    /**
     * Enqueues JavaScript asset.
     *
     * @return void
     * @uses   \wp_enqueue_script
     */
    public function enqueueScript() : void
    {
        \wp_enqueue_script(
            $this->label(),
            $this->url(),
            $this->dependencies(),
            null,
            true
        );
    }

    /**
     * Enqueues CSS asset.
     *
     * @return void
     * @uses   \wp_enqueue_style
     */
    public function enqueueStyle() : void
    {
        \wp_enqueue_style(
            $this->label(),
            $this->url(),
            $this->dependencies(),
            'all'
        );
    }

    /**
     * Returns a boolean representing whether a public asset
     * should be enqueued.
     *
     * @return bool
     */
    protected function assetShouldBeEnqueued() : bool
    {
        return isset($this->pairedBlock) && ! has_block(
            $this->qualifiedName($this->pairedBlock, $this->namespace())
        );
    }

    /**
     * Returns a boolean representing whether an asset file
     * is locatable.
     *
     * @param  string $filename
     * @return bool
     */
    protected function assetExists(string $fileName) : bool
    {
        return file_exists($this->path($fileName));
    }

   /**
     * Determine if block is bound to the editor and return
     * appropriate dependencies.
     *
     * @param  string $action
     * @return array
     */
    protected function dependencies() : array
    {
        if ($this->enqueueAction=='public') {
            return $this->publicDependencies();
        }

        if ($this->enqueueAction=='editor') {
            return $this->editorDependencies();
        }
    }

    /**
     * Returns specified dependencies.
     *
     * @return array
     */
    protected function publicDependencies() : array
    {
        return ! $this->dependencies->isEmpty() ?
            $this->dependencies->toArray() :
            [];
    }

    /**
     * Returns specified dependencies along with
     * baseline editor dependencies.
     *
     * @param  string $fileName
     * @return array
     */
    protected function editorDependencies() : array
    {
        if(! $this->dependencies->isEmpty()) {
            $this->dependencies->each(function ($dependency) {
                $this->editorDependencies->push($dependency);
            });
        }

        return ! $this->editorDependencies->isEmpty() ?
            $this->editorDependencies->toArray() :
            [];
    }

    /**
     * Returns path to file.
     *
     * @return string
     */
    protected function path($fileName) : string
    {
        return "{$this->distPath}/{$fileName}";
    }

    /**
     * Returns full blockname, including namespace.
     *
     * @param  string $blockName
     * @param  string $namespace
     * @return string
     */
    protected function qualifiedName(string $blockName, string $namespace) : string
    {
        return "{$this->namespace}/{$blockName}";
    }

    /**
     * Return WordPress action from short name (key).
     *
     * @return string
     */
    protected function action() : string
    {
        return $this->actions[$this->enqueueAction];
    }

    /**
     * Getter: Asset label.
     *
     * @return string
     */
    protected function label() : string
    {
        return $this->label;
    }

    /**
     * Getter: Asset URL.
     *
     * @return string
     */
    protected function url() : string
    {
        return "{$this->distUrl}{$this->fileName}";
    }

    /**
     * Getter: namespace.
     *
     * @return string
     */
    protected function namespace() : string
    {
        return $this->namespace;
    }
}
