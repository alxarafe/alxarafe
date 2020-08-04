<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Helpers\Schema;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\Translator;

/**
 * Class SimpleTable has all the basic methods to access and manipulate information, but without modifying its
 * structure.
 */
class FlatTable extends Entity
{
    /**
     * It is the name of the table.
     *
     * @var string
     */
    public $tableName;

    /**
     * It's the name of the model associated with the table
     *
     * @var string
     */
    public $modelName;

    /**
     * Contains errors during the process
     *
     * @var array
     */
    public $errors;

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
        parent::__construct();
        $this->modelName = $this->shortName;
        $this->debugTool->startTimer($this->modelName . '.flat', $this->modelName . ' FlatTable Constructor');
        $this->tableName = $tableName;
        $this->idField = $params['idField'] ?? 'id';
        $this->nameField = $params['nameField'] ?? 'name';
        $this->debugTool->stopTimer($this->modelName . '.flat');
        $this->errors = [];
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
        if (!$this->getDataById($id)) {
            $this->newRecord($id);
        }
        $this->id = $id;
        return $this;
    }

    /**
     * This method is private. Use load instead.
     * Establishes a record as an active record.
     * If found, return true and the $id will be in $this->id and the data in $this->newData.
     * If it is not found, return false, and have not effect into the instance.
     *
     * @param string $id
     *
     * @return bool
     */
    private function getDataById(string $id): bool
    {
        $sql = "SELECT * FROM {$this->getQuotedTableName()} WHERE {$this->idField} = :id;";
        $data = Database::getInstance()->getDbEngine()->select($sql, ['id' => $id]);
        if (!isset($data) || count($data) === 0) {
            $this->exists = false;
            return false;
        }
        $this->exists = true;
        $this->newData = $data[0];
        $this->oldData = $this->newData;
        $this->id = $this->newData[$this->idField];
        return true;
    }

    /**
     * Get the name of the table (with prefix)
     *
     * @param bool $usePrefix
     *
     * @return string
     */
    public function getQuotedTableName(bool $usePrefix = true): string
    {
        return Database::getInstance()->getSqlHelper()->quoteTableName($this->tableName, $usePrefix);
    }

    /**
     * Sets the active record in a new record.
     * Note that changes made to the current active record will be lost.
     *
     * @param string|null $id
     */
    public function newRecord(?string $id = null): void
    {
        if (isset($id) && $this->getDataById($id)) {
            return;
        }
        $this->exists = false;
        $this->newData = $this->defaultData();
        $this->oldData = $this->newData;
        $this->id = $id;
    }

    /**
     * Returns the default values of each field
     *
     * @return array
     */
    public function defaultData()
    {
        $data = [];
        foreach (Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName)['fields'] as $key => $value) {
            $data[$key] = $value['default'] ?? '';
        }
        return $data;
    }

    /**
     * Get the name of the table (with prefix)
     *
     * @param bool $usePrefix
     *
     * @return string
     */
    public function getTableName(bool $usePrefix = true): string
    {
        return ($usePrefix ? Database::getInstance()->getConnectionData()['dbPrefix'] : '') . $this->tableName;
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
        if (isset($id) && ($id !== $this->id)) {
            $this->getDataById($id);
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
        return $this->getDataById($id);
    }

    /**
     * Checks the integrity of the supplied values to generate possible warning errors.
     * It can also return some corrected values (for example true/false by 1/0)
     *
     * @param $values
     */
    public function test(&$values): void
    {
        $trans = Translator::getInstance();
        $schema = Schema::getFromYamlFile($this->tableName, 'viewdata');
        foreach ($values as $key => $value) {
            $field = $schema['fields'][$key];
            $params = ['%field%' => $trans->trans($key), '%value%' => $value];
            switch ($field['type']) {
                case 'checkbox':
                case 'radio':
                case 'color':
                case 'range':
                case 'file':
                case 'toggle':
                case 'touchspin':
                case 'password':
                case 'textarea':
                case 'select':
                case 'select2':
                    break;
                case 'bool':
                    if (in_array(strtolower($value), ['true', 'yes', '1'])) {
                        $values[$key] = '1';
                    } elseif (in_array(strtolower($value), ['false', 'no', '0'])) {
                        $values[$key] = '0';
                    } else {
                        $this->errors[] = $trans->trans('error-boolean-expected', $params);
                    }
                    break;
                /** @noinspection PhpMissingBreakStatementInspection */ case 'float':
                $float = (float) $value;
                if ($field['type'] === 'float' && $float !== $value) {
                    $this->errors[] = $trans->trans('error-float-expected', $params);
                }
                case 'integer':
                    if (!isset($float)) {
                        $integer = (int) $value;
                        if ($field['type'] === 'integer' && $integer !== $value) {
                            $this->errors[] = $trans->trans('error-integer-expected', $params);
                        }
                    }
                    $unsigned = isset($field['unsigned']) && $field['unsigned'] === 'yes';
                    $min = $field['min'] ?? null;
                    $max = $field['max'] ?? null;
                    if ($unsigned && $value < 0) {
                        $this->errors[] = $trans->trans('error-negative-unsigned', $params);
                    }
                    if (isset($min) && $value < $min) {
                        $params['%min%'] = $min;
                        $this->errors[] = $trans->trans('error-less-than-minimum', $params);
                    }
                    if (isset($max) && $value > $max) {
                        $params['%max%'] = $max;
                        $this->errors[] = $trans->trans('error-greater-than-maximum', $params);
                    }
                    break;
                case 'string':
                    $maxlen = $field['maxlength'] ?? null;
                    $strlen = strlen($value);
                    if (isset($maxlen) && $strlen > $maxlen) {
                        $params['%strlen%'] = $strlen;
                        $params['%maxlen%'] = $maxlen;
                        $this->errors[] = $trans->trans('error-string-too-long', $params);
                    }
                    break;
                default:
                    $params['%type%'] = $field['type'];
                    $this->errors[] = $trans->trans('error-type-not-supported', $params);
            }
        }
    }

    /**
     * Saves the changes made to the active record.
     *
     * @return bool
     */
    public function save(): bool
    {
        $values = [];
        // We create separate arrays with the modified fields
        foreach ($this->newData as $field => $data) {
            // The first condition is to prevent nulls from becoming empty strings
            if ((!isset($this->oldData[$field]) && isset($this->newData[$field])) || $this->newData[$field] !== $this->oldData[$field]) {
                $values[$field] = $data;
            }
        }

        // If there are no modifications, we leave without error.
        if (count($values) === 0) {
            return true;
        }

        $this->test($values);
        if (count($this->errors)) {
            return false;
        }

        // Insert or update the data as appropriate (insert if $this->id == '')
        $ret = ($this->exists) ? $this->updateRecord($values) : $this->insertRecord($values);
        if ($ret) {
            // $this->id = $this->newData[$this->idField] ?? null;
            $this->oldData = $this->newData;
        }
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
        $fieldNames = [];
        $vars = [];
        foreach ($data as $fieldName => $value) {
            $fieldNames[] = Database::getInstance()->getSqlHelper()->quoteFieldName($fieldName) . " = :" . $fieldName;
            $vars[$fieldName] = $value;
        }

        $fieldList = implode(', ', $fieldNames);

        $idField = Database::getInstance()->getSqlHelper()->quoteFieldName($this->idField);
        $sql = "UPDATE {$this->getQuotedTableName()} SET {$fieldList} WHERE {$idField} = :id;";
        $vars['id'] = $this->id;

        return Database::getInstance()->getDbEngine()->exec($sql, $vars);
    }

    /**
     * Insert a new record.
     * $fields is an array of fields and $values an array with the values for each field in the same order.
     *
     * @param array $values
     *
     * @return bool
     */
    private function insertRecord($values): bool
    {
        $fieldNames = [];
        $fieldVars = [];
        $vars = [];

        if (!isset($values[$this->idField]) || empty($values[$this->idField])) {
            unset($values[$this->idField]);
        }

        foreach ($values as $fieldName => $value) {
            $fieldNames[$fieldName] = Database::getInstance()->getSqlHelper()->quoteFieldName($fieldName);
            $fieldVars[$fieldName] = ':' . $fieldName;
            $vars[$fieldName] = $value;
        }

        if (isset($this->id) && !empty($this->id)) {
            $fieldNames[] = $this->getIdField();
            $fieldVars[] = ':id';
            $vars['id'] = $this->id;
        }

        $fieldList = implode(', ', $fieldNames);
        $valueList = implode(', ', $fieldVars);

        $sql = "INSERT INTO {$this->getQuotedTableName()} ($fieldList) VALUES ($valueList);";

        $result = Database::getInstance()->getDbEngine()->exec($sql, $vars);

        if ($result) {
            $this->exists = true;
            // Assign the value of the primary key of the newly inserted record
            if (!isset($this->id)) {
                $this->id = Database::getInstance()->getDbEngine()->getLastInserted();
                $this->newData[$this->idField] = $this->id;
            }
        }

        return $result;
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
        $idField = Database::getInstance()->getSqlHelper()->quoteFieldName($this->idField);
        $sql = "DELETE FROM {$this->getQuotedTableName()} WHERE {$idField} = :id;";
        $vars = [];
        $vars['id'] = $this->id;
        $result = Database::getInstance()->getDbEngine()->exec($sql, $vars);
        if ($result) {
            $this->id = null;
            $this->newData = null;
            $this->oldData = null;
        }
        return $result;
    }
}
