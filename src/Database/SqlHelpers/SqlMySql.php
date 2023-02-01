<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Database\SqlHelpers;

use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Core\Utils\ArrayUtils;
use Alxarafe\Core\Singletons\Config;
use Alxarafe\Database\DB;
use Alxarafe\Database\Schema;
use Alxarafe\Database\SqlHelper;

/**
 * Class SqlMySql
 *
 * Soporte específico para la creación de comandos y consultas usando el motor MySQL.
 * Es usado directamente por la clase estática DB.
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 * @version 2023.0108
 *
 * @package Alxarafe\Database\SqlHelpers
 */
class SqlMySql extends SqlHelper
{
    /**
     * Retorna las comillas que encierran al nombre de la tabla en una consulta SQL.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return string
     */
    public static function getTableQuote(): string
    {
        return '`';
    }

    /**
     * Retorna las comillas que encierran al nombre de un campo en una consulta SQL
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return string
     */
    public static function getFieldQuote(): string
    {
        return '"';
    }

    /**
     * Retorna true si la tabla existe en la base de datos.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0106
     *
     * @param string $tableName
     *
     * @return bool
     */
    public static function tableExists(string $tableName): bool
    {
        $dbName = DB::$dbName;
        $sql = "SELECT COUNT(*) AS Total FROM information_schema.tables WHERE table_schema = '{$dbName}' AND table_name='{$tableName}'";

        $data = DB::select($sql);
        $result = reset($data);

        return $result['Total'] === '1';
    }

    /**
     * Retorna un array con la asociación de tipos del motor SQL para cada tipo definido
     * en el Schema.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return array[]
     */
    public static function getDataTypes(): array
    {
        return [
            Schema::TYPE_INTEGER => ['tinyint', 'smallint', 'mediumint', 'int', 'bigint'],
            Schema::TYPE_FLOAT => ['real', 'double'],
            Schema::TYPE_DECIMAL => ['decimal', 'numeric'],
            Schema::TYPE_STRING => ['char', 'varchar'],
            Schema::TYPE_TEXT => ['tinytext', 'text', 'mediumtext', 'longtext', 'blob'],
            Schema::TYPE_DATE => ['date'],
            Schema::TYPE_TIME => ['time'],
            Schema::TYPE_DATETIME => ['datetime', 'timestamp'],
            Schema::TYPE_BOOLEAN => ['boolean'],
        ];
    }

    /**
     * Retorna un array con el nombre de todas las tablas de la base de datos.
     *
     * @return array
     */
    public static function getTables(): array
    {
        $query = 'SHOW TABLES';
        return ArrayUtils::flatArray(DB::select($query));
    }

    /**
     * Retorna el tipo de dato que se utiliza para los índices autoincrementados
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return string
     */
    public static function getIndexType(): string
    {
        return 'bigint(20) unsigned';
    }

    public static function getIntegerMinMax(int $size, bool $unsigned): array
    {
        switch ($size) {
            case 1:
                $type = 'tinyint';
                break;
            case 2:
                $type = 'smallint';
                break;
            case 3:
                $type = 'mediumint';
                break;
            case 4:
                $type = 'int';
                break;
            default:
                $type = 'bigint';
                $size = 8;
                break;
        }

        $bits = 8 * (int) $size;
        $physicalMaxLength = 2 ** $bits;

        /**
         * $minDataLength y $maxDataLength contendrán el mínimo y máximo valor que puede contener el campo.
         */
        $minDataLength = $unsigned ? 0 : -$physicalMaxLength / 2;
        $maxDataLength = ($unsigned ? $physicalMaxLength : $physicalMaxLength / 2) - 1;

        /**
         * De momento, se asignan los límites máximos por el tipo de dato.
         * En $min y $max, iremos arrastrando los límites conforme se vayan comprobando.
         * $min nunca podrá ser menor que $minDataLength.
         * $max nunca podrá ser mayor que $maxDataLength.
         */
        $min = $minDataLength;
        $max = $maxDataLength;

        return [
            'dbtype' => $type,
            'min' => $min,
            'max' => $max,
            'size' => $size,
            'unsigned' => $unsigned,
        ];
    }

