<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database;

use Alxarafe\Core\Base\CacheCore;
use Alxarafe\Core\Helpers\Utils\ClassUtils;
use Alxarafe\Core\Helpers\Utils\FileSystemUtils;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\DebugTool;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Logger;
use DebugBar\DataCollector\PDO as PDODataCollector;
use DebugBar\DebugBarException;
use PDO;
use PDOException;
use Psr\Cache\InvalidArgumentException;

/**
 * Engine provides generic support for databases.
 * The class will have to be extended by completing the particularities of each of them.
 */
abstract class Engine
{
    /**
     * The debug tool used.
     *
     * @var DebugTool
     */
    public static $debugTool;

    /**
     * Contains the database structure data.
     * Each table is a index of the associative array.
     *
     * @var array
     */
    public static $dbStructure = [];

    /**
     * Data Source Name
     *
     * @var string
     */
    protected static $dsn;

    /**
     * Array that contains the access data to the database.
     *
     * @var array
     */
    protected static $dbConfig;

    /**
     * The handler of the database.
     *
     * @var PDO
     */
    protected static $dbHandler;

    /**
     * Represents a prepared statement and, after the statement is executed,
     * an associated result set.
     *
     * @var \PDOStatement|bool
     */
    protected static $statement;

    /**
     * True if the database engine supports SAVEPOINT in transactions
     *
     * @var bool
     */
    protected static $savePointsSupport = true;

    /**
     * Number of transactions in execution
     *
     * @var int
     */
    protected static $transactionDepth = 0;

    /**
     * PDO Data collector.
     *
     * @var PDODataCollector\PDOCollector
     */
    protected static $pdoCollector;

    /**
     * Connection between PHP and a database server.
     *
     * @var PDO
     */
    protected static $pdo;

    /**
     * Engine constructor
     *
     * @param array $dbConfig
     */
    public function __construct(array $dbConfig)
    {
        $shortName = ClassUtils::getShortName($this, static::class);

        if (!isset(self::$dbConfig)) {
            self::$dbConfig = $dbConfig;
            self::$debugTool = DebugTool::getInstance();
            self::$debugTool->startTimer($shortName, $shortName . ' Engine Constructor');
            self::$debugTool->stopTimer($shortName);
        }
    }

    /**
     * Return a list of available database engines.
     *
     * @return array
     */
    public static function getEngines(): array
    {
        $path = constant('ALXARAFE_FOLDER') . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'Engines';
        $engines = FileSystemUtils::scandir($path);
        $ret = [];
        // Unset engines not fully supported
        $unsupported = self::unsupportedEngines();
        foreach ($engines as $engine) {
            if ($engine->getExtension() === 'php') {
                $engineName = substr($engine->getFilename(), 0, strlen($engine->getFilename()) - strlen($engine->getExtension()) - 1);
                if (in_array($engineName, $unsupported, true)) {
                    continue;
                }
                $ret[] = $engineName;
            }
        }
        return $ret;
    }

    /**
     * Returns a list of unsupported engines.
     * The unsupported engines here are the not fully supported yet.
     *
     * @return array
     */
    public static function unsupportedEngines(): array
    {
        //return [];
        return ['PdoFirebird'];
    }

    /**
     * Obtain an array with the table structure with a standardized format.
     *
     * @param string $tableName
     * @param bool   $usePrefix
     *
     * @return array
     */
    public static function getStructure(string $tableName, bool $usePrefix = true): array
    {
        return [
            'fields' => Database::getInstance()->getSqlHelper()->getColumns($tableName, $usePrefix),
            'indexes' => Database::getInstance()->getSqlHelper()->getIndexes($tableName, $usePrefix),
        ];
    }

    /**
     * Execute SQL statements on the database (INSERT, UPDATE or DELETE).
     *
     * @param array $queries
     *
     * @return bool
     */
    final public static function batchExec(array $queries): bool
    {
        $ok = true;
        foreach ($queries as $query) {
            $query = trim($query);
            if ($query !== '') {
                // TODO: The same variables are passed for all queries.
                $ok &= self::exec($query);
            }
        }
        return (bool) $ok;
    }

