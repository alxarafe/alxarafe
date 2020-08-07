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
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/page-header.html';
    }
}
