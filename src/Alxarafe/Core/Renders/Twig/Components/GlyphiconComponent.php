<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class GlyphiconComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class GlyphiconComponent extends AbstractComponent
{
    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/glyphicon.html';
    }
}
