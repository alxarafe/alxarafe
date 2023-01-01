<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Database;

use Symfony\Component\Yaml\Yaml;

abstract class YamlSchema
{
    public const PHP_CACHE_FOLDER = 'models';

    /**
     * Array asociativo con la última lista de tablas leídas de la base de datos.
     * Se ha optimizado generándolo como array asociativo.
     * Se ha probado cacheando en una tabla yaml, y así es mucho más rápido.
     *
     * @var null|array
     */
    private static $tableList = null;
    private static $xmlTableList = null;

    private static function getTablesFrom(string $folder): array
    {
        $fullFolder = $folder . '/Models/Tables/';
        $tables = scandir($fullFolder);
        if ($tables === false) {
            dump('No existe o no hay datos en ' . $fullFolder);
            return [];
        }

        $result = [];
        foreach ($tables as $table) {
            if ($table !== '.' && $table !== '..' && (substr($table, -5) === '.yaml')) {
                $result[substr($table, 0, strlen($table) - 5)] = $fullFolder . $table;
            }
        }
        return $result;
    }

    public static function getTables(): array
    {
        // TODO: Definir constante
        $tableName = BASE_FOLDER . '/tmp/tables.yaml';

        if (file_exists($tableName)) {
            return YAML::parse(file_get_contents($tableName));
        }

        $path = BASE_FOLDER . '/Modules/';

        $result = [];
        $modules = scandir($path);
        foreach ($modules as $module) {
            if ($module !== '.' && $module !== '..') {
                $result = array_merge($result, self::getTablesFrom($path . $module));
            }
        }

        $result = array_merge($result, self::getTablesFrom(BASE_FOLDER . '/src'));

        // file_put_contents($tableName, YAML::dump($result));
        return $result;
    }

    /**
     * Divide un tipo de dato de la base de datos en sus diferentes partes.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @param string $originalType
     *
     * @return array
     */
    public static function splitType(string $originalType): array
    {
        $replacesSources = [
            'character varying',
            // 'timestamp without time zone',
            'double precision',
        ];
        $replacesDestination = [
            'varchar',
            // 'timestamp',
            'double',
        ];
        $modifiedType = (str_replace($replacesSources, $replacesDestination, $originalType));

        if ($originalType !== $modifiedType) {
            debug_message("XML: Uso de '{$originalType}' en lugar de '{$modifiedType}'.");
        }
        $explode = explode(' ', strtolower($modifiedType));

        $pos = strpos($explode[0], '(');
        if ($pos > 0) {
            $begin = $pos + 1;
            $end = strpos($explode[0], ')');
            $type = substr($explode[0], 0, $pos);
            $length = substr($explode[0], $begin, $end - $begin);
        } else {
            $type = $explode[0];
            $length = null;
        }

        $pos = array_search('unsigned', $explode, true);
        $unsigned = $pos ? 'yes' : 'no';

        $pos = array_search('zerofill', $explode, true);
        $zerofill = $pos ? 'yes' : 'no';

        return ['type' => $type, 'length' => $length, 'unsigned' => $unsigned, 'zerofill' => $zerofill];
    }

    /**
     * Elimina la lista de tablas leídas de la base de datos, para comprobar si existe si tener que consultar cada vez.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     */
    public static function clearTableList()
    {
        self::$tableList = null;
    }

    /**
     * Ésto realiza comprobaciones adicionales.
     * Por lo que veo, lo único que hace es tratar de convertir una tabla que no es
     * InnoDB en InnoDB.
     * En otras bases de datos como Postgres no hace nada.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @param $table_name
     *
     * @return bool
     */
    public static function checkTableAux(string $table_name): bool
    {
        return DB::$engine->check_table_aux($table_name);
    }

    /**
     * Retorna el código SQL para actualizar las columnas de una tabla que han sufrido
     * modificaciones en su archivo de definición.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @version 2022.0903
     *
     * @param string $table_name
     * @param array  $xml_cols
     * @param array  $db_cols
     *
     * @return string
     */
    public static function compareColumns(string $table_name, array $xml_cols, array $db_cols): string
    {
        return DB::$engine->compare_columns($table_name, $xml_cols, $db_cols);
    }

