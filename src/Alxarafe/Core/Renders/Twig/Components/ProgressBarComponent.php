<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class ProgressBarComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class ProgressBarComponent extends AbstractComponent
{
    /**
     * Contains percentage value.
     *
     * @var float
     */
    public $percentage;

    /**
     * Contains the text.
     *
     * @var string
     */
    public $text;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/progressbar.html';
    }
}
