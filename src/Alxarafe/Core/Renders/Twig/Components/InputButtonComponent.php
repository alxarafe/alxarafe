<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class InputButtonComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class InputButtonComponent extends AbstractComponent
{
    /**
     * Contains if component is dismissible.
     *
     * @var string
     */
    public $position;

    /**
     * Contains the text message for this component.
     *
     * @var array
     */
    public $texts;

    /**
     * InputButtonComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);

        // TODO: Verify all fields
//        if (!isset($this->path)) {
//            $this->path = $parameters['value'];
//        }
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/input-button.html';
    }
}
