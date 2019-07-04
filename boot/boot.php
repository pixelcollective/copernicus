<?php

/**
 * Copernicus boot helper
 * @param string basePluginDir
 * @return \Copernicus\Boot\Copernicus
 */
function bootCopernicus(str $basePluginDir)
{
    require __DIR__ .'/Copernicus.php';

    $copernicus = new \Copernicus\Boot\Copernicus($basePluginDir);

    $copernicus
        ->preflight()
        ->registerWithAcorn();

    return $copernicus;
}

// EOF
