<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use DebugBar\DataCollector\PDO as PDODataCollector;
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
    static protected $dsn;

    /**
     * Array that contains the access data to the database.
     *
     * @var array
     */
    static protected $dbConfig;

    /**
     * The handler of the database.
     *
     * @var PDO
     */
    static protected $dbHandler;

    /**
     * Represents a prepared statement and, after the statement is executed, 
     * an associated result set.
     *
     * @var \PDOStatement|false
     */
    static protected $statement;

    /**
     * True if the database engine supports SAVEPOINT in transactions
     * 
     * @var bool
     */
    static protected $savePointsSupport = true;

    /**
     * Number of transactions in execution
     *
     * @var int
     */
    static protected $transactionDepth = 0;

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
     * Engine destructor
     */
    public function __destruct()
    {
        $this->rollbackTransactions();
    }

    /**
     * Returns the id of the last inserted record. Failing that, it
     * returns ''.
     *
     * @return string
     */
    final public function getLastInserted()
    {
        $data = $this->select('SELECT @@identity AS id');
        if (count($data) > 0) {
            return $data[0]['id'];
        }
        return '';
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public static function getEngines(): array
    {
        $path = ALXARAFE_FOLDER . '/Database/Engines';
        $engines = scandir($path);
        $ret = [];
        foreach ($engines as $engine) {
            if ($engine != '.' && $engine != '..' && substr($engine, -4) == '.php') {
                $ret[] = substr($engine, 0, strlen($engine) - 4);
            }
        }
        return $ret;
    }

    /**
     * TODO: Undocumented
     *
     * @return bool
     */
    public function checkConnection()
    {
        return (self::$dbHandler != Null);
    }

    /**
     * Establish a connection to the database.
     * If a connection already exists, it returns it. It does not establish a new one.
     * Returns true in case of success, assigning the handler to self::$dbHandler.
     *
     * @param array $config
     *
     * @return bool
     * @throws \DebugBar\DebugBarException
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
            return false;
        }
        return isset(self::$dbHandler);
    }

    /**
     * Prepares a statement for execution and returns a statement object
     * http://php.net/manual/en/pdo.prepare.php
     *
     * @param string $sql
     * @param array $options
     * @return bool
     */
    final public function prepare(string $sql, array $options = []): bool
    {
        if (!isset(self::$dbHandler)) {
            return false;
        }
        self::$statement = self::$dbHandler->prepare($sql, $options);
        return (self::$statement != false);
    }

    /**
     * Executes a prepared statement
     * http://php.net/manual/en/pdostatement.execute.php
     *
     * @param array $inputParameters
     *
     * @return bool
     * @throws \DebugBar\DebugBarException
     */
    final public function execute(array $inputParameters = []): bool
    {
        if (!isset(self::$statement) || !self::$statement) {
            return false;
        }
        return self::$statement->execute($inputParameters);
    }

    /**
     * Returns an array containing all of the result set rows
     *
     * @return array
     * @throws \DebugBar\DebugBarException
     */
    final public function _resultSet(): array
    {
        self::execute();
        return self::$statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute SQL statements on the database (INSERT, UPDATE or DELETE).
     *
     * @param string $query
     *
     * @return bool
     * @throws \DebugBar\DebugBarException
     */
    final public static function exec(string $query): bool
    {
        Debug::addMessage('SQL', 'PDO exec: ' . $query);
        self::$statement = self::$dbHandler->prepare($query);
        if (self::$statement != null && self::$statement) {
            return self::$statement->execute([]);
        }
        return false;
    }

    /**
     * Executes a SELECT SQL statement on the database, returning the result in an array.
     * In case of failure, return NULL. If there is no data, return an empty array.
     *
     * @param string $query
     *
     * @return array
     * @throws \DebugBar\DebugBarException
     */
    public static function select(string $query): array
    {
        Debug::addMessage('SQL', 'PDO select: ' . $query);
        self::$statement = self::$dbHandler->prepare($query);
        if (self::$statement != null && self::$statement && self::$statement->execute([])) {
            return self::$statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    /**
     * Obtain an array with the table structure with a standardized format.
     *
     * @param $tableName
     *
     * @return mixed
     */
    public static function getStructure($tableName)
    {
        return [
            'fields' => Config::$sqlHelper->getColumns($tableName),
            'indexes' => Config::$sqlHelper->getIndexes($tableName),
            // 'constraints' => Config::$sqlHelper->getConstraints($tableName),
            // 'values' => Config::$sqlHelper->getValues($tableName)
        ];
    }
    /**
     * Transactions support
     * https://coderwall.com/p/rml5fa/nested-pdo-transactions
     */

    /**
     * Start transaction
     * source: https://www.ibm.com/support/knowledgecenter/es/SSEPGG_9.1.0/com.ibm.db2.udb.apdv.php.doc/doc/t0023166.htm
     *
     * @return bool
     * @throws \DebugBar\DebugBarException
     */
    final public function beginTransaction(): bool
    {
        $ret = true;
        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->beginTransaction();
        } else {
            $exec = $this->exec('SAVEPOINT LEVEL' . self::$transactionDepth);
        }

        self::$transactionDepth++;
        Debug::addMessage('SQL', 'Transaction started, savepoint LEVEL' . self::$transactionDepth . ' saved');

        return $ret;
    }

    /**
     * Commit current transaction
     *
     * @return bool
     * @throws \DebugBar\DebugBarException
     */
    final public function commit()
    {
        $ret = true;

        Debug::addMessage('SQL', 'Commit, savepoint LEVEL' . self::$transactionDepth);
        self::$transactionDepth--;

        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->commit();
        } else {
            $this->exec('RELEASE SAVEPOINT LEVEL' . self::$transactionDepth);
        }

        return $ret;
    }

    /**
     * Rollback current transaction,
     *
     * @return bool
     * @throws \DebugBar\DebugBarException|PDOException if there is no transaction started
     */
    final public function rollBack()
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
            $this->exec('ROLLBACK TO SAVEPOINT LEVEL' . self::$transactionDepth);
        }

        return $ret;
    }

    /**
     * Undo all active transactions
     */
    final private function rollbackTransactions()
    {
        while (self::$transactionDepth > 0) {
            $this->rollback();
        }
    }
}
