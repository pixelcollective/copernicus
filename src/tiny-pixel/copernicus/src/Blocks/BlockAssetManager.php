<?php

namespace TinyPixel\Copernicus\Blocks;

use Illuminate\Support\Collection;
use TinyPixel\Copernicus\Blocks\BlockAsset;
use Illuminate\Contracts\Foundation\Application;

/**
 * Block Asset Manager
 *
 */
class BlockAssetManager
{
    /**
     * Assets
     * @var Illuminate\Support\Collection
     */
    protected $assets;

    /**
     * Distributables Url.
     * @var string
     */
    protected $distUrl;

    /**
     * Distributables path.
     * @var string
     */
    protected $distPath;

    /**
     * Constructor.
     *
     * @param Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->distUrl  = $this->app['config']->get('filesystems.disks.local.url') . '/dist/';
        $this->distPath = $this->app['config']->get('filesystems.disks.local.root');

        $this->assets = Collection::make();

        return $this;
    }

    /**
     * Add asset.
     *
     * @param  string $assetName
     * @return TinyPixel\Copernicus\Blocks\BlockAsset
     */
    public function add(string $assetName) : BlockAsset
    {
        $this->{$assetName} = $this->app->make('block.asset');

        $this->{$assetName}
             ->setDist($this->distUrl, $this->distPath)
             ->setLabel($assetName);

        $this->assets->push($this->{$assetName});

        return $this->{$assetName};
    }
}
