<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use Alxarafe\Helpers\Schema;
use Alxarafe\Helpers\Utils;
use Exception;
use ReflectionClass;

/**
 * Class SimpleTable has all the basic methods to access and manipulate information, but without modifying its
 * structure.
 */
class SimpleTable
{

    /**
     * It is the name of the table.
     *
     * @var string
     */
    public $tableName;

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
     * It contains the data previous to the modification of the current record
     *
     * @var array
     */
    protected $oldData;

    /**
     * Contains the new data of the current record. It will start when loading a record and will be used when making a
     * save.
     *
     * @var array
     */
    protected $newData;

    /**
     * Build a Table model. $table is the name of the table in the database.
     * $params is a parameters array:
     * - create is true if the table is to be created if it does not exist (false by default)
     * - idField is the name of the primary key (default id)
     * - nameField is the name of the descriptive field (name by default)
     *
     * @param string $tableName
     * @param array  $params
     */
    public function __construct(string $tableName, array $params = [])
    {
        $shortName = (new ReflectionClass($this))->getShortName();
        Debug::startTimer($shortName, $shortName . ' Simple Constructor');
        $this->tableName = $tableName;
        $this->idField = $params['idField'] ?? null;
        $this->setStructure();
        if (!isset($this->idField) && isset(Config::$bbddStructure[$this->tableName]['fields'])) {
            $this->idField = 'id';
            foreach (Config::$bbddStructure[$this->tableName]['fields'] as $key => $value) {
                if (isset($value['key']) && ($value['key'] == 'primary')) {
                    $this->idField = $key;
                    break;
                }
            }
        }
        Debug::stopTimer($shortName);
    }

    /**
     * Execute a call to setTableStructure with an array containing 3 arrays with the fields, keys and default values
     * for the table.
     *
     * The development will be more ambitious than what is defined.
     *
     * Currently Table includes a single table, but the idea is to be able to relate tables to form complex data
     * models.
     */
    public function setStructure(): void
    {
        $this->setTableStructure($this->tableName, $this->getStructureArray());
    }

    /**
     * Save the structure of the table in a static array, so that it is available at all times.
     *
     * @param string $table
     * @param array  $structure
     */
    protected function setTableStructure(string $table, array $structure): void
    {
        if (!isset(Config::$bbddStructure[$table])) {
            Config::$bbddStructure[$table] = Schema::setNormalizedStructure($structure, $table);
        }
    }

    /**
     * A raw array is built with all the information available in the table, configuration files and code.
     *
     * @return array
     */
    protected function getStructureArray(): array
    {
        //$struct = Schema::getStructureFromFile($this->tableName);
        $struct = Schema::getFromYamlFile($this->tableName);
        if (count($struct) > 0) {
            return $struct;
        }
        $struct['fields'] = method_exists($this, 'getFields') ? /** @scrutinizer ignore-call */
            $this->getFields() : ($this->getFieldsFromTable());
        return $struct;
    }

    /**
     * Return a list of fields and their table structure. Each final model that needed, must overwrite it.
     *
     * @return array
     */
    public function getFieldsFromTable(): array
    {
        return Config::$sqlHelper->getColumns($this->tableName);
    }

    /**
     * Execute a magic method of the setField or getField style
     *
     * @param string $method
     * @param array  $params
     *
     * @return string
     * @throws Exception
     */
    public function __call(string $method, array $params): string
    {
        $command = substr($method, 0, 3); // set o get
        $field = Utils::camelToSnake(substr($method, 3)); // Lo que hay detrás del set o get
        switch ($command) {
            case 'set':
                return $this->newData[$field] = $params[0] ?? '';
            case 'get':
                return $this->newData[$field] ?? null;
            default:
                Debug::testArray("Review $method in {$this->tableName}. Error collecting the '$command/$field' attribute", $params, true);
                throw new Exception('Program halted!');
        }
    }

