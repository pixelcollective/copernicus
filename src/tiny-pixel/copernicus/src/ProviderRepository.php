<?php

namespace TinyPixel\Copernicus;

use \Exception;
use Roots\Acorn\ProviderRepository as RootsProviderRepository;

class ProviderRepository
{
    /**
     * Write the service manifest file to disk.
     *
     * @param  array  $manifest
     * @return array
     *
     * @throws \Exception
     */
    public function writeManifest($manifest)
    {
        if (! is_writable(dirname($this->manifestPath))) {
            throw new Exception('The bootstrap/cache directory must be present and writable.');
        }

        $this->files->put(
            $this->manifestPath,
            '<?php return ' . var_export($manifest, true) . ';'
        );

        return array_merge(['when' => []], $manifest);
    }
}
