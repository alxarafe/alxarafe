<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class MediaObjectComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class MediaObjectComponent extends AbstractComponent
{
    /**
     * Contains a list of titles.
     *
     * @var array
     */
    public $titles;
    /**
     * Contains a list of texts.
     *
     * @var array
     */
    public $texts;
    /**
     * Contains a list of image sources.
     *
     * @var array
     */
    public $imgSrc;
    /**
     * Contains a list of image horizontal position.
     *
     * @var array
     */
    public $imgHPos;
    /**
     * Contains a list of image vertical position.
     *
     * @var array
     */
    public $imgVPos;
    /**
     * Contains a list of image alternative text.
     *
     * @var array
     */
    public $imgAlt;
    /**
     * Contains a list of image style.
     *
     * @var array
     */
    public $imgStyle;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/media-object.html';
    }
}
