<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Traits\MagicTrait;

abstract class AbstractField
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
     * Contains an array with the errors accumulated since the last run of getErrors
     *
     * @var array
     */
    public static $errors = [];

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
     * Clear accumulated errors and return pending ones.
     *
     * @return array
     */
    public static function getErrors()
    {
        $return = self::$errors;
        self::$errors = [];
        return $return;
    }

    abstract public static function test($key, $struct, &$value);
}
