<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Utils;
use Alxarafe\Providers\Container;
use Alxarafe\Providers\DebugTool;
use Exception;
use Kint\Kint;

/**
 * Class Entity
 *
 * @property string $id
 * @property string $idField
 * @property string $nameField
 *
 * @package Alxarafe\Base
 */
abstract class Entity
{
    /**
     * The debug tool used.
     *
     * @var DebugTool
     */
    public $debugTool;

    /**
     * Class short name.
     *
     * @var string
     */
    public $shortName;

    /**
     * Value of the main index for the active record. When a record is loaded, this field will contain its id and will
     * be the one that will be used for in the WHERE clause of the UPDATE. If it does not exist in file it will contain
     * ''.
     *
     * @var string
     */
    protected $id;

    /**
     * It is the name of the main id field. By default 'id'
     *
     * @var string
     */
    protected $idField;

    /**
     * It is the name of the field name. By default 'name'.
     * TODO: See if it may not exist, in which case, null or ''?
     *
     * @var string
     */
    protected $nameField;

    /**
     * Contains the new data of the current record. It will start when loading a record and will be used when making a
     * save.
     *
     * @var array
     */
    protected $newData;

    /**
     * It contains the data previous to the modification of the current record
     *
     * @var array
     */
    protected $oldData;

    /**
     * Entity constructor.
     */
    public function __construct()
    {
        $this->debugTool = Container::getInstance()::get('debugTool');
        $this->shortName = Utils::getShortName($this, get_called_class());
    }

    /**
     * Return the value of id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id ?? '';
    }

    /**
     * Returns the name of the identification field of the record. By default it will be name.
     *
     * @return string
     */
    public function getNameField(): string
    {
        return $this->nameField ?? 'name';
    }

    /**
     * Assign newData from $data.
     *
     * @param array|null $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->id = $data[$this->getIdField()] ?? null;
        $this->newData = $data;
        return $this;
    }

    /**
     * Returns the name of the main key field of the table (PK-Primary Key). By
     * default it will be id.
     *
     * @return string
     */
    public function getIdField(): string
    {
        return $this->idField;
    }

    /**
     * Return newData details.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->newData ?? [];
    }

    /**
     * Return oldData details.
     *
     * @return array
     */
    public function getOldData(): array
    {
        return $this->oldData ?? [];
    }

    /**
     * Assign oldData from an array.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setOldData(array $data)
    {
        $this->id = $data[$this->getIdField()] ?? null;
        $this->oldData = $data;
        return $this;
    }

    /**
     * Execute a magic method of the setField or getField style
     *
     * @param string $method
     * @param array  $params
     *
     * @return $this|mixed|null
     * @throws Exception
     */
    public function __call(string $method, array $params)
    {
        $command = substr($method, 0, 3); // set o get
        $field = Utils::camelToSnake(substr($method, 3)); // Lo que hay detrás del set o get
        if (method_exists($this, $method)) {
            return $this->{$method}($params);
        }
        switch ($command) {
            case 'set':
                $this->newData[$field] = $params[0] ?? '';
                return $this;
            case 'get':
                return $this->newData[$field] ?? null;
            default:
                Kint::dump("Review $method in " . $this->shortName . ". Error collecting the '$command/$field' attribute", $params, true);
                throw new Exception('Program halted!');
        }
    }

    /**
     * Magic getter.
     * It allows access to a field of the record using the attribute.
     * To access the name field, we should use $this->getName(), but thanks to this, we can also use $this->name.
     *
     * @param string $propertyName
     *
     * @return mixed
     */
    public function __get(string $propertyName)
    {
        if (property_exists($this, $propertyName)) {
            return $this->{$propertyName};
        }

        return $this->newData[$propertyName] ?? '';
    }

    /**
     * Magic setter.
     * Allows you to assign value to a field in the record using the attribute.
     * To assign a value to the name field, we should use $this->setName('Pepe'),
     * but thanks to this, we can also use $this->name='Pepe'.
     *
     * @param string $propertyName
     * @param mixed  $propertyValue
     *
     * @return $this
     */
    public function __set(string $propertyName, $propertyValue)
    {
        if (property_exists($this, $propertyName)) {
            $this->{$propertyName} = $propertyValue;
        } else {
            $this->newData[$propertyName] = $propertyValue;
        }
        return $this;
    }

    /**
     * Magic isset.
     *
     * @param string $propertyName
     *
     * @return bool
     */
    public function __isset($propertyName)
    {
        return isset($this->{$propertyName});
    }
}
