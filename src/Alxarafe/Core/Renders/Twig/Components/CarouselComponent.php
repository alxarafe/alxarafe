<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class CarouselComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class CarouselComponent extends AbstractComponent
{
    /**
     * Contains if component is dismissible.
     *
     * @var bool
     */
    public $controls;

    /**
     * Contains the images for this component.
     *
     * @var array
     */
    public $images;

    /**
     * Contains the alternatives text images of this component.
     *
     * @var array
     */
    public $alts;

    /**
     * Contains the classes for the images of this component.
     *
     * @var array
     */
    public $classes;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/carousel.html';
    }
}
