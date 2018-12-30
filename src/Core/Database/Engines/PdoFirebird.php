<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database\Engines;

use Alxarafe\Database\Engine;
use Alxarafe\Helpers\Debug;
use PDO;

/**
 * Personalization of PDO to use Firebird.
 */
class PdoFirebird extends Engine
{

    /**
     * PdoMySql constructor.
     * Add aditional parameters to self::$dsn string.
     *
     * @param array $dbConfig
     */
    public function __construct(array $dbConfig)
    {
        parent::__construct($dbConfig);
        self::$dsn = "firebird:dbname=" . self::$dbConfig['dbName'] . ";host=" . self::$dbConfig['dbHost'] . ";charset=UTF8";
    }

    /**
     * Executes a SELECT SQL statement on the database, returning the result in an array.
     * In case of failure, return NULL. If there is no data, return an empty array.
     *
     * @param string $query
     * @return array
     */
    public static function select(string $query): array
    {
        Debug::addMessage('SQL', 'PDO select: ' . $query);
        self::$statement = self::$dbHandler->prepare($query);
        if (self::$statement != null && self::$statement->execute([])) {
            // Se podría retornar directamente $_result si no fuese porque FIREBIRD retorna mayúsculas
            $_result = self::$statement->fetchAll(PDO::FETCH_ASSOC);
            $result = [];
            foreach ($_result as $idx => $records) {
                foreach ($records as $key => $value) {
                    $result[$idx][strtolower($key)] = $value;
                }
            }
            return $result;
        }
        return null;
    }
}