    /**
     * Retorna un array asociativo con la información de cada columna de la tabla.
     * El resultado será dependiente del motor de base de datos.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @param string $tableName
     *
     * @return array
     */
    public static function getColumns(string $tableName): array
    {
        $query = 'SHOW COLUMNS FROM ' . self::quoteTableName($tableName) . ';';
        $rows = DB::select($query);
        $result = [];
        foreach ($rows as $row) {
            unset($row['Key']);  // Los índices están gestionados por separado
            $result[$row['Field']] = $row;
        }
        return $result;
    }

    public static function yamlFieldIntegerToDb(array $data): string
    {
        $type = $data['dbtype'];
        // TODO: Aunque lo que está comentado va, igual no hace falta si al comparar
        //       ignoramos el tamaño a mostrar para los integer

        $unsigned = $data['unsigned'] ?? false;
        /*
        switch ($type) {
            case 'tinyint':
                return $type . ($unsigned ? '(3) unsigned' : '(4)');
            case 'smallint':
                break;
            case 'mediumint':
                break;
            case 'int':
                return $type . ($unsigned ? '(10) unsigned' : '(11)');
            case 'bigint':
                $type .= '(20)';
        }
        */
        return $type . ($unsigned ? ' unsigned' : '');
    }

    public static function yamlFieldToDb(array $data): array
    {
        $nullable = strtolower($data['nullable']) !== 'no';

        $result = [];
        $result['Field'] = $data['name'];

        $type = $data['dbtype'];
        switch ($data['generictype']) {
            case Schema::TYPE_INTEGER:
                $type = self::yamlFieldIntegerToDb($data);
                break;
            case Schema::TYPE_FLOAT:
            case Schema::TYPE_DECIMAL:
                break;
            case Schema::TYPE_STRING:
                $type = 'varchar(' . $data['length'] . ')';
                break;
            case Schema::TYPE_TEXT:
            case Schema::TYPE_DATE:
            case Schema::TYPE_TIME:
            case Schema::TYPE_DATETIME:
                break;
            case Schema::TYPE_BOOLEAN:
                //                $type = 'tinyint(1)';
                break;
        }
        $result['Type'] = $type;
        $result['Null'] = $nullable ? 'YES' : 'NO';
        $result['Key'] = $data['type'] === 'autoincrement' ? 'PRI' : '';
        $result['Default'] = $data['default'] ?? null;
        $result['Extra'] = $data['type'] === 'autoincrement' ? 'auto_increment' : '';
        return $result;
    }

    public static function yamlIndexToDb(array $data): array
    {
        $result = [];
        foreach ($data['fields'] as $name => $field) {
            if ($field['type'] === 'autoincrement') {
                $result['PRIMARY'] = [
                    'column' => $name,
                    'primary' => 'yes',
                ];
            }
        }
        return array_merge($result, $data['indexes'] ?? []);
    }

    public static function getSqlField(array $column): string
    {
        $field = $column['Field'];
        $type = $column['Type'];
        $null = $column['Null'];
        $key = $column['Key'];
        $default = $column['Default'];
        $extra = $column['Extra'];

        $sql = self::quoteTableName($field) . ' ' . $type;
        $nulo = ($null === 'YES');
        if ($extra === 'auto_increment') {
            $nulo = false;
            $sql .= ' PRIMARY KEY AUTO_INCREMENT';
        }

        $sql .= ($nulo ? '' : ' NOT') . ' NULL';

        $defecto = '';
        if (isset($default)) {
            if ($default === 'CURRENT_TIMESTAMP') {
                $defecto = $default;
            } elseif (is_bool($default)) {
                $defecto = $default ? 1 : 0;
            } else {
                $defecto = "'$defecto'";
            }
        } else {
            if ($nulo) {
                $defecto = 'NULL';
            }
        }

        if (!empty($defecto)) {
            $sql .= ' DEFAULT ' . $defecto;
        }
        return $sql;
    }

    public static function _dbFieldToSchema(array $data): array
    {
        return $data;
    }

    public static function _dbFieldToYaml(array $data): array
    {
        return $data;
    }

    /**
     * Recibiendo un array con los datos de un campo tal y como lo retorna la base de
     * datos, devuelve la información normalizada para ser utilizada por Schema.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @param array $row
     *
     * @return array
     */
    public static function _normalizeDbField(array $row): array
    {
        $result = [];
        $result['Field'] = $row['key'];
        $result['Type'] = $row['type'];
        $result['Null'] = $row['nullable'] ? 'YES' : 'NO';
        $result['Key'] = $row['type'] === 'autoincrement' ? 'PRI' : '';
        $result['Default'] = $row['default'] ?? null;
        $result['Extra'] = $row['type'] === 'autoincrement' ? 'auto_increment' : '';
        return $result;
    }

