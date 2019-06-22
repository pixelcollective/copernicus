<?php

namespace Copernicus\Directives\BladeDirectives;

use \Blade;

class DirectivesRepository
{
    /**
     * Register the directives.
     *
     * @param  array $directives
     * @return void
     */
    public static function register(array $directives)
    {
        collect($directives)->each(function ($item, $key) {
            Blade::directive($key, $item);
        });
    }

    /**
     * Parse expression.
     *
     * @param  string $expression
     * @return \Illuminate\Support\Collection
     */
    public static function parseMultipleArgs($expression)
    {
        return collect(explode(',', $expression))->map(function ($item) {
            return trim($item);
        });
    }

    /**
     * Strip single quotes.
     *
     * @param  string $expression
     * @return string
     */
    public static function stripQuotes($expression)
    {
        return str_replace("'", '', $expression);
    }

    public static function svgPath($expression)
    {
        return plugin_dir_path(__DIR__) . '../../resources/assets/svg' . $expression;
    }

    public static function root()
    {
        return plugin_dir_path(__DIR__) .'../';
    }
}
