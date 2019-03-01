<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Renders\Twig\Components;

use Alxarafe\Helpers\TwigFunctions;
use Alxarafe\Traits\MagicTrait;

/**
 * Class AbstractComponent
 *
 * @package Alxarafe\Renders\Twig\Components
 */
abstract class AbstractComponent
{
    use MagicTrait;

    /**
     * ID tag for the component.
     *
     * @var string
     */
    public $id;

    /**
     * Name tag for the component.
     *
     * @var string
     */
    public $name;

    /**
     * Class tag for the component.
     *
     * @var string
     */
    public $class;

    /**
     * AbstractComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        foreach ($parameters as $property => $value) {
            // Only assign defined properties
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    abstract public function getTemplatePath(): string;

    /**
     * Return this component rendered.
     *
     * @return string
     */
    public function toHtml(): string
    {
        return (new TwigFunctions())->renderComponent($this->getTemplatePath(), $this->toArray());
    }

    /**
     * Returns this object public properties to array.
     *
     * @return array $array populated array
     */
    public function toArray(): array
    {
        $array = [];
        // get public properties of this object
        $propertyList = array_keys(get_class_vars(get_class($this)));
        foreach ($propertyList as $property) {
            $array[$property] = $this->$property;
        }
        return $array;
    }
}
