<?php

namespace BlockModules\Composers;

use Roots\Acorn\View\Composer;

class About extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'blocks::tinyblocks.about.render',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @param  array $data
     * @param  \Illuminate\View\View $view
     * @return array
     */
    public function with($data, $view)
    {
        $data = [
            'tailwind' => (object) [
                'heading' => 'font-display text-4xl uppercase pb-4',
            ],
        ];

        return $data;
    }
}
