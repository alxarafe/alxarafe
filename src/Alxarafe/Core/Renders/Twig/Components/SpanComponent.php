<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class Button component
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class SpanComponent extends AbstractComponent
{
    /**
     * Contains the text for this component.
     *
     * @var string
     */
    public $text;

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
        return '@Core/components/span.html';
    }
}