    /**
     * Retorna el código SQL para actualizar las constraint de una tabla que ha sufrido
     * modificaciones en su archivo de definición.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @param $table_name
     * @param $xml_cons
     * @param $db_cons
     * @param $delete_only
     *
     * @return string
     */
    public static function compareConstraints($table_name, $xml_cons, $db_cons, $delete_only = false): string
    {
        return DB::$engine->compare_constraints($table_name, $xml_cons, $db_cons, $delete_only);
    }

    /**
     * Retorna el formato de fecha de la base de datos.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @return string
     */
    public static function dateStyle(): string
    {
        return DB::$engine->date_style();
    }

    /**
     * Retorna el literal $str eliminando aquellos caracteres que pueden provocar problemas en
     * una consulta SQL.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @param string $str
     *
     * @return string
     */
    public static function escapeString(string $str): string
    {
        return "'" . DB::$engine->escape_string($str) . "'";
    }

    public static function generateTableSql(string $tablename): string
    {
        $xml = static::getXmlTable($tablename);
        return DB::$engine->generate_table($tablename, $xml['columns'], $xml['constraints']);
    }

    public static function generateTableSeedSql(string $tablename): string
    {
        $seeds = static::getFilesFromPlugins('Model/seed/', '.csv');
        if (!isset($seeds[$tablename])) {
            return '';
        }

        $filename = $seeds[$tablename];

        $result = '';

        $rows = 10; // Indicamos el número de registros que vamos a insertar de una vez
        $handle = fopen($filename, "r");
        if ($handle === false) {
            debug_message('No ha sido posible abrir el archivo ' . $filename);
            return '';
        }

        // Asumimos que la primera fila es la cabecera...
        $header = fgetcsv($handle, 0, ';');
        if ($header === false) {
            debug_message('No ha sido posible leer la primera línea del archivo ' . $filename);
            fclose($handle);
            return '';
        }

        $sqlHeader = "INSERT INTO `{$tablename}` (`" . implode('`, `', $header) . '`) VALUES ';
        $row = 0;
        $sqlData = [];
        while (($data = fgetcsv($handle, 0, ';')) !== false) {
            // Entrecomillamos lo que no sea null.
            foreach ($data as $key => $datum) {
                if (mb_strtoupper($datum) !== 'NULL') {
                    $data[$key] = "'$datum'";
                }
            }

            if ($row % $rows === 0) {
                if (count($sqlData) > 0) {
                    $result .= ($sqlHeader . implode(', ', $sqlData) . ';' . PHP_EOL);
                }
                $sqlData = [];
            }
            $sqlData[] = '(' . implode(', ', $data) . ')';
            $row++;
        }
        if (count($sqlData) > 0) {
            $result .= ($sqlHeader . implode(', ', $sqlData) . ';' . PHP_EOL);
        }
        fclose($handle);

        return $result;
    }

    /**
     * Crea una tabla a partir de su estructura xml.
     * Puebla los datos
     * Retorna true si consigue crearla correctamente.
     * Retorna false si se produce un error durante la creación, o si ya existe.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0907
     *
     * @param string $tablename
     *
     * @return bool
     */
    public static function generateTable(string $tablename): bool
    {
        $sql = static::generateTableSql($tablename);
        $ok = DB::exec($sql);
        if (!$ok) {
            return false;
        }
        $sql = static::generateTableSeedSql($tablename);
        return DB::exec($sql);
    }

    /**
     * Contiene un array con las columnas de la tabla.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @param string $table_name
     *
     * @return array
     */
    public static function getColumns(string $table_name): array
    {
        $result = [];
        foreach (DB::$engine->get_columns($table_name) as $column) {
            $result[$column['name']] = $column;
        }
        return $result;
    }

    /**
     * Retorna un array asociativo con los archivos de la ruta especificada ($path),
     * que tengan extensión $extension.
     * El índice es el nombre del archivo sin extensión.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0904
     *
     * @param string $path
     * @param string $extension
     *
     * @return array
     */
    private static function getFilesFromPath(string $path, string $extension): array
    {
        $result = [];

        if (!file_exists($path)) {
            return $result;
        }

        $scanData = scandir($path);
        if (!is_array($scanData)) {
            return $result;
        }

        foreach ($scanData as $scan) {
            // Excluímos las carpetas . y ..
            if (mb_strpos($scan, '.') === 0) {
                continue;
            }
            if (mb_substr($scan, -mb_strlen($extension)) === $extension) {
                $result[mb_substr($scan, 0, -mb_strlen($extension))] = constant('BASE_PATH') . '/' . $path . $scan;
            }
        }

        return $result;
    }

