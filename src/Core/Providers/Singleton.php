<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Alxarafe\Helpers\Utils;
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
    private static function getClassName(): string
    {
        $class = get_called_class();
        return Utils::getShortName($class, $class);
    }

    /**
     * Save config to file.
     *
     * @param array  $params
     * @param bool   $merge
     * @param string $index
     *
     * @return bool
     */
    public function setConfig(array $params, $merge = true, string $index = 'main'): bool
    {
        $paramsToSave = [];
        if ($this->separateConfigFile) {
            $content = $this->getYamlContent();
            $paramsToSave[$index] = $params;
        } else {
            $content = Config::getInstance()->getConfig();
            $paramsToSave[self::yamlName()][$index] = $params;
        }

        $content = $merge ? Utils::arrayMergeRecursiveEx($content, $paramsToSave) : $paramsToSave;

        return file_put_contents($this->getFilePath(), Yaml::dump($content, 3), LOCK_EX) !== false;
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
        $content = $this->separateConfigFile ? $yamlContent : $yamlContent[self::yamlName()] ?? [];
        return $content ?? [];
    }

    /**
     * Return the full file config path.
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return self::$basePath . constant('DIRECTORY_SEPARATOR') . $this->getFileName() . '.yaml';
    }

    /**
     * Return the file name.
     *
     * @return string
     */
    public function getFileName(): string
    {
        return ($this->separateConfigFile ? self::yamlName() : 'config');
    }

    /**
     * Return the classname for yaml file.
     *
     * @return string
     */
    public static function yamlName(): string
    {
        return strtolower(self::getClassName());
    }

    /**
     * Returns if file exists.
     *
     * @param string $filename
     *
     * @return bool
     */
    protected function fileExists(string $filename): bool
    {
        return (isset($filename) && file_exists($filename) && is_file($filename));
    }

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
        $content = $this->separateConfigFile ? $yamlContent : $yamlContent[$index] ?? [];
        return $content ?? [];
    }

    /**
     * Return the base path.
     *
     * @return string
     */
    public function getBasePath(): string
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
