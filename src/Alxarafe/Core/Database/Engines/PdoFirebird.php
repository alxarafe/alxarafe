<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Engines;

use Alxarafe\Core\Database\Engine;
use PDO;

/**
 * Personalization of PDO to use Firebird.
 */
class PdoFirebird extends Engine
{
    /**
     * PdoMySql constructor. Add aditional parameters to self::$dsn string.
     *
     * @param array $dbConfig
     */
    public function __construct(array $dbConfig)
    {
        parent::__construct($dbConfig);
        self::$dsn = 'firebird:dbname=' . self::$dbConfig['dbName'] . ';host=' . self::$dbConfig['dbHost'] . ';charset=UTF8';
    }

    /**
     * Executes a SELECT SQL statement on the database, returning the result in an array.
     * In case of failure, return NULL. If there is no data, return an empty array.
     *
     * @param string $query
     * @param array  $vars
     *
     * @return array
     */
    public static function select(string $query, array $vars = []): array
    {
        self::$statement = self::$dbHandler->prepare($query);
        $result = [];
        if (self::$statement !== false && self::$statement->execute($vars)) {
            // Se podría retornar directamente $_result si no fuese porque FIREBIRD retorna mayúsculas
            $_result = self::$statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($_result as $idx => $records) {
                foreach ($records as $key => $value) {
                    $result[$idx][strtolower($key)] = $value;
                }
            }
        }
        return $result;
    }
}
