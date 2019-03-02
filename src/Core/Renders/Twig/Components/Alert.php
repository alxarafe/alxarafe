<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Renders\Twig\Components;

/**
 * Class Alert component
 *
 * @package Alxarafe\Renders\Twig\Components
 */
class Alert extends AbstractComponent
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
        return 'components/alert.html';
    }
}
