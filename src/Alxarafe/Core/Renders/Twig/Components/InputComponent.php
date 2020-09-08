<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class InputComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class InputComponent extends AbstractComponent
{
    /**
     * Contains component type.
     *
     * @doc https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input
     *
     * @var string
     */
    public $type;

    /**
     * Contains component value.
     *
     * @var string
     */
    public $value;

    /**
     * Contains component minimum value.
     *
     * @var float
     */
    public $min;

    /**
     * Contains component maximum value.
     *
     * @var float
     */
    public $max;

    /**
     * Contains component pattern for regex validation.
     *
     * @var string
     */
    public $pattern;

    /**
     * Contains component placeholder.
     *
     * @var string
     */
    public $placeholder;

    /**
     * InputComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/input.html';
    }
}