    /**
     * Obtiene todos los archivos de la ruta especificada para el núcleo y plugins.
     * En el caso de tablas repetidas, se mantiene el del último plugin activado.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0904
     *
     * @param string $folder
     * @param string $extension
     *
     * @return array
     */
    public static function getFilesFromPlugins(string $folder, string $extension): array
    {
        $result = [];

        // Ruta de los xml en formato antiguo
        $path = $folder;
        $result = array_merge($result, static::getFilesFromPath($path, $extension));

        // Ruta de los xml en formato nuevo
        $path = 'src/Xnet/' . $folder;
        $result = array_merge($result, static::getFilesFromPath($path, $extension));

        foreach (Version::getEnabledPluginsArray() as $plugin) {
            $path = 'plugins/' . $plugin . '/' . mb_strtolower($folder);
            $result = array_merge($result, static::getFilesFromPath($path, $extension));

            $path = 'plugins/' . $plugin . '/' . $folder;
            $result = array_merge($result, static::getFilesFromPath($path, $extension));
        }

        return $result;
    }

    /**
     * Carga el listado de archivos XML del archivo YAML existente.
     * Si el archivo YAML no existe, genera la información y lo crea.
     * Retorna un array asociativo con el contenido de dicho archivo.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0904
     *
     * @return array
     */
    private static function getYamlXmlFiles(): array
    {
        $result = XnetPhpFileCache::loadYamlFile(XnetConfig::PHP_CACHE_FOLDER, 'tables');
        if (!empty($result)) {
            return $result;
        }

        $result = static::getFilesFromPlugins('Model/table/', '.xml');
        XnetPhpFileCache::saveYamlFile(XnetConfig::PHP_CACHE_FOLDER, 'tables', $result);
        return $result;
    }

    /**
     * Retorna la ruta del archivo xml de configuración de la tabla $tablename
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @param string $tablename
     *
     * @return string
     */
    public static function getXmlPath(string $tablename): ?string
    {
        $files = static::listXmlTables();
        if (isset($files[$tablename])) {
            return $files[$tablename];
        }
        return null;
    }

    /**
     * Incluye el archivo XML $child dentro de $parent, y retorna el resultado.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @param \SimpleXMLElement $parent
     * @param \SimpleXMLElement $child
     *
     * @return \SimpleXMLElement
     */
    private static function mergeXml(\SimpleXMLElement $parent, \SimpleXMLElement $child): \SimpleXMLElement
    {
        foreach (['columna', 'restriccion'] as $toMerge) {
            foreach ($child->{$toMerge} as $item) {
                $childItem = $parent->addChild($toMerge, $item);
                foreach ($item->children() as $child) {
                    $childItem->addChild($child->getName(), reset($child));
                }
                // Si es una relación extendida, tiene que ser nullable para poder desactivar el plugin
                if (!isset($childItem->nulo) && reset($childItem->tipo) === 'relationship') {
                    $childItem->addChild('nulo', 'YES');
                }
            }
        }
        return $parent;
    }

    /**
     * Carga el archivo XML $filename, incluyendo sus dependencias de otros XML
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0810
     *
     * @param string $tablename
     *
     * @return \SimpleXMLElement
     */
    private static function loadXmlFile(string $tablename): \SimpleXMLElement
    {
        $filename = self::getXmlPath($tablename);
        if (empty($filename)) {
            die($tablename . ' XML not found');
        }

        if (!file_exists($filename)) {
            die('Archivo ' . $filename . ' no encontrado.');
        }

        $xml = simplexml_load_string(file_get_contents($filename, FILE_USE_INCLUDE_PATH));
        if (!$xml) {
            die('Error al leer el archivo ' . $filename);
        }

        if (!isset($xml->incluye) || $xml->incluye->count() === 0) {
            return $xml;
        }

        // Si hay un apartado "incluye", hay que incluir las rutas
        foreach ($xml->incluye->children() as $item) {
            $includeFilename = './' . trim(reset($item));

            $xmlParent = simplexml_load_string(file_get_contents($includeFilename, FILE_USE_INCLUDE_PATH));
            if (!$xmlParent) {
                die('Error al leer el archivo ' . $includeFilename);
            }

            $xml = self::mergeXml($xmlParent, $xml);
        }

        return $xml;
    }

