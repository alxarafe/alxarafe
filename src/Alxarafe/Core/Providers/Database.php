<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Database\Engine;
use Alxarafe\Core\Database\SqlHelper;
use Alxarafe\Core\Helpers\Utils\ClassUtils;
use Exception;

/**
 * Class Database
 *
 * @package Alxarafe\Core\Providers
 */
class Database
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

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
     * Array of config data
     *
     * @var array
     */
    protected $config;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        if (!isset($this->dbEngine)) {
            $shortName = ClassUtils::getShortName($this, static::class);
            $debugTool = DebugTool::getInstance();
            $debugTool->startTimer($shortName, $shortName . ' Database Constructor');
            $this->initSingleton();
            $this->config = $this->getConfig();
            if (empty($this->config)) {
                Logger::getInstance()->getLogger()->addDebug('There is no config for database.');
                return;
            }
            $dbEngineName = $this->config['dbEngineName'] ?? 'PdoMySql';
            $helperName = 'Sql' . substr($dbEngineName, 3);

            $sqlEngine = '\\Alxarafe\Core\\Database\\SqlHelpers\\' . $helperName;
            $engine = '\\Alxarafe\Core\\Database\\Engines\\' . $dbEngineName;
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
                Logger::getInstance()::exceptionHandler($e);
                return;
            }
            $debugTool->stopTimer($shortName);
        }
    }

    /**
     * Return this instance.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Return default values
     *
     * @return array
     */
    public static function getDefaultValues(): array
    {
        return [
            'dbEngineName' => 'PdoMySql',
            'dbPrefix' => '',
            'dbUser' => 'dbUser',
            'dbPass' => 'dbPass',
            'dbName' => 'dbName',
            'dbHost' => 'localhost',
            'dbPort' => '',
        ];
    }

    /**
     * If Database::getInstance()->getDbEngine() contain null, create an Engine instance with the database connection
     * and assigns it to Database::getInstance()->getDbEngine().
     *
     * @return bool
     */
    public function connectToDatabase(): bool
    {
        return isset($this->dbEngine) && $this->dbEngine->connect() && $this->dbEngine->checkConnection();
    }

    /**
     * Returns the database engine.
     *
     * @return Engine
     */
    public function getDbEngine(): Engine
    {
        if (!isset($this->dbEngine)) {
            return (new self())->dbEngine;
        }
        return $this->dbEngine;
    }

    /**
     * Return the sql helper for the engine in use.
     *
     * @return SqlHelper
     */
    public function getSqlHelper(): SqlHelper
    {
        if (!isset($this->dbEngine)) {
            return (new self())->sqlHelper;
        }
        return $this->sqlHelper;
    }

    /**
     * Returns the connections data details.
     *
     * @return array
     */
    public function getConnectionData(): array
    {
        return $this->config;
    }
}
