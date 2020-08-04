<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

abstract class AbstractEditComponent extends AbstractComponent
{
    /**
     * Contains an array with the errors accumulated since the last run of getErrors
     *
     * @var array
     */
    public static $errors = [];

    /**
     * Clear accumulated errors and return pending ones.
     *
     * @return array
     */
    public static function getErrors()
    {
        $return = self::$errors;
        self::$errors = [];
        return $return;
    }

    abstract public static function test($key, $struct, &$value);

}