<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

class Utils
{

    /**
     * Translate a literal in CamelCase format to snake_case format
     *
     * @param string $string
     * @param string $us
     * @return string
     */
    static public function camelToSnake($string, $us = '_')
    {
        $patterns = [
            '/([a-z]+)([0-9]+)/i',
            '/([a-z]+)([A-Z]+)/',
            '/([0-9]+)([a-z]+)/i'
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
     * @return string
     */
    static public function snakeToCamel($string, $us = '_')
    {
        return str_replace($us, '', ucwords($string, $us));
    }
}
