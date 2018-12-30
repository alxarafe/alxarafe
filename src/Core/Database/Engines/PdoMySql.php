<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database\Engines;

use Alxarafe\Database\Engine;
use PDO;

/**
 * Personalization of PDO to use MySQL.
 */
class PdoMySql extends Engine
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
        self::$dsn = "mysql:dbname=" . self::$dbConfig['dbName'] . ";host=" . self::$dbConfig['dbHost'] . ";charset=UTF8";
    }

    /**
     * Connect to the database.
     * 
     * @param array $config
     * @return bool
     */
    public function connect(array $config = []): bool
    {
        $config[PDO::ATTR_EMULATE_PREPARES] = 1;
        $config[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';
        $ret = parent::connect($config);

        return $ret;
    }

    public static function normalizeColumns(array $columns): array
    {
        /*
          array (size=6)
          'Field' => string 'id' (length=2)
          'Type' => string 'int(10) unsigned' (length=16)
          'Null' => string 'NO' (length=2)
          'Key' => string 'PRI' (length=3)
          'Default' => null
          'Extra' => string 'auto_increment' (length=14)
         */

        $ret = [];
        foreach ($columns as $value) {
            switch ($value['type']) {
                // Integers
                case 'LONG':
                    $type = 'INTEGER';
                    break;
                // String
                case 'VARIYING':
                    $type = 'STRING';
                    break;
                    // Others
                    $type = $value;
                    Debug::addMessage('Deprecated', 'Correct the data type X in Firebird database');
            }
            $data['name'] = strtolower(trim($value['field']));
            $data['type'] = $type;
            $data['length'] = $value['length'];
            $data['null'] = $value['nullvalue'];
            $data['default'] = isset($value['defaultsource']) ? substr($value['defaultsource'], 10) : null;
            $res[] = $data;
        }
        return $res;
    }
}
