<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class ButtonComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class ButtonComponent extends AbstractComponent
{
    /**
     * Contains the type for this component.
     *
     * @var string
     */
    public $type;

    /**
     * Contains the value for this component.
     *
     * @var string
     */
    public $value;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/button.html';
    }
}