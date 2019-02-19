<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use ReflectionClass;
use Symfony\Component\Yaml\Exception\ParseException;
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
    protected function __construct()
    {
        try {
            self::$className = (new ReflectionClass($this))->getShortName();
        } catch (\ReflectionException $e) {
            self::$className = $this;
        }
        self::$basePath = basePath('config');
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
        $content = $this->getYamlContent();
        if (self::$separateConfigFile) {
            return $content;
        }
        return $content[self::$className] ?? [];
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    protected function setConfig(array $params)
    {
        $content = $this->getYamlContent();
        $content = array_merge($content, $params);
        return file_put_contents($this->getFilePath(), Yaml::dump($content)) !== false;
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

    /**
     * Return the full file config path.
     *
     * @return string
     */
    private function getFilePath()
    {
        return self::$basePath . '/' . (self::$separateConfigFile ? strtolower(self::$className) : 'config') . '.yaml';
    }

    /**
     * Returns the content of the Yaml file.
     *
     * @return array
     */
    private function getYamlContent()
    {
        $yamlContent = [];
        $file = $this->getFilePath();
        if ($this->fileExists($file)) {
            try {
                $yamlContent = Yaml::parseFile($file);
            } catch (ParseException $e) {
                $yamlContent = [];
            }
        }
        return $yamlContent;
    }
}
