<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class BreadcrumbComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class BreadcrumbComponent extends AbstractComponent
{
    /**
     * Contains the texts for the items for this component.
     *
     * @var array
     */
    public $texts;

    /**
     * Contains the classes for the items for this component.
     *
     * @var array
     */
    public $classes;

    /**
     * Contains the links for the items for this component.
     *
     * @var array
     */
    public $links;

    /**
     * BreadcrumbComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);

        // TODO: Verify all fields
//        if (!isset($this->path)) {
//            $this->path = $parameters['value'];
//        }
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/breadcrumb.html';
    }
}