    /**
     * It allows access to a field of the record using the attribute.
     * To access the name field, we should use $this->getName(), but thanks to this, we can also use $this->name.
     *
     * @param string $property
     *
     * @return string
     */
    public function __get(string $property): string
    {
        return $this->newData[$property] ?? '';
    }

    /**
     * Allows you to assign value to a field in the record using the attribute.
     * To assign a value to the name field, we should use $this->setName('Pepe'),
     * but thanks to this, we can also use $this->name='Pepe'.
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return mixed
     */
    public function __set(string $property, $value)
    {
        $this->newData[$property] = $value;
        return $this->newData[$property];
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
     * Returns a new instance of the table with the requested record.
     * As a previous step, a getData of the current instance is made, so both will point to the same record.
     * Makes a getData and returns a new instance of the model.
     *
     * @param string $id
     *
     * @return SimpleTable
     */
    public function get(string $id): self
    {
        $this->getData($id);
        return $this;
    }

    /**
     * Deletes the active record.
     *
     * @return bool
     */
    public function delete(): bool
    {
        if (empty($this->id)) {
            return false;
        }
        $sql = 'DELETE FROM ' . Config::$sqlHelper->quoteTableName($this->tableName)
            . ' WHERE ' . Config::$sqlHelper->quoteFieldName($this->idField) . ' = ' . Config::$sqlHelper->quoteLiteral($this->id) . ';';
        $result = Config::$dbEngine->exec([$sql]);
        if ($result) {
            $this->id = null;
            $this->newData = null;
            $this->oldData = null;
        }
        return $result;
    }

    /**
     * This method is private. Use load instead.
     * Establishes a record as an active record.
     * If found, the $id will be in $this->id and the data in $this->newData.
     * If it is not found, $this->id will contain '' and $this->newData will contain the data by default.
     *
     * @param string $id
     *
     * @return bool
     */
    private function getData(string $id): bool
    {
        $sql = 'SELECT * FROM ' . Config::$sqlHelper->quoteTableName($this->tableName)
            . ' WHERE ' . Config::$sqlHelper->quoteFieldName($this->idField) . ' = ' . Config::$sqlHelper->quoteLiteral($id) . ';';
        $data = Config::$dbEngine->select($sql);
        if (!isset($data) || count($data) == 0) {
            $this->newRecord();
            return false;
        }
        $this->newData = $data[0];
        $this->oldData = $this->newData;
        $this->id = $this->newData[$this->idField];
        return true;
    }

    /**
     * Returns a new instance of the table with the requested record.
     * As a previous step, a getDataBy of the current instance is made, so both will point to the same record.
     * Makes a getDataBy and returns a new instance of the model.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return SimpleTable|null
     */
    public function getBy(string $key, $value)
    {
        return ($this->getDataBy($key, $value) ? $this : null);
    }

    /**
     * This method is private. Use getBy instead.
     * Establishes a record as an active record.
     * If found the pair $key-$value the data will be in $this->newData.
     * If it is not found, $this->id will contain '' and $this->newData will contain the data by default.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    private function getDataBy(string $key, $value): bool
    {
        $sql = 'SELECT * FROM ' . Config::$sqlHelper->quoteTableName($this->tableName)
            . ' WHERE ' . Config::$sqlHelper->quoteFieldName($key) . ' = ' . Config::$sqlHelper->quoteLiteral($value) . ';';
        $data = Config::$dbEngine->select($sql);
        if (!isset($data) || count($data) == 0) {
            $this->newRecord();
            return false;
        }
        $this->newData = $data[0];
        $this->oldData = $this->newData;
        $this->id = $this->newData[$this->idField];
        return true;
    }

    /**
     * Get the name of the table (with prefix)
     *
     * @return string
     */
    public function getTableName(): string
    {
        Debug::addMessage('Deprecated', 'Do not use getTableName(), use Config::$sqlHelper->quoteTableName($this->tableName); instead');
        return Config::$sqlHelper->quoteTableName($this->tableName);
    }

    /**
     * Sets the active record in a new record.
     * Note that changes made to the current active record will be lost.
     */
    private function newRecord(): void
    {
        $this->id = '';
        $this->newData = [];
        foreach (Config::$bbddStructure[$this->tableName]['fields'] as $key => $value) {
            $this->newData[$key] = $value['default'] ?? '';
        }
        $this->oldData = $this->newData;
    }

    /**
     * Return an array with the current active record.
     * If an $id is indicated, it searches to change the active record before returning the value.
     * Warning: If an $id is set, any unsaved data will be lost when searching for the new record.
     *
     * @param string $id
     *
     * @return array
     */
    public function getDataArray(string $id = null): array
    {
        if (isset($id) && ($id != $this->id)) {
            $this->getData($id);
        }
        return $this->newData;
    }

    /**
     * Establishes a record as an active record.
     * If found, the $id will be in $this->id and the data in $this->newData.
     * If it is not found, $this->id will contain '' and $this->newData will contain the data by default.
     *
     * @param string $id
     *
     * @return bool
     */
    public function load(string $id): bool
    {
        return $this->getData($id);
    }

    /**
     * Saves the changes made to the active record.
     *
     * @return bool
     */
    public function save(): bool
    {
        // We create separate arrays with the modified fields
        $fields = $values = $assigns = [];
        foreach ($this->newData as $field => $data) {
            // The first condition is to prevent nulls from becoming empty strings
            if ((!isset($this->oldData[$field]) && isset($this->newData['field'])) || $this->newData[$field] != $this->oldData[$field]) {
                $fields[] = $field;
                $values[] = "'$data'";
                $assigns[] = "$field = '$data'";
            }
        }

        // If there are no modifications, we leave without error.
        if (count($fields) == 0) {
            return true;
        }
        // Insert or update the data as appropriate (insert if $this->id == '')
        $ret = ($this->id == '') ? $this->insertRecord($fields, $values) : $this->updateRecord($assigns);
        if ($ret) {
            $this->id = $this->newData[$this->idField] ?? null;
            $this->oldData = $this->newData;
        }
        return $ret;
    }

    /**
     * Insert a new record.
     * $fields is an array of fields and $values an array with the values for each field in the same order.
     *
     * @param array $fields
     * @param array $values
     *
     * @return bool
     */
    private function insertRecord($fields, $values): bool
    {
        $fieldList = implode(', ', $fields);
        $valueList = implode(', ', $values);
        $sql = 'INSERT INTO ' . Config::$sqlHelper->quoteTableName($this->tableName) . " ($fieldList) VALUES ($valueList);";
        $ret = Config::$dbEngine->exec([$sql]);
        // Assign the value of the primary key of the newly inserted record
        $this->id = Config::$dbEngine->getLastInserted();
        return $ret;
    }

    /**
     * Update the modified fields in the active record.
     * $data is an array of assignments of type field=value.
     *
     * @param array $data
     *
     * @return bool
     */
    private function updateRecord(array $data): bool
    {
        $value = implode(', ', $data);
        $sql = 'UPDATE ' . Config::$sqlHelper->quoteTableName($this->tableName) . " SET $value"
            . ' WHERE ' . Config::$sqlHelper->quoteFieldName($this->idField) . ' = ' . Config::$sqlHelper->quoteLiteral($this->id) . ';';
        return Config::$dbEngine->exec([$sql]);
    }

    /**
     * Returns the structure of the normalized table
     *
     * @return array
     */
    public function getStructure(): array
    {
        return Config::$bbddStructure[$this->tableName];
    }

    /**
     * Get an array with all data
     *
     * @return array
     */
    public function getAllRecords(): array
    {
        $sql = 'SELECT * FROM ' . Config::$sqlHelper->quoteTableName($this->tableName) . ';';
        return Config::$dbEngine->select($sql);
    }

    /**
     * Return oldData details.
     *
     * @return array
     */
    public function getOldData(): array
    {
        return $this->oldData;
    }

    /**
     * Return newData details.
     *
     * @return array
     */
    public function getNewData(): array
    {
        return $this->newData;
    }
}
