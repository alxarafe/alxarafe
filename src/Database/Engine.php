<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2023 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Database;

use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\Debug;
use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Class Engine
 *
 * Proporciona soporte genérico a bases de datos usando PDO.
 * Cada motor que desee desarrollarse extenderá esta clase y añadirá sus particularidades.
 * Se usa desde la clase estática DB.
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 * @version 2023.0108
 *
 * @package Alxarafe\Database
 */
abstract class Engine
{
    /**
     * Ruta en la que se encuentran los motores de la base de datos
     */
    const ENGINES_FOLDER = BASE_DIR . '/src/Database/Engines';

    /**
     * Data Source Name
     *
     * @var string
     */
    protected static string $dsn;

    /**
     * Array con los parámetros de acceso a la base de datos
     *
     * @var array
     */
    protected static array $dbConfig;

    /**
     * Instancia PDO
     *
     * @var PDO
     */
    protected static PDO $dbHandler;

    /**
     * Instancia PDOStatement
     *
     * @var PDOStatement|false
     */
    protected static $statement;

    /**
     * Indica si la base de datos soporta SAVEPOINT en las transacciones.
     * Si la base de datos no lo usa, el descendiente deberá de ponerlo a "false".
     * SAVEPOINT es una forma de anidar transacciones.
     *
     * @source https://coderwall.com/p/rml5fa/nested-pdo-transactions
     *
     * @var bool
     */
    protected static bool $savePointsSupport = true;

    /**
     * Indica el número de transacciones que están siendo ejecutadas.
     *
     * @var int
     */
    protected static int $transactionDepth = 0;

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
     * Engine destructor. Cancela las transacciones pendientes.
     */
    public function ___destruct()
    {
        $this->rollbackTransactions();
    }

    /**
     * Obtiene un array con los motores de base de datos disponibles.
     *
     * TODO: La extracción de archivos de una ruta por su extensión se usa en más
     *       de una ocasión. Habría que plantearse un método estático que lo facilite.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return array
     */
    public static function _getEngines(): array
    {
        $engines = scandir(self::ENGINES_FOLDER);
        $ret = [];
        foreach ($engines as $engine) {
            if ($engine != '.' && $engine != '..' && substr($engine, -4) == '.php') {
                $ret[] = substr($engine, 0, strlen($engine) - 4);
            }
        }
        return $ret;
    }

    /**
     * Retorna el nombre físico de la tabla. Estará en minúsculas y contendrá el prefijo de
     * la base de datos.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @param $tablename
     *
     * @return string
     */
    public static function getTableName($tableName): string
    {
        return DB::$dbPrefix . strtolower($tableName);
    }

    /**
     * Cancela las transacciones pendientes.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     */
    final public static function _rollbackTransactions()
    {
        while (self::$transactionDepth > 0) {
            self::rollback();
        }
    }

    /**
     * Cancela la transacción en curso
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return bool
     */
    final public static function _rollBack(): bool
    {
        $ret = true;

        if (self::$transactionDepth == 0) {
            throw new PDOException('Rollback error : There is no transaction started');
        }

        Debug::sqlMessage('Rollback, savepoint LEVEL' . self::$transactionDepth);
        self::$transactionDepth--;

        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->rollBack();
        } else {
            self::exec('ROLLBACK TO SAVEPOINT LEVEL' . self::$transactionDepth);
        }

        return $ret;
    }

    /**
     * Ejecuta una sentencia SQL (INSERT, UPDATE o DELETE).
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
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
     * Retorna el ID del último registro insertado. Vacío si no ha habido inserción.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return string
     */
    final public static function _getLastInserted(): string
    {
        $data = self::select('SELECT @@identity AS id');
        if (count($data) > 0) {
            return $data[0]['id'];
        }
        return '';
    }

    /**
     * Ejecuta el comando SELECT de SQL retornando la respuesta en un array.
     * Si no hay datos, retorna un array vacío.
     * En caso de error, retorna "false".
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @param string $query
     *
     * @return array|false
     */
    public static function select(string $query)
    {
        self::$statement = self::$dbHandler->prepare($query);
        if (self::$statement != null && self::$statement && self::$statement->execute([])) {
            return self::$statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    /**
     * Comprueba si hay una conexión activa a la base de datos.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return bool
     */
    public static function checkConnection(): bool
    {
        return (self::$dbHandler != null);
    }

    /**
     * Establece conexión con la base de datos.
     * Si ya existía una conexión, simplemente retorna éxito.
     * Retorna true si existe conexión, asignando el handler a self::$dbHandler.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param array $config
     *
     * @return bool
     */
    public static function connect(array $config = []): bool
    {
        if (isset(self::$dbHandler)) {
            Debug::sqlMessage("PDO: Already connected " . self::$dsn);
            return true;
        }
        Debug::sqlMessage("PDO: " . self::$dsn);
        try {
            // Logs SQL queries. You need to wrap your PDO object into a DebugBar\DataCollector\PDO\TraceablePDO object.
            // http://phpdebugbar.com/docs/base-collectors.html
            self::$dbHandler = new TraceablePDO(new PDO(self::$dsn, self::$dbConfig['dbUser'], self::$dbConfig['dbPass'], $config));
            Debug::addCollector(new PDOCollector(self::$dbHandler));
        } catch (PDOException $e) {
            Debug::addException($e);
            return false;
        }
        return isset(self::$dbHandler);
    }

    /**
     * Prepara una sentencia para su ejecución y la retorna.
     *
     * @source https://php.net/manual/en/pdo.prepare.php
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @param string $sql
     * @param array  $options
     *
     * @return bool
     */
    final public static function _prepare(string $sql, array $options = []): bool
    {
        if (!isset(self::$dbHandler)) {
            return false;
        }
        self::$statement = self::$dbHandler->prepare($sql, $options);
        return (self::$statement != false);
    }

    /**
     * Ejecuta una sentencia SQL previamente preparada.
     *
     * @source https://php.net/manual/en/pdostatement.execute.php
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @param array $inputParameters
     *
     * @return bool
     */
    final public static function _execute(array $inputParameters = []): bool
    {
        if (!isset(self::$statement) || !self::$statement) {
            return false;
        }
        return self::$statement->execute($inputParameters);
    }

    /**
     * Inicia una transacción
     *
     * @source https://www.ibm.com/support/knowledgecenter/es/SSEPGG_9.1.0/com.ibm.db2.udb.apdv.php.doc/doc/t0023166.htm
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return bool
     */
    final public static function _beginTransaction(): bool
    {
        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->beginTransaction();
        } else {
            $ret = self::exec('SAVEPOINT LEVEL' . self::$transactionDepth);
        }

        if (!$ret) {
            return false;
        }
        self::$transactionDepth++;
        Debug::sqlMessage('Transaction started, savepoint LEVEL' . self::$transactionDepth . ' saved');

        return true;
    }

    /**
     * Confirma la transacción en curso
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return bool
     */
    final public static function _commit(): bool
    {
        $ret = true;

        Debug::sqlMessage('Commit, savepoint LEVEL' . self::$transactionDepth);
        self::$transactionDepth--;

        if (self::$transactionDepth == 0 || !self::$savePointsSupport) {
            $ret = self::$dbHandler->commit();
        } else {
            self::exec('RELEASE SAVEPOINT LEVEL' . self::$transactionDepth);
        }

        return $ret;
    }
}
