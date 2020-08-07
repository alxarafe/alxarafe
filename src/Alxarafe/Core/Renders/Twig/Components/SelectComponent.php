<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class SelectComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class SelectComponent extends AbstractComponent
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
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/select.html';
    }
}
