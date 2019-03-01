<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Renders\Twig\Components;

/**
 * Class Button component
 *
 * @package Alxarafe\Renders\Twig\Components
 */
class Button extends AbstractComponent
{
    /**
     * Contains the text for this component.
     *
     * @var string
     */
    public $text;

    /**
     * Contains the style for this component.
     *
     * @var string
     */
    public $style;

    /**
     * Contains the type for this component.
     *
     * @var string
     */
    public $type;

    /**
     * Contains the link for this component.
     *
     * @var string
     */
    public $link;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return 'components/button';
    }
}