    /**
     * Normaliza la información de una columna con los datos que se le han pasado del XML.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0905
     *
     * @param \SimpleXMLElement $col
     *
     * @return array
     */
    private static function getXmlColumn(\SimpleXMLElement $col): array
    {
        $column = [];
        $key = (string) $col->nombre;

        $column['nombre'] = $key;
        $column['tipo'] = (string) $col->tipo;

        $column['nulo'] = 'YES';
        if ($col->nulo && mb_strtolower($col->nulo) == 'no') {
            $column['nulo'] = 'NO';
        }

        if (empty($col->defecto)) {
            $column['defecto'] = null;
        } else {
            $column['defecto'] = (string) $col->defecto;
        }

        /**
         * Pueden existir otras definiciones de limitaciones físicas como min y max
         * De existir, tienen que ser contempladas en el método test y tener mayor peso que
         * la limitación en plantilla.
         */
        foreach (['min', 'max'] as $field) {
            if (isset($col->{$field})) {
                $column[$field] = (string) $col->{$field};
            }
        }

        if (isset($col->description)) {
            debug_message('Cambie la etiqueta <description> por comentario en ' . $col->nombre . ' de ' . $tablename);
            $column['comentario'] = (string) $col->description;
        } elseif (isset($col->comment)) {
            debug_message('Cambie la etiqueta <comment> por comentario en ' . $col->nombre . ' de ' . $tablename);
            $column['comentario'] = (string) $col->comment;
        } elseif (isset($col->comentario)) {
            $column['comentario'] = (string) $col->comentario;
        }

        // Aquí vienen los datos adicionales...

        switch ($col->tipo) {
            case 'serial':
                $colType = constant('FS_DB_INTEGER');
                break;
            case 'autoincrement':
            case 'relationship':
                $colType = constant('DB_INDEX_TYPE');
                break;
            case 'boolean':
                $colType = 'tinyint(1) unsigned';
                break;
            default:
                $colType = (string) $col->tipo;
        }
        $typeArray = static::splitType($colType);
        $type = $typeArray['type'];
        $length = $typeArray['length'];
        $unsigned = $typeArray['unsigned'] === 'yes';
        $zerofill = $typeArray['zerofill'] === 'yes';
        $genericType = Schema::getTypeOf($type);

        $column['realtype'] = $type;
        $column['generictype'] = $genericType;

        if (isset($col->defecto)) {
            $column['default'] = trim($col->defecto, " \"'`");
        }

        switch ($genericType) {
            case 'string':
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
                if (isset($col->min)) {
                    $minXmlLength = $col->min;
                    if ($minXmlLength > $minDataLength) {
                        $min = $minXmlLength;
                    } else {
                        debug_message("({$key}): Se ha especificado un min {$minXmlLength} en el XML, pero por el tipo de datos, el mínimo es {$minDataLength}.");
                    }
                }
                if (isset($col->max)) {
                    $maxXmlLength = $col->max;
                    if ($maxXmlLength < $maxDataLength) {
                        $max = $maxXmlLength;
                    } else {
                        debug_message("({$key}): Se ha especificado un min {$maxXmlLength} en el XML, pero por el tipo de datos, el máximo es {$maxDataLength}.");
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

    /**
     * Retorna un array con el contenido del archivo XML de la tabla seleccionada.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0904
     *
     * @param string $tablename
     *
     * @return array[]
     */
    public static function getXmlTable(string $tablename): array
    {
        XnetDebugBar::startTimer('leexml' . $tablename, 'Leer archivo ' . $tablename);
        $result = XnetPhpFileCache::loadYamlFile(static::PHP_CACHE_FOLDER, $tablename);
        XnetDebugBar::stopTimer('leexml' . $tablename);

        if (!empty($result)) {
            return $result;
        }

        XnetDebugBar::startTimer('creaxml' . $tablename, 'Crear archivo ' . $tablename);

        $xml = self::loadXmlFile($tablename);

        $columns = [];
        $constraints = [];
        if ($xml->columna) {
            foreach ($xml->columna as $col) {
                $columns[] = static::getXmlColumn($col);
            }
        }

        if ($xml->restriccion) {
            $i = 0;
            foreach ($xml->restriccion as $col) {
                $constraints[$i]['nombre'] = (string) $col->nombre;
                $constraints[$i]['consulta'] = (string) $col->consulta;
                $i++;
            }
        }

        $result = [
            'columns' => $columns,
            'constraints' => $constraints,
        ];

        if (!XnetPhpFileCache::saveYamlFile(static::PHP_CACHE_FOLDER, $tablename, $result)) {
            debug_message('No se ha podido guardar el XML de ' . $tablename . ' en la YAML caché.');
        }
        XnetDebugBar::stopTimer('creaxml' . $tablename);
        return $result;
    }

    public static function getConstraints(string $table_name, bool $extended = false): array
    {
        if ($extended) {
            return DB::$engine->get_constraints_extended($table_name);
        }

        return DB::$engine->get_constraints($table_name);
    }

    public function deleteConstraint(string $table_name, string $constraint_name): bool
    {
        return DB::$engine->delete_constraint($table_name, $constraint_name);
    }

    public function getIndexes($table_name)
    {
        return DB::$engine->get_indexes($table_name);
    }

    public static function getSelects()
    {
        return DB::$engine->get_selects();
    }

    public static function getTransactions()
    {
        return DB::$engine->get_transactions();
    }

    public static function lastval()
    {
        return DB::$engine->lastval();
    }

    public function select_limit($sql, $limit = null, $offset = 0)
    {
        if ($limit === null) {
            $limit = get_item_limit();
        }
        return DB::$engine->select_limit($sql, $limit, $offset);
    }

    public function sql_to_int($col_name)
    {
        return DB::$engine->sql_to_int($col_name);
    }

    /**
     * Obtiene un array asociativo indexado por el nombre de cada una de las tablas
     * de la base de datos. El valor de cada elemento se pone a true, pero lo que
     * realmente importa es el índice, pues se verifica si el índice está, que es
     * más rápido que buscar.
     * El array se cachea en self::$tableList para las próximas peticiones.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0904
     *
     * @return array
     */
    private static function listTables(): array
    {
        if (isset(self::$tableList)) {
            return self::$tableList;
        }

        $items = DB::$engine->list_tables();
        self::$tableList = [];
        foreach ($items as $item) {
            self::$tableList[$item['name']] = true;
        }
        return self::$tableList;
    }

    /**
     * Obtiene un array asociativo indexado por el nombre de las tablas de la base
     * de datos, tomadas de los archivos XML de definición.
     * El array contiene la ruta completa al archivo XML correspondiente.
     * El array se cachea en self::$xmlTableList para las siguientes peticiones,
     * pero además, la búsqueda en el sistema de archivos también se cachea en
     * un archivo yaml, que sólo se regenera al limpiar caché.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0904
     *
     * @return array
     */
    public static function listXmlTables($force = false): array
    {
        if (isset(self::$xmlTableList) && !$force) {
            return self::$xmlTableList;
        }

        self::$xmlTableList = static::getYamlXmlFiles();
        return self::$xmlTableList;
    }

    /**
     * Retorna TRUE si la tabla $name existe en la base de datos.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0904
     *
     * @param $name
     *
     * @return bool
     */
    public static function tableExists($name)
    {
        $list = self::listTables();
        return isset($list[$name]);
    }

    /**
     * Actualiza el juego de caracteres y cómo se aplican las comparaciones.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0903
     *
     * @param string $charset
     * @param string $collation
     *
     * @return bool
     */
    public static function updateCollation(string $charset = 'utf8mb4', string $collation = 'utf8mb4_bin'): bool
    {
        return DB::$engine->update_collation($charset, $collation);
    }

    /**
     * Realiza una búsqueda sin distinguir case ni tildes.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0904
     *
     * @param $col_name
     * @param $search
     * @param $splitWord
     *
     * @return string
     */
    public function search_diacritic_insensitive($col_name, $search, $splitWord = '')
    {
        return DB::$engine->search_diacritic_insensitive($col_name, $search, $splitWord);
    }
}
