<?php

namespace Copernicus\App\Composers;

use Roots\Acorn\View\Composer;

class Block extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'block::*',
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
        $this->id = uniqid();
        $this->data = $data;

        return [
            'block' => (object) [
                'id'      => $this->id,
                'attr'    => $this->getAttributes(),
                'name'    => $this->getBlockName(),
                'content' => $this->getAttribute('content'),
                'source'  => $this->getAttribute('source'),
                'classes' => $this->getBlockClasses(),
            ],
        ];

        return $data;
    }

    /**
     * Gets the attribute block property
     *
     * @return string
     */
    public function getAttribute($attribute)
    {
        return isset($this->data['attr']->$attribute) ? $this->data['attr']->$attribute : null;
    }

    public function getAttributes()
    {
        return isset($this->data['attr']) ? $this->data['attr'] : null;
    }

    /**
     * Gets the block's name in `{namespace}-{handle}` format
     *
     * @return string
     */
    private function getBlockName()
    {
        $name = isset($this->data['attr']) ? $this->data['attr']->source['blockName'] : null;

        return str_replace('/', '-', $name);
    }

    /**
     * Fashions a CSS classname string
     * Format: `wp-block-{blockname} wp-block-{uniqid} align{alignment}`
     *
     * @return string
     */
    private function getBlockClasses()
    {
        $name = $this->getBlockName();
        $align = $this->getAttribute('align');

        $alignClass = isset($align) ? "align{$align}" : '';

        return sprintf(
            "%s %s %s",
            "wp-block-{$name}",
            "wp-block-{$this->id}",
            " {$alignClass}",
        );
    }
}
