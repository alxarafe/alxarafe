<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class AccordionComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class AccordionComponent extends AbstractComponent
{
    /**
     * Contains the accordions for the panels of this component.
     *
     * @var array[]
     */
    public $panels;

    /**
     * Contains the accordions for the panels of this component.
     *
     * @var array[]
     */
    public $accordions;

    /**
     * Contains the collapse names for the panels of this component.
     *
     * @var array[]
     */
    public $collapse;

    /**
     * Contains the title for the panels of this component.
     *
     * @var array[]
     */
    public $titles;

    /**
     * Contains the text for the panels of this component.
     *
     * @var array[]
     */
    public $texts;

    /**
     * AccordionComponent constructor.
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
        return '@Core/components/accordion.html';
    }
}
