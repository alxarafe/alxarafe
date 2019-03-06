<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers\Utils;

use Alxarafe\Core\Providers\Logger;
use ReflectionClass;
use ReflectionException;

/**
 * Class ClassUtils
 *
 * @package Alxarafe\Core\Helpers
 */
class ClassUtils
{
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
     * Returns the short name of the class.
     *
     * @param $objectClass
     * @param $calledClass
     *
     * @return string
     */
    public static function getShortName($objectClass, $calledClass): string
    {
        try {
            $shortName = (new ReflectionClass($objectClass))->getShortName();
        } catch (ReflectionException $e) {
            Logger::getInstance()::exceptionHandler($e);
            $shortName = $calledClass;
        }
        return $shortName;
    }
}
