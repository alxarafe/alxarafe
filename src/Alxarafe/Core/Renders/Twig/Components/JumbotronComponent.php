<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class JumbotronComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class JumbotronComponent extends AbstractComponent
{
    /**
     * Contains the text for this component.
     *
     * @var string
     */
    public $text;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/jumbotron.html';
    }
}
