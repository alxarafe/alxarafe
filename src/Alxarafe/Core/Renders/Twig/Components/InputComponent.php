<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class InputComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class InputComponent extends AbstractComponent
{
    /**
     * Contains component type.
     *
     * @var bool
     */
    public $type;

    /**
     * Contains component value.
     *
     * @var string
     */
    public $value;

    public $min;
    public $max;
    public $pattern;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/input.html';
    }
}
