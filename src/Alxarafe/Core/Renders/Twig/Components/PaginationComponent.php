<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class PaginationComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class PaginationComponent extends AbstractComponent
{
    /**
     * Contains links.
     *
     * @var array
     */
    public $links;

    /**
     * Contains texts.
     *
     * @var array
     */
    public $texts;

    /**
     * Contains classes.
     *
     * @var array
     */
    public $classes;

    /**
     * PaginationComponent constructor.
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
        return '@Core/components/pagination.html';
    }
}
