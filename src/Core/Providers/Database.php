<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Alxarafe\Database\Engine;
use Alxarafe\Database\SqlHelper;
use Exception;

/**
 * Class Database
 *
 * @package Alxarafe\Providers
 */
class Database
{
    use Singleton;

    /**
     * Contains the instance to the database engine (or null)
     *
     * @var Engine
     */
    protected $dbEngine;

    /**
     * Contains the instance to the specific SQL engine helper (or null)
     *
     * @var sqlHelper
     */
    protected $sqlHelper;

    /**
     * @var array
     */
    protected $config;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        if ($this->dbEngine === null) {
            $this->initSingleton();
            $this->config = $this->getConfig();
            $dbEngineName = $this->config['dbEngineName'] ?? 'PdoMySql';
            $helperName = 'Sql' . substr($dbEngineName, 3);

            $sqlEngine = '\\Alxarafe\\Database\\SqlHelpers\\' . $helperName;
            $engine = '\\Alxarafe\\Database\\Engines\\' . $dbEngineName;
            try {
                $this->sqlHelper = new $sqlEngine();
                $this->dbEngine = new $engine([
                    'dbUser' => $this->config['dbUser'] ?? '',
                    'dbPass' => $this->config['dbPass'] ?? '',
                    'dbName' => $this->config['dbName'] ?? '',
                    'dbHost' => $this->config['dbHost'] ?? '',
                    'dbPort' => $this->config['dbPort'] ?? '',
                ]);
            } catch (Exception $e) {
                Logger::getInstance()->exceptionHandler($e);
                return false;
            }
        }
    }

    /**
     * If Config::$dbEngine contain null, create an Engine instance with the database connection and assigns it to
     * Config::$dbEngine.
     *
     * @return bool
     */
    public function connectToDatabase(): bool
    {
        return isset($this->dbEngine) && $this->dbEngine->connect() && $this->dbEngine->checkConnection();
    }

    /**
     * @return Engine
     */
    public function getDbEngine(): Engine
    {
        return $this->dbEngine;
    }

    /**
     * @return SqlHelper
     */
    public function getSqlHelper(): SqlHelper
    {
        return $this->sqlHelper;
    }
}
