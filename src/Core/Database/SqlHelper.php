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

    protected $tableQuote;
    protected $fieldQuote;

    public function __construct()
    {
        $this->tableQuote = '';
        $this->fieldQuote = '';
    }

    public function quoteTablename(string $tablename): string
    {
        return $this->tableQuote . $tablename . $this->tableQuote;
    }

    public function quoteFieldname(string $fieldname): string
    {
        return Config::$sqlHelper->fieldQuote . $fieldname . Config::$sqlHelper->fieldQuote;
    }

    abstract public function getTables(): string;

    abstract public function getColumns(string $tablename): string;

    abstract public function getIndexes(string $tablename): string;

    abstract public function getConstraints(string $tablename): string;
}
