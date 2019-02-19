<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Providers\Logger;

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
     * Add the elements of the 2nd array behind those of the first.
     *
     * @param array $intialArray
     * @param array $nextArray
     *
     * @return array
     */
    public static function addToArray(array $initialArray, array $nextArray): array
    {
        $ret = $initialArray;
        foreach ($nextArray as $value) {
            $ret[] = $value;
        }
        return $ret;
    }

    /**
     * Return true if $param is setted and is 'yes', otherwise return false.
     *
     * @param array  $param
     * @param string $key
     *
     * @return bool
     */
    public static function isTrue(array $param, $key): bool
    {
        return (isset($param[$key]) && (in_array($param[$key], ['yes', 'true', '1', 1])));
    }

    /**
     * Given an array of parameters, an index and a possible default value,
     * returns a literal of the form: index = 'value'.
     * It is used, for example, to assign attributes to an html statement.
     *
     * @param array       $itemsArray
     * @param string      $itemIndex
     * @param string|null $defaultValue
     *
     * @return string
     */
    public static function getItem(array $itemsArray, string $itemIndex, $defaultValue = null): string
    {
        $res = $itemsArray[$itemIndex] ?? $defaultValue;
        return isset($res) ? " $itemIndex = '$res'" : '';
    }

    /**
     * Generate a random string for a given length.
     * Tries to generate from most secure random text to less.
     *
     * @param int $length
     *
     * @return string
     */
    public static function randomString($length = 16): string
    {
        if (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes($length);
        } elseif (function_exists("random_bytes")) {
            try {
                $bytes = random_bytes($length);
            } catch (\Exception $e) {
                Logger::getInstance()->exceptionHandler($e);
                self::randomString($length);
            }
        } else {
            return mb_substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
        }
        return bin2hex($bytes);
    }
}
