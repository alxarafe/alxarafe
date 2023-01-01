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

namespace Alxarafe\Core\Utils;

/**
 * Class Utils
 *
 * @package Alxarafe\Helpers
 */
class Utils
{

    /**
     * Translate a literal in CamelCase format to snake_case format
     *
     * @param string $string
     * @param string $us
     *
     * @return string
     */
    public static function camelToSnake($string, $us = '_'): string
    {
        $patterns = [
            '/([a-z]+)([0-9]+)/i',
            '/([a-z]+)([A-Z]+)/',
            '/([0-9]+)([a-z]+)/i',
        ];
        $string = preg_replace($patterns, '$1' . $us . '$2', $string);

        // Lowercase
        $string = strtolower($string);

        return $string;
    }

    /**
     * Translate a literal in snake_case format to CamelCase format
     *
     * @param string $string
     * @param string $us
     *
     * @return string
     */
    public static function snakeToCamel($string, $us = '_'): string
    {
        return str_replace($us, '', ucwords($string, $us));
    }

    /**
     * Define a constant if it does not exist
     *
     * @param string $const
     * @param        $value
     */
    public static function defineIfNotExists(string $const, $value)
    {
        if (!defined($const)) {
            define($const, $value);
        }
    }

    /**
     * Flatten an array to leave it at a single level.
     * Ignore the value of the indexes of the array, taking only the values.
     * Remove spaces from the result and convert it to lowercase.
     *
     * @param array $array
     *
     * @return array
     */
    public static function flatArray(array $array): array
    {
        $ret = [];
        foreach ($array as $value) {
            if (is_array($value)) {
                // We expect that the indexes will not overlap
                $ret = array_merge($ret, self::flatArray($value));
            } else {
                $ret[] = strtolower(trim($value));
            }
        }
        return $ret;
    }

    /**
     * Crea una carpeta con los permisos seleccionados.
     *
     * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
     * @version 2023.0101
     *
     * @param string $directory
     * @param int    $permissions
     * @param bool   $recursive
     *
     * @return bool
     */
    public static function createDir(string $directory, int $permissions = 0777, bool $recursive = true): bool
    {
        return (\is_dir($directory) || @\mkdir($directory, $permissions, $recursive) || \is_dir($directory));
    }
}
