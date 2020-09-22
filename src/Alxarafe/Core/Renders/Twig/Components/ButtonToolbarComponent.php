<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class ButtonToolbarComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class ButtonToolbarComponent extends AbstractComponent
{
    /**
     * Contains the role for this component.
     *
     * @var string
     */
    public $role;

    /**
     * Contains the ids for the buttons of this component.
     *
     * @var array
     */
    public $ids;

    /**
     * Contains the names for the buttons of this component.
     *
     * @var array
     */
    public $names;

    /**
     * Contains the texts for the buttons of this component.
     *
     * @var array
     */
    public $texts;

    /**
     * Contains the classes for the buttons of this component.
     *
     * @var array
     */
    public $classes;

    /**
     * ButtonToolbarComponent constructor.
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
        return '@Core/components/button-toolbar.html';
    }
}
