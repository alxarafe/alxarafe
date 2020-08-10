<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class ToggleComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class ToggleComponent extends AbstractComponent
{
    /**
     * Contains the content for this component.
     *
     * @var string
     */
    public $content;

    /**
     * ToggleComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);
        // $this->addCSS('resources/skins/default/bower_modules/bootstrap-toggle/css/bootstrap-toggle.min.css');
        // $this->addJS('resources/skins/default/bower_modules/bootstrap-toggle/js/bootstrap-toggle.min.js');
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/toggle.html';
    }
}
