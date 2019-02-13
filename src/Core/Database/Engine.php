<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database;

use Alxarafe\Base\CacheCore;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use DebugBar\DataCollector\PDO as PDODataCollector;
use DebugBar\DebugBarException;
use PDO;
use PDOException;

/**
 * Engine provides generic support for databases.
 * The class will have to be extended by completing the particularities of each of them.
 */
abstract class Engine
{

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
     * Engine constructor
     *
     * @param array $dbConfig
     */
    public function __construct(array $dbConfig)
    {
        self::$dbConfig = $dbConfig;
    }

    /**
     * Return a list of available database engines.
     *
     * @return array
     */
    public static function getEngines(): array
    {
        $path = constant('ALXARAFE_FOLDER') . '/Database/Engines';
        $engines = scandir($path);
        $ret = [];
        // Unset engines not fully supported
        $unsupported = self::unsupportedEngines();
        foreach ($engines as $engine) {
            if ($engine != '.' && $engine != '..' && substr($engine, -4) == '.php') {
                $engine = substr($engine, 0, strlen($engine) - 4);
                if (in_array($engine, $unsupported)) {
                    continue;
                }
                $ret[] = $engine;
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
    public static function unsupportedEngines()
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
            'fields' => Config::$sqlHelper->getColumns($tableName, $usePrefix),
            'indexes' => Config::$sqlHelper->getIndexes($tableName, $usePrefix),
        ];
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
    final private function rollBackTransactions(): void
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

        if (self::$transactionDepth == 0) {
            throw new PDOException('Rollback error : There is no transaction started');
        }

        Debug::addMessage('SQL', 'Rollback, savepoint LEVEL' . self::$transactionDepth);
        self::$transactionDepth--;

        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->rollBack();
        } else {
            $sql = 'ROLLBACK TO SAVEPOINT LEVEL' . self::$transactionDepth . ';';
            $this->exec([$sql]);
        }

        return $ret;
    }

    /**
     * TODO: Undocumented
     *
     * @param string $query
     *
     * @return bool
     */
    final public static function exec(string $query, $vars = []): bool
    {
        // Remove extra blankspace to be more readable
        $query = preg_replace('/\s+/', ' ', $query);
        // TODO: Debugbar is collecting from PDO, is really needed here??
        // Debug::addMessage('SQL', 'PDO exec: ' . $query);
        $ok = false;
        self::$statement = self::$dbHandler->prepare($query);
        if (self::$statement) {
            $ok = self::$statement->execute($vars);
        }
        if (!$ok) {
            Debug::addMessage('SQL', 'PDO ERROR in exec: ' . $query);
        }
        return $ok;
    }

    /**
     * Execute SQL statements on the database (INSERT, UPDATE or DELETE).
     *
     * @param string $queries
     *
     * @return bool
     */
    final public static function batchExec(array $queries): bool
    {
        $ok = true;
        foreach ($queries as $query) {
            $query = trim($query);
            if ($query != '') {
                // TODO: The same variables are passed for all queries.
                $ok &= self::exec($query);
            }
        }
        return (bool) $ok;
    }

    /**
     * Returns the id of the last inserted record. Failing that, it
     * returns ''.
     *
     * @return string
     */
    final public function getLastInserted(): string
    {
        $data = $this->select('SELECT @@identity AS id');
        if (count($data) > 0) {
            return $data[0]['id'];
        }
        return '';
    }

    /**
     * Executes a SELECT SQL statement on the database, returning the result in an array.
     * In case of failure, return NULL. If there is no data, return an empty array.
     *
     * @param string $query
     * @param array $vars
     *
     * @return array
     */
    public static function select(string $query, $vars = []): array
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
     * Executes a SELECT SQL statement on the core cache.
     *
     * @param string $query
     * @param string $cachedName
     * @param array $vars
     *
     * @return array
     */
    final public static function selectCoreCache(string $cachedName, string $query, array $vars = []): array
    {
        if (constant('CORE_CACHE_ENABLED') === true) {
            $cacheEngine = Config::getCacheCoreEngine();
            $cacheItem = $cacheEngine->getItem($cachedName);
            if (!$cacheItem->isHit()) {
                $cacheItem->set(self::select($query, $vars));
                if ($cacheEngine->save($cacheItem)) {
                    Debug::addMessage('messages', "Cache data saved to '" . $cachedName . "'.");
                } else {
                    Debug::addMessage('messages', 'Cache data not saved.');
                }
            }
            if ($cacheEngine->hasItem($cachedName)) {
                $item = $cacheItem->get();
//                Debug::addMessage('messages', 'Using data from cache for: <pre>' . var_export($query, true) . '</pre>');
//                Debug::addMessage('messages', 'Data: <pre>' . var_export($item, true) . '</pre>');
                return $item;
            }
            return [];
        }
        return self::select($query, $vars);
    }

    /**
     * Clear item from cache.
     *
     * @param string $cachedName
     *
     * @return bool
     * @throws \Psr\Cache\InvalidArgumentException
     */
    final public static function clearCoreCache(string $cachedName): bool
    {
        $cacheEngine = Config::getCacheCoreEngine();
        return $cacheEngine->deleteItem($cachedName);
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
            Debug::addMessage('SQL', "PDO: Already connected " . self::$dsn);
            return true;
        }
        Debug::addMessage('SQL', "PDO: " . self::$dsn);
        try {
            // Logs SQL queries. You need to wrap your PDO object into a DebugBar\DataCollector\PDO\TraceablePDO object.
            // http://phpdebugbar.com/docs/base-collectors.html
            self::$dbHandler = new PDODataCollector\TraceablePDO(new PDO(self::$dsn, self::$dbConfig['dbUser'], self::$dbConfig['dbPass'], $config));
            Debug::$debugBar->addCollector(new PDODataCollector\PDOCollector(self::$dbHandler));
        } catch (PDOException $e) {
            Debug::addException($e);
            Config::setError($e->getMessage());
            return false;
        } catch (DebugBarException $e) {
            Debug::addException($e);
            Config::setError($e->getMessage());
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
     * Transactions support
     *
     * @doc https://coderwall.com/p/rml5fa/nested-pdo-transactions
     */

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
     *
     * @return bool
     */
    final public function beginTransaction(): bool
    {
        $ret = true;
        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->beginTransaction();
        } else {
            $sql = 'SAVEPOINT LEVEL' . self::$transactionDepth . ';';
            $this->exec([$sql]);
        }

        self::$transactionDepth++;
        Debug::addMessage('SQL', 'Transaction started, savepoint LEVEL' . self::$transactionDepth . ' saved');

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

        Debug::addMessage('SQL', 'Commit, savepoint LEVEL' . self::$transactionDepth);
        self::$transactionDepth--;

        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->commit();
        } else {
            $sql = 'RELEASE SAVEPOINT LEVEL' . self::$transactionDepth . ';';
            $this->exec([$sql]);
        }

        return $ret;
    }
}
