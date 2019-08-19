<?php

namespace TinyPixel\Copernicus\Blocks;

use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Block Asset Manager
 *
 */
class BlockAssetManager
{
    /**
     * Constructor.
     *
     * @param TinyPixel\Copernicus\Copernicus
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->baseUrl  = $this->app['config']->get('filesystems.disks.local.url') .'/dist/';
        $this->basePath = $this->app['config']->get('filesystems.disks.local.root');

        return $this;
    }

    /**
     * New asset
     *
     * @param string $assetName
     */
    public function new($assetName)
    {
        $this->{$assetName} = $this->app->make('block.asset');

        $this->{$assetName}
             ->setBase($this->baseUrl, $this->basePath)
             ->label($assetName);

        return $this->{$assetName};
    }
}
