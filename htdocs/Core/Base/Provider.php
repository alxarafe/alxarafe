<?php

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Helpers\Utils\ArrayUtils;
use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\FlashMessages;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

abstract class Provider extends Singleton
{
    /**
     * The base path where config files are placed.
     *
     * @var string
     */
    protected static string $basePath;

    /**
     * Set to true if you want to save configuration in a separate file
     *
     * @var bool
     */
    protected static bool $separateConfigFile = false;

    protected static array $configFileContent;

    public function __construct()
    {
        self::$configFileContent = $this->getDefaultValues();
    }

    /**
     * Return default values
     *
     * @return array
     */
    abstract public function getDefaultValues(): array;

    public static function getInstance(string $index = 'main')
    {
        self::$basePath = constant('BASE_FOLDER') . '/config';
        return parent::getInstance($index);
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
    public function setConfig(array $params, bool $merge = true, string $index = 'main'): bool
    {
        $paramsToSave = [];
        if ($this->separateConfigFile) {
            $content = $this->getYamlContent();
            if (!$merge) {
                unset($content[$index]);
            }
            $paramsToSave[$index] = $params;
        } else {
            $content = Config::getInstance()->getConfig();
            if (!$merge) {
                unset($content[self::yamlName()][$index]);
            }
            $paramsToSave[self::yamlName()][$index] = $params;
        }

        $content = ArrayUtils::arrayMergeRecursiveEx($content, $paramsToSave);

        return file_put_contents($this->getFilePath(), Yaml::dump($content, 3), LOCK_EX) !== false;
    }

    /**
     * Returns the content of the Yaml file.
     *
     * @return array
     */
    private static function getYamlContent(): array
    {
        $yamlContent = [];
        $file = self::getFilePath();
        if (self::fileExists($file)) {
            try {
                $yamlContent = Yaml::parseFile($file);
            } catch (ParseException $e) {
                //                Logger::getInstance()::exceptionHandler($e);
                FlashMessages::getInstance()::setError($e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());
                $yamlContent = [];
            }
        }
        $content = self::$separateConfigFile ? $yamlContent : $yamlContent[self::yamlName()] ?? [];
        return $content ?? [];
    }

    /**
     * Return the full file config path.
     *
     * @return string
     */
    public static function getFilePath(): string
    {
        return realpath(self::$basePath) . constant('DIRECTORY_SEPARATOR') . self::getFileName() . '.yaml';
    }

    /**
     * Return the file name.
     *
     * @return string
     */
    public static function getFileName(): string
    {
        return (self::$separateConfigFile ? self::yamlName() : 'config');
    }

    /**
     * Return the classname for yaml file.
     *
     * @return string
     */
    public static function yamlName(): string
    {
        return strtolower(parent::getClassName());
    }

    /**
     * Returns if file exists.
     *
     * @param string $filename
     *
     * @return bool
     */
    protected static function fileExists(string $filename): bool
    {
        return (file_exists($filename) && is_file($filename));
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
        $yamlContent = self::getYamlContent();
        $content = self::$separateConfigFile ? $yamlContent : $yamlContent[$index] ?? [];
        return array_merge(self::$configFileContent, $content);
    }

}