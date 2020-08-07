<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class ThumbnailComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class ThumbnailComponent extends AbstractComponent
{
    /**
     * Contains the text message.
     *
     * @var string
     */
    public $message;
    /**
     * Contains the path.
     *
     * @var string
     */
    public $path;
    /**
     * Contains the link.
     *
     * @var string
     */
    public $link;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/thumbnail.html';
    }
}
