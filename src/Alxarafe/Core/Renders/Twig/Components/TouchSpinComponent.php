<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class TouchSpinComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class TouchSpinComponent extends AbstractComponent
{
    /**
     * Contains the content for this component.
     *
     * @var string
     */
    public $content;

    /**
     * TouchSpinComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);
        // $this->addCSS('resources/skins/default/bower_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css');
        // $this->addJS('resources/skins/default/bower_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js');
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/touchspin.html';
    }
}
