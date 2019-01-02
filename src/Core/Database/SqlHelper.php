<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database;

use Alxarafe\Helpers\Config;

/**
 * Engine provides generic support for databases.
 * The class will have to be extended by completing the particularities of each of them.
 */
abstract class SqlHelper
{

    /**
     * TODO: Undocumented
     *
     * @var string
     */
    protected $tableQuote;
    /**
     * TODO: Undocumented
     *
     * @var string
     */
    protected $fieldQuote;

    /**
     * SqlHelper constructor.
     */
    public function __construct()
    {
        $this->tableQuote = '';
        $this->fieldQuote = '';
    }

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    public function quoteTableName(string $tableName): string
    {
        return $this->tableQuote . $tableName . $this->tableQuote;
    }

    /**
     * TODO: Undocumented
     *
     * @param string $fieldName
     *
     * @return string
     */
    public function quoteFieldname(string $fieldName): string
    {
        return Config::$sqlHelper->fieldQuote . $fieldName . Config::$sqlHelper->fieldQuote;
    }

    /**
     * @return string
     */
    abstract public function getTables(): string;

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getColumns(string $tableName): string;

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getIndexes(string $tableName): string;

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getConstraints(string $tableName): string;
}
