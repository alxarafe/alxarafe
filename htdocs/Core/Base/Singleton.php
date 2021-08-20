<?php

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Utils\ClassUtils;

abstract class Singleton
{
    /**
     * Set to true if you want use more that one singleton using and index
     * param in getInstance
     *
     * @var bool
     */
    protected static bool $singletonArray = false;

    /**
     * Name of the class
     *
     * @var string
     */
    private static string $className;

    /**
     * Hold the classes on instance.
     *
     * @var array
     */
    private static array $instances = [];

    /**
     * The object is created from within the class itself only if the class
     * has no instance.
     *
     * We opted to use an array to make several singletons according to the
     * index passed to getInstance
     *
     * @param string $index
     *
     * @return mixed
     */
    public static function getInstance(string $index = 'main')
    {
        if (!self::$singletonArray) {
            $index = 'main';
        }
        if (!isset(self::$instances[self::getClassName()][$index])) {
            self::$instances[self::getClassName()][$index] = new static();
        }
        return self::$instances[self::getClassName()][$index];
    }

    /**
     * Returns the class name.
     *
     * @return string
     */
    protected static function getClassName(): string
    {
        $class = static::class;
        return ClassUtils::getShortName($class, $class);
    }

}