<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class NavComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class NavComponent extends AbstractComponent
{
    /**
     * Contains type for this component..
     *
     * @var string
     */
    public $type;

    /**
     * Contains classes for items of this component.
     *
     * @var array
     */
    public $classes;

    /**
     * Contains texts for items of this component.
     *
     * @var array
     */
    public $texts;

    /**
     * Contains links for items of this component.
     *
     * @var array
     */
    public $links;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/nav.html';
    }
}
