<?php

namespace Copernicus\Directives;

class BlockAsset
{
    public function __invoke($expression)
    {
        $pluginsUrl = plugins_url('copernicus');

        return sprintf("%s%s", "{$pluginsUrl}/resources/assets/", $expression);
    }
}
