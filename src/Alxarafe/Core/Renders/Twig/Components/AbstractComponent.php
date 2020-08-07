<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

use Alxarafe\Core\Helpers\TwigFunctions;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Traits\MagicTrait;

/**
 * Class AbstractComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
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
     * Class style for the component.
     *
     * @var string
     */
    public $style;

    /**
     * AbstractComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        foreach ($parameters as $property => $value) {
            $this->{$property} = $value;
            //TODO: Ensure this message is visible when is not a defined property
            if (!property_exists($this, $property)) {
                FlashMessages::getInstance()::setError(__CLASS__ . ": {$property} with value {$value} not exists, include it if needed.");
            }
        }
    }

    /**
     * Return this component rendered.
     *
     * @return string
     */
    public function toHtml(): string
    {
        dump($this);
        return (new TwigFunctions())->renderComponent($this->getTemplatePath(), $this->toArray());
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    abstract public function getTemplatePath(): string;

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
