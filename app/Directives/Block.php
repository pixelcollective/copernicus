<?php

namespace BlockModules\Directives\Block;

class Block
{
    public function __invoke()
    {
        return '<div class="<?php echo $classes; ?>">';
    }
}
