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

use Alxarafe\Core\Helpers\Dispatcher;
use Alxarafe\Core\Utils\Utils;
use Symfony\Component\Yaml\Yaml;

abstract class YamlSchema
{
    const YAML_CACHE_DIR = TMP_DIR . 'yamlcache/';
    public const YAML_CACHE_TABLES_DIR = 'models';

    /**
     * Contiene un array asociativo de las tablas y la ruta al archivo de definición.
     *
     * @var array
     */
    public static array $tables = [];

    private static $yamlPath;

    public static function clearYamlCache(): bool
    {
        return Utils::delTree(self::YAML_CACHE_DIR) && Utils::createDir(self::YAML_CACHE_DIR);
    }

    public static function getTables()
    {
        if (empty(self::$tables)) {
            self::$tables = Dispatcher::getFiles('Tables', 'yaml');
        }
        return self::$tables;
    }

    public static function getYamlFileName(string $folder, string $filename): string
    {
        $path = self::YAML_CACHE_DIR . $folder . '/';
        if (!file_exists($path)) {
            if (!Utils::createDir($path)) {
                debug_message('No se ha podido crear la carpeta ' . $path);
            }
        }
        return $path . $filename . '.yaml';
    }

    public static function _loadYamlFile(string $filename): array
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return [];
        }
        return Yaml::parseFile($filename);
    }

    public static function saveCacheYamlFile(string $folder, string $filename, array $content, int $maxLevel = 3): bool
    {
        $path = self::getYamlFileName($folder, $filename);
        return file_put_contents($path, Yaml::dump($content, $maxLevel)) !== false;
    }

    public static function loadCacheYamlFile(string $folder, string $filename): array
    {
        $path = self::getYamlFileName($folder, $filename);
        if (empty($path) || !file_exists($path) || !is_readable($path)) {
            return [];
        }
        if (!isset($path)) {
            dump($path);
        }
        return Yaml::parseFile($path);
    }

}
