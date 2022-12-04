<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Database;

use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\DebugTool;
use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\DebugBarException;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Engine provides generic support for databases.
 * The class will have to be extended by completing the particularities of each of them.
 */
abstract class Engine
{
    /**
     * @var DebugTool
     */
    static DebugTool $debug;

    /**
     * Data Source Name
     *
     * @var string
     */
    static protected string $dsn;

    /**
     * Array that contains the access data to the database.
     *
     * @var array
     */
    static protected array $dbConfig;

    /**
     * The handler of the database.
     *
     * @var PDO
     */
    static protected PDO $dbHandler;

    /**
     * Represents a prepared statement and, after the statement is executed,
     * an associated result set.
     *
     * @var PDOStatement|false
     */
    static protected $statement;

    /**
     * True if the database engine supports SAVEPOINT in transactions
     *
     * @var bool
     */
    static protected bool $savePointsSupport = true;

    /**
     * Number of transactions in execution
     *
     * @var int
     */
    static protected int $transactionDepth = 0;

    /**
     * Engine constructor
     *
     * @param array $dbConfig
     */
    public function __construct(array $dbConfig)
    {
        self::$dbConfig = $dbConfig;
        self::$debug = DebugTool::getInstance();
    }

    /**
     * Obtain an array with the available engines
     *
     * @return array
     */
    public static function getEngines(): array
    {
        $path = constant('BASE_FOLDER') . '/src/Database/Engines';
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
     * Returns the name of the table, with a prefix, if one has been defined for the database, and in lowercase.
     *
     * @param $tablename
     *
     * @return string
     */
    public static function getTablename($tablename): string
    {
        return strtolower(Config::getVar('database', 'main', 'dbPrefix') . $tablename);
    }

    /**
     * Engine destructor
     *
     * @throws DebugBarException
     */
    public function __destruct()
    {
        $this->rollbackTransactions();
    }

    /**
     * Undo all active transactions
     *
     * @throws DebugBarException
     */
    final public function rollbackTransactions()
    {
        while (self::$transactionDepth > 0) {
            $this->rollback();
        }
    }

    /**
     * Rollback current transaction,
     *
     * @return bool
     * @throws PDOException if there is no transaction started
     */
    final public function rollBack(): bool
    {
        $ret = true;

        if (self::$transactionDepth == 0) {
            throw new PDOException('Rollback error : There is no transaction started');
        }

        self::$debug->addMessage('SQL', 'Rollback, savepoint LEVEL' . self::$transactionDepth);
        self::$transactionDepth--;

        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->rollBack();
        } else {
            $this->exec('ROLLBACK TO SAVEPOINT LEVEL' . self::$transactionDepth);
        }

        return $ret;
    }

    /**
     * Execute SQL statements on the database (INSERT, UPDATE or DELETE).
     *
     * @param string $query
     *
     * @return bool
     */
    final public static function exec(string $query): bool
    {
        self::$statement = self::$dbHandler->prepare($query);
        if (self::$statement != null && self::$statement) {
            return self::$statement->execute([]);
        }
        return false;
    }

    /**
     * Returns the id of the last inserted record. Failing that, it returns ''.
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
     *
     * @return array
     */
    public static function select(string $query): array
    {
        self::$statement = self::$dbHandler->prepare($query);
        if (self::$statement != null && self::$statement && self::$statement->execute([])) {
            return self::$statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    /**
     * Checks if there is an active connection to the database.
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
     * @throws DebugBarException
     */
    public function connect(array $config = []): bool
    {
        if (isset(self::$dbHandler)) {
            self::$debug->addMessage('SQL', "PDO: Already connected " . self::$dsn);
            return true;
        }
        self::$debug->addMessage('SQL', "PDO: " . self::$dsn);
        try {
            // Logs SQL queries. You need to wrap your PDO object into a DebugBar\DataCollector\PDO\TraceablePDO object.
            // http://phpdebugbar.com/docs/base-collectors.html
            self::$dbHandler = new TraceablePDO(new PDO(self::$dsn, self::$dbConfig['dbUser'], self::$dbConfig['dbPass'], $config));
            self::$debug->debugBar->addCollector(new PDOCollector(self::$dbHandler));
        } catch (PDOException $e) {
            self::$debug->addException($e);
            return false;
        }
        return isset(self::$dbHandler);
    }

    /**
     * Prepares a statement for execution and returns a statement object
     * http://php.net/manual/en/pdo.prepare.php
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
        self::$statement = self::$dbHandler->prepare($sql, $options);
        return (self::$statement != false);
    }
    /**
     * Transactions support
     * https://coderwall.com/p/rml5fa/nested-pdo-transactions
     */

    /**
     * Executes a prepared statement
     * http://php.net/manual/en/pdostatement.execute.php
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
     * source: https://www.ibm.com/support/knowledgecenter/es/SSEPGG_9.1.0/com.ibm.db2.udb.apdv.php.doc/doc/t0023166.htm
     *
     * @return bool
     */
    final public function beginTransaction(): bool
    {
        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->beginTransaction();
        } else {
            $ret = $this->exec('SAVEPOINT LEVEL' . self::$transactionDepth);
        }

        if (!$ret) {
            return false;
        }
        self::$transactionDepth++;
        self::$debug->addMessage('SQL', 'Transaction started, savepoint LEVEL' . self::$transactionDepth . ' saved');

        return true;
    }

    /**
     * Commit current transaction
     *
     * @return bool
     */
    final public function commit(): bool
    {
        $ret = true;

        self::$debug->addMessage('SQL', 'Commit, savepoint LEVEL' . self::$transactionDepth);
        self::$transactionDepth--;

        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->commit();
        } else {
            $this->exec('RELEASE SAVEPOINT LEVEL' . self::$transactionDepth);
        }

        return $ret;
    }
}
