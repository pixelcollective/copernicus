<?php

namespace BlockModules\Composers;

use Roots\Acorn\View\Composer;

class Block extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'blocks::*',
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
        $this->setData($data);

        return $this->getBladeData();
    }

    /**
     * Sets up block data and unique ID params
     *
     * @return void
     */
    public function setData($data)
    {
        $this->id = uniqid();
        $this->blockData = $data;
    }

    /**
     * Outputs to Blade view
     *
     * @return array
     */
    public function getBladeData()
    {
        return [
            'id'      => $this->id,
            'attr'    => $this->getBlockProp('attr'),
            'name'    => $this->getBlockName(),
            'content' => $this->getBlockProp('content'),
            'source'  => $this->getBlockProp('attr')->source,
            'classes' => $this->getBlockClasses(),
        ];
    }

    /**
     * Gets a property from the block
     *
     * @return mixed
     */
    public function getBlockProp($item)
    {
        return $this->blockData[$item];
    }

    /**
     * Gets the attribute block property
     *
     * @return string
     */
    public function getAttribute($attribute)
    {
        return isset($this->getBlockProp('attr')->$attribute)
            ? $this->getBlockProp('attr')->$attribute : null;
    }

    /**
     * Gets the block's name in `{namespace}-{handle}` format
     *
     * @return string
     */
    private function getBlockName()
    {
        return str_replace('/', '-', $this->getBlockProp('attr')->source['blockName']);
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
