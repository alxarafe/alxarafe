<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

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
    public static function defineIfNotExists(string $const, $value): void
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
     * Return true if $param is setted and is 'yes', otherwise return false.
     *
     * @param string $param
     *
     * @return bool
     */
    public static function isTrue($param)
    {
        return (isset($param) && (in_array($param, ['yes', 'true', '1', 1])));
    }
}
