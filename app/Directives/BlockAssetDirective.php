<?php

namespace BlockModules\Directives;

class BlockAssetDirective
{
    public function __invoke($expression)
    {
        $pluginsUrl = plugins_url('block-modules');
        return sprintf("%s%s", "{$pluginsUrl}/resources/assets/", $expression);
    }
}
