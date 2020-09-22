<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class InputGroupComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class InputGroupComponent extends AbstractComponent
{
    /**
     * Contains component position.
     *
     * @var string
     */
    public $position;

    /**
     * Contains component texts.
     *
     * @var array
     */
    public $texts;

    /**
     * InputGroupComponent constructor.
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
        return '@Core/components/input-group.html';
    }
}