    /**
     * Divide the data type of a MySQL field into its various components: type,
     * length, unsigned or zerofill, if applicable.
     *
     * @param string $originalType
     *
     * @return array
     */
    private static function _splitType(string $originalType): array
    {
        $explode = explode(' ', strtolower($originalType));

        $pos = strpos($explode[0], '(');

        $type = $pos ? substr($explode[0], 0, $pos) : $explode[0];
        $length = $pos ? intval(substr($explode[0], $pos + 1)) : null;

        $pos = array_search('unsigned', $explode);
        $unsigned = $pos ? 'unsigned' : null;

        $pos = array_search('zerofill', $explode);
        $zerofill = $pos ? 'zerofill' : null;

        return ['type' => $type, 'length' => $length, 'unsigned' => $unsigned, 'zerofill' => $zerofill];
    }

    /**
     * Returns an array with the index information, and if there are, also constraints.
     *
     * @param array $row
     *
     * @return array
     */
    public static function normalizeIndexes(array $row): array
    {
        $result = [];
        $result['index'] = $row['Key_name'];
        $result['column'] = $row['Column_name'];
        $result['unique'] = $row['Non_unique'] == '0' ? 1 : 0;
        $result['nullable'] = $row['Null'] == 'YES' ? 1 : 0;
        $constrait = self::getConstraintData($row['Table'], $row['Key_name']);
        if (count($constrait) > 0) {
            $result['constraint'] = $constrait[0]['CONSTRAINT_NAME'];
            $result['referencedtable'] = $constrait[0]['REFERENCED_TABLE_NAME'];
            $result['referencedfield'] = $constrait[0]['REFERENCED_COLUMN_NAME'];
        }
        $constrait = self::getConstraintRules($row['Table'], $row['Key_name']);
        if (count($constrait) > 0) {
            $result['matchoption'] = $constrait[0]['MATCH_OPTION'];
            $result['updaterule'] = $constrait[0]['UPDATE_RULE'];
            $result['deleterule'] = $constrait[0]['DELETE_RULE'];
        }
        return $result;
    }

