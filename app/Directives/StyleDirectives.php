<?php

namespace Copernicus\Directives;

use \Copernicus\Directives\BladeDirectives\DirectivesRepository;

return [

    /*
    |---------------------------------------------------------------------
    | @styled / @endstyled
    |---------------------------------------------------------------------
    */

    'styles' => function () {
        return "<style type=\"text/css\">";
    },

    'endstyles' => function () {
        return "</style>";
    },

    /*
    |---------------------------------------------------------------------
    | @styled / @endstyled
    |---------------------------------------------------------------------
    */

    'styled' => function ($expression) {
        return sprintf(
            ".%s {",
            DirectivesRepository::stripQuotes($expression),
        );
    },

    'endstyled' => function () {
        return "}";
    },

    /*
    |---------------------------------------------------------------------
    | @styledid / @endstyledid
    |---------------------------------------------------------------------
    */

    'styledid' => function ($expression) {
        return sprintf(
            "#%s {",
            DirectivesRepository::stripQuotes($expression),
        );
    },

    'endstyledid' => function () {
        return "}";
    },

    /*
    |---------------------------------------------------------------------
    | @screens / @endscreens
    |---------------------------------------------------------------------
    */

    'screens' => function ($expression) {
        return sprintf("@media(%s) {", $expression);
    },

    'endscreens' => function () {
        return "}";
    },

    /*
    |---------------------------------------------------------------------
    | @rule
    |---------------------------------------------------------------------
    */

    'rule' => function ($expression) {
        return sprintf(
            "%s;",
            DirectivesRepository::stripQuotes($expression)
        );
    },

    /*
    |---------------------------------------------------------------------
    | @bgimage
    |---------------------------------------------------------------------
    */

    'bgimage' => function ($expression) {
        return sprintf(
            "background-image: url(%s);",
            DirectivesRepository::stripQuotes($expression)
        );
    },

    /*
    |---------------------------------------------------------------------
    | @bgposition
    |---------------------------------------------------------------------
    */

    'bgimage' => function ($expression) {
        return sprintf(
            "background-image: url(%s);",
            DirectivesRepository::stripQuotes($expression)
        );
    },

    /*
    |---------------------------------------------------------------------
    | @bgcolor
    |---------------------------------------------------------------------
    */

    'bgcolor' => function ($expression) {
        return sprintf(
            "background-color: %s;",
            $expression
        );
    },

    /*
    |---------------------------------------------------------------------
    | @bgfocus
    |---------------------------------------------------------------------
    */

    'bgfocus' => function ($expression) {
        $xVal = isset($expression) && isset($expression['x']) ? $expression['x'] * 100 : 50;
        $yVal = isset($expression) && isset($expression['y']) ? $expression['y'] * 100 : 50;

        $focus = (object) [
            'x' => "{$xVal}%",
            'y' => "{$yVal}%",
        ];

        return sprintf("background-position: %s %s;", $focus->x, $focus->y);
    },

    /*
    |---------------------------------------------------------------------
    | @bgsize
    |---------------------------------------------------------------------
    */

    'bgsize' => function ($expression) {
        $size = isset($expression) && is_numeric($expression) ? "{$expression}%" : "cover";
        return sprintf("background-size: %s;", $size);
    },

    /*
    |---------------------------------------------------------------------
    | @bgrepeat
    |---------------------------------------------------------------------
    */

    'bgrepeat' => function ($expression) {
        return sprintf("background-repeat: %s;", $expression);
    },
];
