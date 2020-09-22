<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class DropdownComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class DropdownComponent extends AbstractComponent
{
    /**
     * Contains component type.
     *
     * @var bool
     */
    public $type;

    /**
     * Contains the text for this component.
     *
     * @var string
     */
    public $text;

    /**
     * Contains the alignement for this component.
     *
     * @var string
     */
    public $alignement;

    /**
     * Contains the texts for the parts of this component.
     *
     * @var array
     */
    public $texts;

    /**
     * Contains the links for the parts of this component.
     *
     * @var array
     */
    public $links;

    /**
     * Contains the classes for the parts of this component.
     *
     * @var array
     */
    public $classes;

    /**
     * DropdownComponent constructor.
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
        return '@Core/components/dropdown.html';
    }
}
