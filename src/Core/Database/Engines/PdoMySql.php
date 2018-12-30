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

    private static function splitType($originalType): array
    {
        $explode = explode(' ', strtolower($originalType));

        $extraType = '';

        $pos = array_search('unsigned', $explode);
        if ($pos) {
            unset($explode[$pos]);
            $extraType = 'unsigned';
        }

        $pos = array_search('zerofill', $explode);
        if ($pos) {
            unset($explode[$pos]);
            $extraType .= ' zerofill';
        }

        $pos = strpos($explode[0], '(');

        $type = $pos ? substr($explode[0], 0, $pos) : $explode[0];
        $length = $pos ? intval(substr($explode[0], $pos + 1)) : null;

        return array('type' => $type, 'length' => $length, 'extra' => trim($extraType));
    }

    public static function normalizeColumns(array $columns): array
    {
        $res = [];
        foreach ($columns as $value) {
            $fullType = self::splitType($value['Type']);
            switch ($fullType['type']) {
                // Integers
                case 'int':
                    $type = 'integer';
                    break;
                // String
                case 'varchar':
                    $type = 'string';
                    break;
                default:
                    // Others
                    $type = $fullType['type'];
                    Debug::addMessage('Deprecated', "Correct the data type '$type' in MySql database");
            }
            $data = [];
            $data['name'] = strtolower(trim($value['Field']));
            $data['type'] = $type;
            $data['length'] = $fullType['length'];
            $data['null'] = $value['Null'];
            $data['default'] = $value['Default'];
            $data['key'] = $value['Key'];
            $data['extra'] = $fullType['extra'];
            $res[] = $data;
        }
        return $res;
    }
}
