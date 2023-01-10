<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Database\SqlHelpers;

use Alxarafe\Core\Utils\ArrayUtils;
use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\DebugTool;
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
        $dbName = Config::$dbName;
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
            $result[$row['Field']] = $row;
        }
        dump($rows);
        return $result;
    }

    public static function yamlFieldToSchema(array $data): array
    {
        $column = [];
        $key = (string) $data['key'];
        $type = (string) $data['type'];
        $column['key'] = $key;

        /**
         * Entrada:
         * - type es el tipo lógico del campo y tiene que estar definido como índice en
         *   TYPES, o ser uno de los predefinidos como 'autoincrement', 'relationship', etc.
         *
         * Salida:
         * - type queda intacto.
         * - dbtype es como queda definido en la tabla, por ejemplo, varchar(20)
         * - realtype es el tipo resultado, por ejemplo varchar (sin el tamaño)
         * - generictype es uno de los índices de TYPE. P.E. autoincrement se cambiará por integer
         *
         */

        $column['type'] = $type;
        switch ($type) {
            case 'autoincrement':
            case 'relationship':
                $colType = DB::getIndexType();
                break;
            default:
                $colType = $type;
        }

        $typeArray = static::splitType($colType);
        /**
         * ^ array:4 [▼
         *        "type" => "bigint"
         *        "length" => null
         *        "unsigned" => "yes"
         *        "zerofill" => "no"
         * ]
         */

        $type = $typeArray['type'];
        $length = $typeArray['length'] ?? $data['length'];
        $unsigned = $typeArray['unsigned'] === 'yes';
        $zerofill = $typeArray['zerofill'] === 'yes';
        $genericType = Schema::getTypeOf($type);

        $column['dbtype'] = $colType;
        $column['realtype'] = $type;
        $column['generictype'] = $genericType;

        $column['null'] = 'YES';
        if ($data['null'] && mb_strtolower($data['null']) == 'no') {
            $column['null'] = 'NO';
        }

        if (empty($data['default'])) {
            $column['default'] = null;
        } else {
            $column['default'] = (string) $data['default'];
        }

        /**
         * Pueden existir otras definiciones de limitaciones físicas como min y max
         * De existir, tienen que ser contempladas en el método test y tener mayor peso que
         * la limitación en plantilla.
         */
        foreach (['min', 'max'] as $field) {
            if (isset($data[$field])) {
                $column[$field] = (string) $data[$field];
            }
        }

        if (isset($data['comment'])) {
            $column['comentario'] = (string) $data['comment'];
        }

        if (isset($data['default'])) {
            if (is_bool($data['default'])) {
                $column['default'] = $data['default'] ? '1' : '0';
            } else {
                $column['default'] = trim($data['default'], " \"'`");
            }
        }

        switch ($genericType) {
            case 'text':
                $column['dbtype'] = 'varchar(' . $length . ')';
                $column['maxlength'] = $length;
                break;
            case 'integer':
                /**
                 * Lo primero es ver la capacidad física máxima según el tipo de dato.
                 */
                $bytes = 4;
                switch ($type) {
                    case 'tinyint':
                        $bytes = 1;
                        break;
                    case 'smallint':
                        $bytes = 2;
                        break;
                    case 'mediumint':
                        $bytes = 3;
                        break;
                    case 'int':
                        $bytes = 4;
                        break;
                    case 'bigint':
                        $bytes = 8;
                        break;
                }
                $bits = 8 * (int) $bytes;
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

                /**
                 * Se puede hacer una limitación física Se puede haber definido en el xml un min y un max.
                 * A todos los efectos, lo definido en el XML como min o max se toma como limitación
                 * física del campo.
                 */
                if (isset($data['min'])) {
                    $minXmlLength = $data['min'];
                    if ($minXmlLength > $minDataLength) {
                        $min = $minXmlLength;
                    } else {
                        Debug::message("({$key}): Se ha especificado un min {$minXmlLength} en el XML, pero por el tipo de datos, el mínimo es {$minDataLength}.");
                    }
                }
                if (isset($data['max'])) {
                    $maxXmlLength = $data['max'];
                    if ($maxXmlLength < $maxDataLength) {
                        $max = $maxXmlLength;
                    } else {
                        Debug::message("({$key}): Se ha especificado un min {$maxXmlLength} en el XML, pero por el tipo de datos, el máximo es {$maxDataLength}.");
                    }
                }

                $column['min'] = $min;
                $column['max'] = $max;
                break;
            default:
                // ???
        }
        return $column;
    }

    public static function yamlFieldToDb(array $data): array
    {
        $result = [];
        $result['Field'] = $data['key'];
        $result['Type'] = $data['dbtype'];
        $result['Null'] = !isset($data['nullable']) || $data['nullable'] ? 'YES' : 'NO';
        $result['Key'] = $data['type'] === 'autoincrement' ? 'PRI' : '';
        $result['Default'] = $data['default'] ?? null;
        $result['Extra'] = $data['type'] === 'autoincrement' ? 'auto_increment' : '';
        return $result;
    }

    public static function dbFieldToSchema(array $data): array
    {
        return $data;
    }

    public static function dbFieldToYaml(array $data): array
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
    public static function normalizeDbField(array $row): array
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
    private static function splitType(string $originalType): array
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
    public function normalizeIndexes(array $row): array
    {
        $result = [];
        $result['index'] = $row['Key_name'];
        $result['column'] = $row['Column_name'];
        $result['unique'] = $row['Non_unique'] == '0' ? 1 : 0;
        $result['nullable'] = $row['Null'] == 'YES' ? 1 : 0;
        $constrait = $this->getConstraintData($row['Table'], $row['Key_name']);
        if (count($constrait) > 0) {
            $result['constraint'] = $constrait[0]['CONSTRAINT_NAME'];
            $result['referencedtable'] = $constrait[0]['REFERENCED_TABLE_NAME'];
            $result['referencedfield'] = $constrait[0]['REFERENCED_COLUMN_NAME'];
        }
        $constrait = $this->getConstraintRules($row['Table'], $row['Key_name']);
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
    private function getConstraintData(string $tableName, string $constraintName): array
    {
        $dbName = Config::getVar('dbName') ?? 'Unknown';

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
	TABLE_SCHEMA = ' . $this->quoteFieldName($dbName) . ' AND
	TABLE_NAME = ' . $this->quoteFieldName($tableName) . ' AND
	constraint_name = ' . $this->quoteFieldName($constraintName) . ' AND
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
    private function getConstraintRules(string $tableName, string $constraintName): array
    {
        $dbName = Config::getVar('dbName') ?? 'Unknown';

        return DB::selectselect('
SELECT
	MATCH_OPTION,
	UPDATE_RULE,
	DELETE_RULE
FROM information_schema.REFERENTIAL_CONSTRAINTS
WHERE
	constraint_schema = ' . $this->quoteFieldName($dbName) . ' AND
	table_name = ' . $this->quoteFieldName($tableName) . ' AND
	constraint_name = ' . $this->quoteFieldName($constraintName) . ';
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
    public function getIndexesSql(string $tableName): string
    {
        // https://stackoverflow.com/questions/5213339/how-to-see-indexes-for-a-database-or-table-in-mysql

        return 'SHOW INDEX FROM ' . Config::getInstance()->getSqlHelper()->quoteTableName($tableName);
    }

    public static function modify(string $tableName, array $oldField, array $newField): string
    {
        $sql = 'ALTER TABLE ' . self::quoteTableName($tableName) . ' CHANGE ' . $oldField['Field'] . ' ' . $newField['Field'] . ' ';
        $sql .= $newField['Type'] . ' ';
        if ($newField) {
            if ($oldField['Null'] === 'NO') {
                $sql .= 'NOT ';
            }
        }
        $sql .= 'NULL';
        if ($newField['Default'] !== null) {
            $sql .= ' DEFAULT "' . $newField['Default'] . '"';
        }
        $sql .= ';';

        return $sql;
    }
}
