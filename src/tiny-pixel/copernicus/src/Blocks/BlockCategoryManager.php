<?php

namespace TinyPixel\Copernicus\Blocks;

use function \add_filter;
use Illuminate\Support\Collection;
use TinyPixel\Copernicus\Copernicus as Application;

/**
 * Block category manager
 *
 */
class BlockCategoryManager
{
    /**
     * Categories
     *
     * @var \Illuminate\Support\Collection
     */
    protected $categories;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->categories = Collection::make();
    }

    /**
     * Add category.
     *
     * @param  string $name
     * @param  string $title
     * @param  string $icon
     * @return void
     */
    public function add(
        string $name,
        string $title,
        string $icon
    ) : void {
        $this->categories->push([
            'slug'  => $name,
            'title' => $title,
            'icon'  => $icon,
        ]);
    }

    /**
     * Register categories.
     *
     * @uses   \add_filter
     * @param  $category
     * @return void
     */
    public function register() : void
    {
        \add_filter('block_categories', function ($categories, $post) {
            $mergedCategories = $this->categories->merge(
                Collection::make($categories)
            );

            return $mergedCategories->toArray();
        }, 10, 2);
    }
}
