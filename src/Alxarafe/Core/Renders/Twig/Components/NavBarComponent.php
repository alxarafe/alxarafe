<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class NavBarComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class NavBarComponent extends AbstractComponent
{

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/navbar.html';
    }
}
