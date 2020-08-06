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
     * Contains de translated fields values.
     *
     * @var array
     */
    public $translatedFields = [];
    /**
     * Translator instance
     *
     * @var Translator
     */
    public $trans;
    /**
     * Contains an array with de name of required fields.
     * Each descendant adds its own using addRequiredFields.
     *
     * @var array
     */
    private $requiredFields = [];
    /**
     * Contains an array with the fields that need to be translated into the user's language.
     * Each descendant adds its own using addTranslatableFields.
     *
     * @var array
     */
    private $translatableFields = [];

    /**
     * AbstractComponent constructor.
     *
     * @param $parameters
     */
    public function __construct()
    {
        $this->trans = Translator::getInstance();
        $this->addRequiredFields(['type', 'length', 'default', 'nullable']);
        $this->addTranslatableFields(['label', 'shortlabel', 'placeholder']);
    }

    public function addRequiredFields(array $fields = [])
    {
        $this->requiredFields = array_merge($this->requiredFields, $fields);
    }

    public function addTranslatableFields(array $fields = [])
    {
        $this->translatableFields = array_merge($this->translatableFields, $fields);
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

    abstract public function test($key, &$value);

    public function assignData(array $data)
    {
        foreach ($this->requiredFields as $property) {
            $this->{$property} = $data[$property] ?? null;
            //TODO: Ensure this message is visible when is not a defined property
            if (!property_exists($this, $property)) {
                FlashMessages::getInstance()::setError(__CLASS__ . ": {$property} with value {$value} not exists, include it if needed.");
            }
            unset($data[$property]);
        }

        foreach ($this->translatableFields as $property) {
            $this->{$property} = $data[$property] ?? '';
            //TODO: Ensure this message is visible when is not a defined property
            if (!property_exists($this, $property)) {
                FlashMessages::getInstance()::setError(__CLASS__ . ": {$property} with value {$value} not exists, include it if needed.");
            }
            $this->translatedFields[$property] = $this->trans->trans($this->{$property});
            unset($data[$property]);
        }
    }

    public function getStructArray(): array
    {
        $return = [];
        foreach ([$this->requiredFields, $this->translatableFields] as $values) {
            foreach ($values as $fieldName) {
                $return[$fieldName] = $this->{$fieldName};
            }
        }
        return $return;
    }
}
