<?php

namespace TinyPixel\Copernicus;

use Exception;
use TinyPixel\Copernicus\Filesystem\Filesystem;
use Roots\Acorn\PackageManifest as RootsPackageManifest;

class PackageManifest extends RootsPackageManifest
{
    /**
     * Build the manifest and write it to disk.
     *
     * @return void
     */
    public function build()
    {
        $packages = [];

        if ($this->files->exists($path = $this->vendorPath . '/composer/installed.json')) {
            $packages = json_decode($this->files->get($path), true);
        }

        $ignoreAll = in_array('*', $ignore = $this->packagesToIgnore());

        $this->write(collect($packages)->mapWithKeys(function ($package) {
            return [$this->format($package['name']) => $package['extra']['copernicus'] ?? []];
        })->each(function ($configuration) use (&$ignore) {
            $ignore = array_merge($ignore, $configuration['dont-discover'] ?? []);
        })->reject(function ($configuration, $package) use ($ignore, $ignoreAll) {
            return $ignoreAll || in_array($package, $ignore);
        })->filter()->all());
    }

    /**
     * Get all of the package names that should be ignored.
     *
     * @return array
     */
    protected function packagesToIgnore()
    {
        if (! file_exists($this->basePath . '/composer.json')) {
            return [];
        }

        return json_decode(file_get_contents(
            $this->basePath . '/composer.json'
        ), true)['extra']['copernicus']['dont-discover'] ?? [];
    }
}
