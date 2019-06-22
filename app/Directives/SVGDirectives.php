<?php

namespace Copernicus\Directives;

use \Copernicus\Directives\BladeDirectives\DirectivesRepository;

return [

    /*
    |---------------------------------------------------------------------
    | SVGs and Icons
    |---------------------------------------------------------------------
    */

    /**
     * Plain SVG
     */
    'blockSvg' => function ($expression) {
        $expression = DirectivesRepository::stripQuotes($expression);

        return file_get_contents(
            DirectivesRepository::svgPath("/{$expression}.svg")
        );
    },

    /**
     * Font Awesome Solid
     */
    'block_fas' => function ($expression) {
        $expression = DirectivesRepository::stripQuotes($expression);

        return file_get_contents(
            DirectivesRepository::svgPath("fa/solid/{$expression}.svg")
        );
    },

    /**
     * Font Awesome
     */
    'block_fa' => function ($expression) {
        $expression = DirectivesRepository::stripQuotes($expression);

        return file_get_contents(
            DirectivesRepository::svgPath("fa/regular/{$expression}.svg")
        );
    },

    /**
     * Font Awesome Brands
     */
    'block_fab' => function ($expression) {
        $expression = DirectivesRepository::stripQuotes($expression);

        return file_get_contents(
            DirectivesRepository::svgPath("fa/brands/{$expression}.svg")
        );
    },
];
