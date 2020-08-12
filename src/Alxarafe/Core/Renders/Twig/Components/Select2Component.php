<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class Select2Component
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class Select2Component extends AbstractComponent
{
    /**
     * Contains if component must use multiple selection.
     *
     * @var bool
     */
    public $multiple;

    /**
     * Contains the text for the option.
     *
     * @var array
     */
    public $texts;

    /**
     * Contains the values for the option.
     *
     * @var array
     */
    public $values;

    /**
     * AbstractComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);

        $this->dataAttr = [
            'ajax--url' => '&method=ajaxSearch&table=' . $parameters['struct']->referencedtable,
            'placeholder' => $parameters['placeholder'] ?? '',
            'id' => $parameters['value'] ?? null,
            'allow-clear' => 'true',
        ];

        if (isset($parameters['data']) && !empty($parameters['data'])) {
            $this->dataAttr = array_merge($this->dataAttr, $parameters['data']);
        }
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/select2.html';
    }
}
