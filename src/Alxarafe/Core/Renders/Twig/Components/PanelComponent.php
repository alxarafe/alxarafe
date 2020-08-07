<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class PanelComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class PanelComponent extends AbstractComponent
{
    /**
     * Contains header for this component.
     *
     * @var string
     */
    public $header;

    /**
     * Contains header text for this component.
     *
     * @var string
     */
    public $headerText;

    /**
     * Contains body text for this component.
     *
     * @var string
     */
    public $bodyText;

    /**
     * Contains footer text for this component.
     *
     * @var string
     */
    public $footerText;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/panel.html';
    }
}
