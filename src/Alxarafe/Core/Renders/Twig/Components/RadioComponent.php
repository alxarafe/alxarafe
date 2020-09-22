<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class RadioComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class RadioComponent extends AbstractComponent
{
    /**
     * Contains component type.
     *
     * @var string
     */
    public $type;

    /**
     * Contains the text message for this component.
     *
     * @var string
     */
    public $message;

    /**
     * RadioComponent constructor.
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
        return '@Core/components/radio.html';
    }
}
