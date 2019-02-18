<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use ReflectionClass;
use Symfony\Component\Yaml\Yaml;

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
    public function __construct()
    {
        try {
            self::$className = (new ReflectionClass($this))->getShortName();
        } catch (\ReflectionException $e) {
            self::$className = $this;
        }
        self::$basePath = basePath('config/');
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
     *
     * @return self
     */
    public static function getInstance(string $index = 'main')
    {
        $class = get_called_class();
        self::$instance = [];

        if (!self::$singletonArray) {
            $index = 'main';
        }

        if (!isset(self::$instance[$index])) {
            self::$instance[$index] = new $class();
            try {
                self::$className = (new ReflectionClass(self::$instance[$index]))->getShortName();
            } catch (\ReflectionException $e) {
                self::$className = $class;
            }
        }

        return self::$instance[$index];
    }

    /**
     * Returns the yaml config params.
     *
     * @return array
     */
    protected function getConfig(): array
    {
        $file = self::$basePath . (self::$separateConfigFile ? strtolower(self::$className) : 'config') . '.yaml';
        if ($this->fileExists($file)) {
            $yaml = file_get_contents($file);
            if ($yaml) {
                $content = Yaml::parse($yaml);
                if (self::$separateConfigFile) {
                    return $content;
                }
                return $content[self::$className] ?? [];
            }
        }
        return [];
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    protected function setConfig(array $params)
    {
        $yamlArray = [];

        $file = self::$basePath . (self::$separateConfigFile ? self::$className : 'config') . '.yaml';
        if ($this->fileExists($file)) {
            $yaml = file_get_contents($file);
            $yamlArray = Yaml::parse($yaml) ?? [];
        }

        $content = array_merge($yamlArray, $params);

        return file_put_contents($file, Yaml::dump($content)) !== false;
    }

    /**
     * Returns if file exists.
     *
     * @param string $filename
     *
     * @return bool
     */
    private function fileExists(string $filename)
    {
        return (isset($filename) && file_exists($filename) && is_file($filename));
    }
}