    /**
     * The data about the constraint that is found in the KEY_COLUMN_USAGE table
     * is returned.
     * Attempting to return the consolidated data generates an extremely slow query
     * in some MySQL installations, so 2 additional simple queries are made.
     *
     * @param string $tableName
     * @param string $constraintName
     *
     * @return array
     */
    private static function getConstraintData(string $tableName, string $constraintName): array
    {
        $dbName = DB::$dbName;

        return DB::select('
SELECT
	TABLE_NAME,
	COLUMN_NAME,
	CONSTRAINT_NAME,
	REFERENCED_TABLE_NAME,
	REFERENCED_COLUMN_NAME
FROM
	INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
	TABLE_SCHEMA = ' . self::quoteFieldName($dbName) . ' AND
	TABLE_NAME = ' . self::quoteFieldName($tableName) . ' AND
	constraint_name = ' . self::quoteFieldName($constraintName) . ' AND
	REFERENCED_COLUMN_NAME IS NOT NULL;
        ');
    }

    /**
     * The rules for updating and deleting data with constraint (table
     * REFERENTIAL_CONSTRAINTS) are returned.
     * Attempting to return the consolidated data generates an extremely slow query
     * in some MySQL installations, so 2 additional simple queries are made.
     *
     * @param string $tableName
     * @param string $constraintName
     *
     * @return array
     */
    private static function getConstraintRules(string $tableName, string $constraintName): array
    {
        $dbName = DB::$dbName;

        return DB::select('
SELECT
	MATCH_OPTION,
	UPDATE_RULE,
	DELETE_RULE
FROM information_schema.REFERENTIAL_CONSTRAINTS
WHERE
	constraint_schema = ' . self::quoteFieldName($dbName) . ' AND
	table_name = ' . self::quoteFieldName($tableName) . ' AND
	constraint_name = ' . self::quoteFieldName($constraintName) . ';
        ');
    }

    /**
     * Obtain an array with the basic information about the indexes of the table,
     * which will be supplemented with the restrictions later.
     *
     * @param string $tableName
     *
     * @return string
     */
    public static function getIndexesSql(string $tableName): string
    {
        // https://stackoverflow.com/questions/5213339/how-to-see-indexes-for-a-database-or-table-in-mysql

        return 'SHOW INDEX FROM ' . self::quoteTableName($tableName);
    }

    /**
     * Toma la estructura de un campo obtenida de la base de datos, y la retorna
     * de la misma forma en la que se usó al ser creada.
     * Esto es necesario, porque algunas bases de datos cambian tipos como boolean por
     * tinyint(1), o int por int(10)
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $genericType
     * @param array  $structure
     *
     * @return array
     */
    public static function sanitizeDbStructure(string $genericType, array $structure): array
    {
        $type = $structure['Type'];
        switch ($genericType) {
            // Tipos que no cambian
            case Schema::TYPE_FLOAT:
            case Schema::TYPE_DECIMAL:
            case Schema::TYPE_STRING:
            case Schema::TYPE_TEXT:
            case Schema::TYPE_DATE:
            case Schema::TYPE_TIME:
            case Schema::TYPE_DATETIME:
                break;
            // Tipos a los que hay que quitar los paréntesis
            case Schema::TYPE_INTEGER:
                $type = preg_replace("/\((.*?)\)/i", "", $type);
                break;
            // Tipos que cambian durante la creación
            case Schema::TYPE_BOOLEAN:
                $type = 'boolean'; // Se crea como boolean y se retorna como tinyint(1)
                $structure['Default'] = ($structure['Default'] === '1');
                break;
        }
        $structure['Type'] = $type;
        return $structure;
    }

    public static function modify(string $tableName, array $oldField, array $newField): string
    {
        $sql = 'ALTER TABLE ' . self::quoteTableName($tableName) . ' CHANGE ' . $oldField['Field'] . ' ' . $newField['Field'] . ' ';
        $sql .= $newField['Type'] . ' ';
        if (strtolower($newField['Null']) === 'no') {
            $sql .= 'NOT ';
        }
        $sql .= 'NULL';
        if ($newField['Default'] !== null) {
            if ($newField['Type'] === 'boolean') {
                $newField['Default'] = $newField['Default'] ? '1' : '0';
            }
            $sql .= ' DEFAULT "' . $newField['Default'] . '"';
        }
        $sql .= ';';
        return $sql;
    }

    /**
     * Obtains an array of indexes for a table
     *
     * @param string $tableName
     *
     * @return array
     * @throws \DebugBar\DebugBarException
     */
    public static function getIndexes(string $tableName): array
    {
        $query = self::getIndexesSql($tableName);
        $data = DB::select($query);
        $result = [];
        foreach ($data as $value) {
            $row = self::normalizeIndexes($value);
            $result[$row['index']] = $row;
        }

        return $result;
    }

    public static function createIndex(string $tableName, string $index, array $data): string
    {
        $name = $data['column'];
        $primary = $data['primary'] === 'yes';
        $unique = $data['unique'] === 'yes';
        $sql = "ALTER TABLE `$tableName` ADD CONSTRAINT `$index` ";
        if ($primary) {
            $sql .= "PRIMARY KEY(`$name`)";
        }
        if ($unique) {
            $sql .= "UNIQUE(`$name`)";
        }
        $sql .= ';';

        return $sql;
    }

    public static function changeIndex(string $tableName, string $index, array $oldData, array $newData): string
    {
        $oldPrimary = $oldData['index'] === 'PRIMARY';
        $oldUnique = $oldData['unique'] === 1;

        $newPrimary = $newData['primary'] === 'yes';
        $newUnique = $newData['unique'] === 'yes';

        $ok = true;
        $ok = $ok && ($oldData['column'] === $newData['column']);
        $ok = $ok && ($oldPrimary === $newPrimary);

        // Si es primaria, es unique siempre así que solo comprobamos si no es unique
        if ($ok && !$oldPrimary) {
            $ok = $ok && $oldUnique === $newUnique;
        }

        // No hay cambios
        if ($ok) {
            return '';
        }

        $name = $newData['column'];

        $sql = "ALTER TABLE `$tableName` ADD CONSTRAINT  `$index` ";
        if ($newPrimary) {
            $sql .= "PRIMARY KEY(`$name`)";
        }
        if ($newUnique) {
            $sql .= "UNIQUE(`$name`)";
        }
        $sql .= ';';

        return $sql;
    }

    public static function removeIndex(string $tableName, string $index): string
    {
        $sql = "ALTER TABLE `$tableName` DROP CONSTRAINT `$index`";

        return $sql;
    }

}
