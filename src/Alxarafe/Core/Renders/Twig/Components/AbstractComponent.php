<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

use Alxarafe\Core\Base\Entity;
use Alxarafe\Core\Helpers\TwigFunctions;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Traits\MagicTrait;

/**
 * Class AbstractComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
abstract class AbstractComponent extends Entity
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
     * Data attributes for the component.
     *
     * @var array
     */
    public $dataAttr;

    /**
     * AbstractComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        foreach ($parameters as $property => $value) {
            $this->{$property} = $value;
            // Ensure this message is visible when is not a defined property
            if (!property_exists($this, $property)) {
                if (constant('DEBUG')) {
                    FlashMessages::getInstance()::setError(__CLASS__ . ": {$property} with value {$value} not exists, include it if needed.");
                }
            }
        }
    }

    /**
     * Return this component rendered.
     *
     * @return string
     */
    public function toHtml($readOnly = false): string
    {
        return (new TwigFunctions())->renderComponent($this->getTemplatePath(), $this->toArray($readOnly));
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
     * @param false $readOnly
     *
     * @return array $array populated array
     */
    public function toArray($readOnly = false): array
    {
        $array = [];
        // get public properties of this object
        $propertyList = array_keys(get_class_vars(get_class($this)));
        foreach ($propertyList as $property) {
            $array[$property] = $this->$property;
        }

        if ($readOnly) {
            $array['readonly'] = true;
        }

        return $array;
    }
}
