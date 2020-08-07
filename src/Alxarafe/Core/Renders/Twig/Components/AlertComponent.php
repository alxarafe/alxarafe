<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class AlertComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class AlertComponent extends AbstractComponent
{
    /**
     * Contains if component is dismissible.
     *
     * @var bool
     */
    public $dismissible;

    /**
     * Contains the text message for this component.
     *
     * @var string
     */
    public $message;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/alert.html';
    }
}
