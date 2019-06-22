<?php

namespace Copernicus\Services;

class BlockCategory
{
    public function register($category)
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
