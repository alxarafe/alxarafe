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
 * Trait Singleton, This class ensures that all class that use this have only one instance of itself if called as:
 * Class::getInstance()
 *
 * If any specific class need more than one instance (for example database connection), can add a reference name to the
 * function to have a separate configuration using this reference name.
 *
 * @package Alxarafe\Providers
 */
trait Singleton
{

    /**
     * Set to true if you want use more that one singleton using and index
     * param in getInstance
     *
     * @var bool
     */
    protected static $singletonArray = false;
    /**
     * The base path where config files are placed.
     *
     * @var string
     */
    protected static $basePath;
    /**
     * Name of the class
     *
     * @var string
     */
    private static $className;
    /**
     * Hold the classes on instance.
     *
     * @var array
     */
    private static $instances = [];
    /**
     * Set to true if you want to save configuration in a separate file
     *
     * @var bool
     */
    protected $separateConfigFile = false;

    /**
     * Returns the yaml config params.
     *
     * @param string $index
     *
     * @return array
     */
    public function getConfig(string $index = 'main'): array
    {
        $yamlContent = $this->getYamlContent();
        $content = $this->separateConfigFile ? $yamlContent : $yamlContent[$index];
        return $content ?? [];
    }

    /**
     * Returns the content of the Yaml file.
     *
     * @param string $index
     *
     * @return array
     */
    private function getYamlContent(): array
    {
        $yamlContent = [];
        $file = $this->getFilePath();
        if ($this->fileExists($file)) {
            try {
                $yamlContent = Yaml::parseFile($file);
            } catch (ParseException $e) {
                Logger::getInstance()::exceptionHandler($e);
                $yamlContent = [];
            }
        }
        $content = $this->separateConfigFile ? $yamlContent : $yamlContent[strtolower(self::getClassName())];
        return $content ?? [];
    }

    /**
     * Return the full file config path.
     *
     * @return string
     */
    public function getFilePath()
    {
        return self::$basePath . constant('DIRECTORY_SEPARATOR') . $this->getFileName() . '.yaml';
    }

    /**
     * Return the file name.
     *
     * @return string
     */
    public function getFileName()
    {
        return ($this->separateConfigFile ? strtolower(self::getClassName()) : 'config');
    }

    /**
     * Returns the class name.
     */
    private static function getClassName()
    {
        $class = get_called_class();
        try {
            $className = (new ReflectionClass($class))->getShortName();
        } catch (\ReflectionException $e) {
            Logger::getInstance()::exceptionHandler($e);
            $className = $class;
        }
        return $className;
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
    public static function getInstance(string $index = 'main'): self
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
     * Returns if file exists.
     *
     * @param string $filename
     *
     * @return bool
     */
    protected function fileExists(string $filename)
    {
        return (isset($filename) && file_exists($filename) && is_file($filename));
    }

    /**
     * Save config to file.
     *
     * @param array  $params
     * @param string $index
     *
     * @return bool
     */
    public function setConfig(array $params, string $index = 'main')
    {
        $yamlContent = [];
        $yamlContent[self::getClassName()] = $this->getYamlContent();
        $content = $this->separateConfigFile ? $yamlContent : $yamlContent[self::getClassName()][$index];
        $content = array_merge($content, $params);
        return file_put_contents($this->getFilePath(), Yaml::dump($content)) !== false;
    }

    /**
     * Return the base path.
     *
     * @return string
     */
    public function getBasePath()
    {
        return self::$basePath;
    }

    /**
     * Initialization, equivalent to __construct and must be called from main class.
     */
    protected function initSingleton()
    {
        self::$instances = [];
        self::$className = self::getClassName();
        self::$basePath = basePath('config');
    }
}
