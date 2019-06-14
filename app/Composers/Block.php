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
        $this->setTemplateData($data);

        $data = [
            'blockId' => $this->blockId,
            'class'   => "{$this->classes->base} {$this->classes->unique} {$this->classes->align}",
            'attr'    => $this->blockData->get('attr'),
        ];

        return $data;
    }

    private function setTemplateData($data)
    {
        $this->blockData = collect($data)->recursive();

        $this->blockId = uniqid();

        $this->classes = (object) [
            'base'   => "wp-block-{$this->blockData->get('attr.source.blockName')}",
            'unique' => "wp-block-{$this->blockId}",
            'align'  => $this->alignmentClasses($this->blockData->get('attr.align')),
        ];
    }

    private function alignmentClasses($alignment)
    {
        if (!is_null($alignment)) {
            return "align{$alignment}";
        }
    }
}
