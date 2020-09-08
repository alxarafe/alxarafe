<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class ThumbnailComponent.
 *
 * Adds a component with a thumbnail of an image.
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
    public $value;
    /**
     * Contains the link.
     *
     * @var string
     */
    public $link;

    /**
     * ThumbnailComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);

        if (isset($this->value) && !isset($this->path)) {
            $this->setValue($this->value);
        }

        if (!isset($this->path) && isset($parameters['value'])) {
            $this->setValue($parameters['value']);
        }
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->path = $value;
    }

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
