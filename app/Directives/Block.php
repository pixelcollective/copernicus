<?php

namespace Copernicus\Directives;

use \Copernicus\Directives\BladeDirectives\DirectivesRepository;

return [

    'block' => function () {
        return '<div class="<?php echo $block->classes; ?>">';
    },

    'endblock' => function () {
        return '</div>';
    },
];
