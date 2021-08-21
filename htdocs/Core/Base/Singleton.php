<?php

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Utils\ClassUtils;

abstract class Singleton
{
    /**
     * Hold the classes on instance.
     *
     * @var array
     */
    private static array $instances = [];

    public function __construct(string $index = 'main')
    {
        $className = self::getClassName();
        if (isset(self::$instances[$className][$index])) {
            die("Please use '$className:getInstance()' instead of 'new' to instantiate a Singleton.");
        }
        self::$instances[$className][$index] = $this;
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
        $className = self::getClassName();
        if (!isset(self::$instances[$className][$index])) {
            new static($index);
        }
        return self::$instances[$className][$index];
    }

}