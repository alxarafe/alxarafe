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

    public static function normalizeColumns(array $columns): array
    {
        $ret = [];
        foreach ($columns as $value) {
            switch (trim($value['type'])) {
                // Integers
                case 'LONG':
                    $type = 'integer';
                    break;
                // String
                case 'VARYING':
                    $type = 'string';
                    break;
                default:
                    // Others
                    $type = trim($value['type']);
                    Debug::addMessage('Deprecated', "Correct the data type '$type' in Firebird database");
            }
            $data['name'] = strtolower(trim($value['field']));
            $data['type'] = $type;
            $data['length'] = $value['length'];
            $data['null'] = $value['nullvalue'];
            $data['default'] = isset($value['defaultsource']) ? substr($value['defaultsource'], 10) : null;
            $data['key'] = '';
            $data['extra'] = '';
            $res[] = $data;
        }
        return $res;
    }
}
