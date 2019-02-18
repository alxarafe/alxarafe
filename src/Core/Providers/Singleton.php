<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2019 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Providers;

use ReflectionClass;

/**
 * Class Singleton
 *
 * @package Alxarafe\Providers
 */
class Singleton
{

    /**
     * Name of the class
     * 
     * @var string
     */
    private static $className;

    /**
     * Hold the class instance.
     *
     * @var array
     */
    private static $instance = [];

    /**
     * Set to true if you want to save configuration in a separate file
     * 
     * @var bool
     */
    protected static $separateConfigFile = false;

    /**
     * Set to true if you want use more that one singleton using and index
     * param in getInstance
     *
     * @var bool
     */
    protected static $singletonArray = false;

    /**
     * Configuration path
     *
     * @var string
     */
    protected static $basePath;

    /**
     * The private constructor prevents instantiation through new.
     */
    private function __construct()
    {
        try {
            self::$className = (new ReflectionClass($this))->getShortName();
        } catch (\ReflectionException $e) {
            // $this must exists always, this exception must never success
            var_dump($e);
            die('Singelton constructor: $this must exists always, this exception must never success');
        }
        self::$basePath = constant('BASE_PATH') . '/config';
        $config = self::getConfig();
        var_dump($config);
    }

    /**
     * Clone is forbidden
     */
    private function __clone()
    {

    }

    /**
     * The object is created from within the class itself only if the class
     * has no instance.
     *
     * We opted to use an array to make several singletons according to the
     * index passed to getInstance
     *
     * @param string $index
     * @return type
     */
    public static function getInstance(string $index = 'main')
    {
        if (!self::$singletonArray) {
            $index = 'main';
        }

        if (!isset(self::$instance[$index])) {
            self::$instance[$index] = new self();
        }

        return self::$instance[$index];
    }

    protected function getConfig()
    {
        $file = $this->basePath . (self::$separateConfigFile ? self::$className : 'config') . '.yaml';
        if ($this->fileExists($file)) {
            $yaml = file_get_contents($file);
            if ($yaml) {
                $yamlArray = Yaml::parse($yaml);
                if (self::$separateConfigFile) {
                    return $yamlArray;
                }
                return $yamlArray[self::$className] ?? [];
            }
        }
        return [];
    }

    protected function setConfig(array $params)
    {
        $yamlArray = [];

        $file = $this->basePath . (self::$separateConfigFile ? self::$className : 'config') . '.yaml';
        if ($this->fileExists($file)) {
            $yaml = file_get_contents($file);
            $yamlArray = Yaml::parse($yaml) ?? [];
        }

        $content = array_merge($yamlArray, $params);

        return file_put_contents($file, Yaml::dump($content)) !== false;
    }
}
