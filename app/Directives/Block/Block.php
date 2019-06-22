<?php

namespace Copernicus\Directives\Block;

class Block
{
    public function __invoke()
    {
        return '<div class="<?php echo $block->classes; ?>">';
    }
}
