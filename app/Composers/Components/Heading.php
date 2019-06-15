<?php

namespace BlockModules\Composers\Components;

use Roots\Acorn\View\Composer;

class Heading extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'BlockComponents::heading.*',
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
            'components' => (object) [
                'class' => 'font-display uppercase pb-4 font-bold tracking-wide'
            ]
        ];

        return $data;
    }
}