    /**
     * Prepare and execute the query.
     *
     * @param string $query
     * @param array  $vars
     *
     * @return bool
     */
    final public static function exec(string $query, $vars = []): bool
    {
        // Remove extra blankspace to be more readable
        $query = preg_replace('/\s+/', ' ', $query);
        $ok = false;
        self::$statement = self::$dbHandler->prepare($query);
        if (self::$statement) {
            $ok = self::$statement->execute($vars);
        }
        if (!$ok) {
            self::$debugTool->addMessage('SQL', 'PDO ERROR in exec: ' . $query);
        }
        return $ok;
    }

    /**
     * Executes a SELECT SQL statement on the core cache.
     *
     * @param string $cachedName
     * @param string $query
     * @param array  $vars
     *
     * @return array
     */
    final public static function selectCoreCache(string $cachedName, string $query, array $vars = []): array
    {
        if (constant('CORE_CACHE_ENABLED') === true) {
            $cacheEngine = CacheCore::getInstance()->getEngine();
            try {
                $cacheItem = $cacheEngine->getItem($cachedName);
            } catch (InvalidArgumentException $e) {
                $cacheItem = null;
                Logger::getInstance()::exceptionHandler($e);
            }
            if ($cacheItem && !$cacheItem->isHit()) {
                $cacheItem->set(self::select($query, $vars));
                if ($cacheEngine->save($cacheItem)) {
                    self::$debugTool->addMessage('messages', "Cache data saved to '" . $cachedName . "'.");
                } else {
                    self::$debugTool->addMessage('messages', 'Cache data not saved.');
                }
            }
            if ($cacheItem && $cacheEngine->hasItem($cachedName)) {
                return $cacheItem->get();
            }
            return [];
        }
        return self::select($query, $vars);
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
        // Remove extra blankspace to be more readable
        $query = preg_replace('/\s+/', ' ', $query);
        self::$statement = self::$dbHandler->prepare($query);
        if (self::$statement && self::$statement->execute($vars)) {
            return self::$statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    /**
     * Clear item from cache.
     *
     * @param string $cachedName
     *
     * @return bool
     */
    final public static function clearCoreCache(string $cachedName): bool
    {
        $cacheEngine = CacheCore::getInstance()->getEngine();
        if (isset($cacheEngine)) {
            try {
                return $cacheEngine->deleteItem($cachedName);
            } catch (InvalidArgumentException $e) {
                Logger::getInstance()::exceptionHandler($e);
            }
        }
        return false;
    }

    /**
     * Engine destructor
     */
    public function __destruct()
    {
        $this->rollBackTransactions();
    }

    /**
     * Undo all active transactions
     */
    private function rollBackTransactions(): void
    {
        while (self::$transactionDepth > 0) {
            $this->rollBack();
        }
    }

    /**
     * Rollback current transaction,
     *
     * @return bool
     */
    final public function rollBack(): bool
    {
        $ret = true;

        if (self::$transactionDepth === 0) {
            throw new PDOException('Rollback error : There is no transaction started');
        }

        self::$debugTool->addMessage('SQL', 'Rollback, savepoint LEVEL' . self::$transactionDepth);
        self::$transactionDepth--;

        if (self::$transactionDepth === 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->rollBack();
        } else {
            $transactionDepth = self::$transactionDepth;
            $sql = "ROLLBACK TO SAVEPOINT LEVEL{$transactionDepth};";
            self::exec($sql);
        }

        return $ret;
    }

    /**
     * Returns the id of the last inserted record. Failing that, it returns ''.
     *
     * @return string
     */
    final public function getLastInserted(): string
    {
        $data = self::select('SELECT @@identity AS id');
        if (count($data) > 0) {
            return $data[0]['id'];
        }
        return '';
    }

    /**
     * Returns if a database connection exists or not.
     *
     * @return bool
     */
    public function checkConnection(): bool
    {
        return (self::$dbHandler != null);
    }

    /**
     * Establish a connection to the database.
     * If a connection already exists, it returns it. It does not establish a new one.
     * Returns true in case of success, assigning the handler to self::$dbHandler.
     *
     * @param array $config
     *
     * @return bool
     */
    public function connect(array $config = []): bool
    {
        if (self::$dbHandler != null) {
            self::$debugTool->addMessage('SQL', 'PDO: Already connected ' . self::$dsn);
            return true;
        }
        self::$debugTool->addMessage('SQL', 'PDO: ' . self::$dsn);
        try {
            // Logs SQL queries. You need to wrap your PDO object into a DebugBar\DataCollector\PDO\TraceablePDO object.
            // http://phpdebugbar.com/docs/base-collectors.html
            self::$pdo = new PDO(self::$dsn, self::$dbConfig['dbUser'], self::$dbConfig['dbPass'], $config);
            self::$dbHandler = new PDODataCollector\TraceablePDO(self::$pdo);
            self::$pdoCollector = new PDODataCollector\PDOCollector(self::$dbHandler);
            self::$debugTool->getDebugTool()->addCollector(self::$pdoCollector);
        } catch (PDOException $e) {
            Logger::getInstance()::exceptionHandler($e);
            FlashMessages::getInstance()::setError($e->getMessage());
            return false;
        } catch (DebugBarException $e) {
            Logger::getInstance()::exceptionHandler($e);
            FlashMessages::getInstance()::setError($e->getMessage());
            return false;
        }
        return isset(self::$dbHandler);
    }

    /**
     * Prepares a statement for execution and returns a statement object
     *
     * @doc http://php.net/manual/en/pdo.prepare.php
     *
     * @param string $sql
     * @param array  $options
     *
     * @return bool
     */
    final public function prepare(string $sql, array $options = []): bool
    {
        if (!isset(self::$dbHandler)) {
            return false;
        }
        // Remove extra blankspace to be more readable
        $sql = preg_replace('/\s+/', ' ', $sql);
        self::$statement = self::$dbHandler->prepare($sql, $options);
        return (bool) self::$statement;
    }

    /**
     * Returns an array containing all of the result set rows
     *
     * @return array
     */
    final public function resultSet(): array
    {
        $this->execute();
        return self::$statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Executes a prepared statement
     *
     * @doc http://php.net/manual/en/pdostatement.execute.php
     *
     * @param array $inputParameters
     *
     * @return bool
     */
    final public function execute(array $inputParameters = []): bool
    {
        if (!isset(self::$statement) || !self::$statement) {
            return false;
        }
        return self::$statement->execute($inputParameters);
    }

    /**
     * Start transaction
     *
     * @doc https://www.ibm.com/support/knowledgecenter/es/SSEPGG_9.1.0/com.ibm.db2.udb.apdv.php.doc/doc/t0023166.htm
     * Transactions support
     * @doc https://coderwall.com/p/rml5fa/nested-pdo-transactions
     *
     * @return bool
     */
    final public function beginTransaction(): bool
    {
        $ret = true;
        if (self::$transactionDepth === 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->beginTransaction();
        } else {
            $transactionDepth = self::$transactionDepth;
            $sql = "SAVEPOINT LEVEL{$transactionDepth};";
            self::exec($sql);
        }

        self::$transactionDepth++;
        self::$debugTool->addMessage('SQL', 'Transaction started, savepoint LEVEL' . self::$transactionDepth . ' saved');

        return $ret;
    }

    /**
     * Commit current transaction
     *
     * @return bool
     */
    final public function commit(): bool
    {
        $ret = true;

        self::$debugTool->addMessage('SQL', 'Commit, savepoint LEVEL' . self::$transactionDepth);
        self::$transactionDepth--;

        if (self::$transactionDepth === 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->commit();
        } else {
            $transactionDepth = self::$transactionDepth;
            $sql = "RELEASE SAVEPOINT LEVEL{$transactionDepth};";
            self::exec($sql);
        }

        return $ret;
    }

    /**
     * Returns database structure.
     *
     * @return array
     */
    final public function getDbStructure(): array
    {
        return self::$dbStructure;
    }

    /**
     * Returns database table structure.
     *
     * @param string $tablename
     *
     * @return array
     */
    final public function getDbTableStructure(string $tablename)
    {
        return self::$dbStructure[$tablename] ?? [];
    }

    /**
     * Returns if table is set to database structure.
     *
     * @param string $tablename
     *
     * @return bool
     */
    final public function issetDbTableStructure(string $tablename): bool
    {
        return isset(self::$dbStructure[$tablename]);
    }

    /**
     * Returns if key is set to database structure.
     *
     * @param string $tablename
     * @param string $key
     *
     * @return bool
     */
    final public function issetDbTableStructureKey(string $tablename, string $key): bool
    {
        return isset(self::$dbStructure[$tablename][$key]);
    }

    /**
     * Sets database structure for a tablename.
     *
     * @param string $tablename
     * @param array  $data
     */
    final public function setDbTableStructure(string $tablename, array $data): void
    {
        self::$dbStructure[$tablename] = $data;
    }
}
