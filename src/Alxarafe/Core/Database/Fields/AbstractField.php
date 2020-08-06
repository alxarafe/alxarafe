<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Translator;

abstract class AbstractField
{
    /**
     * Contains an array with the errors accumulated since the last run of getErrors
     *
     * @var array
     */
    public static $errors = [];
    /**
     * Contains the instance of the translator.
     *
     * @var Translator
     */
    public $trans;
    /**
     * TODO: Define
     *
     * @var string
     */
    public $type;
    /**
     * TODO: Define
     *
     * @var string
     */
    public $length;
    /**
     * TODO: Define
     *
     * @var string
     */
    public $default;
    /**
     * TODO: Define
     *
     * @var string
     */
    public $nullable;
    /**
     * TODO: Define
     *
     * @var string
     */
    public $referencedtable;
    /**
     * TODO: Define
     *
     * @var string
     */
    public $referencedfield;
    /**
     * Contains an array with de name of required fields.
     * Each descendant adds its own using addRequiredFields.
     *
     * @var array
     */
    private $requiredFields = [];

    /**
     * Contains an array with the name of the optional fields.
     * Each descendant adds its own using addRequiredFields.
     *
     * @var array
     */
    private $optionalFields = [];

    /**
     * AbstractComponent constructor.
     *
     * @param $parameters
     */
    public function __construct()
    {
        $this->trans = Translator::getInstance();
        $this->addRequiredFields(['type', 'length', 'default', 'nullable']);
        $this->addOptionalFields(['referencedtable', 'referencedfield']);
    }

    public function addRequiredFields(array $fields = [])
    {
        $this->requiredFields = array_merge($this->requiredFields, $fields);
    }

    public function addOptionalFields(array $fields = [])
    {
        $this->optionalFields = array_merge($this->optionalFields, $fields);
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

    /**
     * The passed value is verified to meet the necessary requirements for the field.
     * The field name is needed in case you have to show a message, to be able to
     * report what field it is.
     * The value of the field may be returned modified if the test can correct it.
     * Returns true if the value is valid.
     *
     * @param $key
     * @param $value
     *
     * @return bool
     */
    abstract public function test($key, &$value): bool;

    /**
     * Assign values to the attributes.
     *
     * @param array $data
     */
    public function assignData(array $data)
    {
        foreach ($this->requiredFields as $property) {
            $this->{$property} = $data[$property] ?? null;
            //TODO: Ensure this message is visible when is not a defined property
            if (!property_exists($this, $property)) {
                FlashMessages::getInstance()::setError(__CLASS__ . ": {$property} with value {$value} not exists, include it if needed.");
            }
        }
        foreach ($this->optionalFields as $property) {
            $this->{$property} = $data[$property] ?? null;
            //TODO: Ensure this message is visible when is not a defined property
            if (!property_exists($this, $property)) {
                FlashMessages::getInstance()::setError(__CLASS__ . ": {$property} with value {$value} not exists, include it if needed.");
            }
        }
    }

    /**
     * Returns an array with all the attributes defined in the class.
     *
     * @return array
     */
    public function getStructArray(): array
    {
        $return = [];
        foreach ($this->requiredFields as $fieldName) {
            $return[$fieldName] = $this->{$fieldName};
        }
        foreach ($this->optionalFields as $fieldName) {
            if (isset($this->{$fieldName})) {
                $return[$fieldName] = $this->{$fieldName};
            }
        }
        return $return;
    }
}
