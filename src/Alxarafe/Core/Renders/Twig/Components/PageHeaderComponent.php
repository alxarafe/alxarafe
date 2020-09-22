<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class PageHeaderComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class PageHeaderComponent extends AbstractComponent
{
    /**
     * Contains title for this component.
     *
     * @var string
     */
    public $title;

    /**
     * Contains header for this component.
     *
     * @var string
     */
    public $header;

    /**
     * Contains small title for this component.
     *
     * @var string
     */
    public $small;

    /**
     * PageHeaderComponent constructor.
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
        return '@Core/components/page-header.html';
    }
}
