<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class SpanComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class SpanComponent extends AbstractComponent
{

    /**
     * Contains the content for this component.
     *
     * @var string
     */
    public $content;

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
