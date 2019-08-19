<?php

namespace TinyPixel\Copernicus\Blocks;

use function \add_filter;
use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Block category manager.
 */
class BlockCategoryManager
{
    /**
     * Register
     *
     * @param $category
     *
     * @return void
     */
    public function register($category) : void
    {
        add_filter('block_categories', function ($categories, $post) use ($category) {
            $categories = array_merge($categories, [[
                'slug'  => $category['slug'],
                'title' => $category['title'],
                'icon'  => $category['icon'],
            ]]);

            return $categories;
        }, 10, 2);
    }
}
