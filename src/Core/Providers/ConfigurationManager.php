<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Alxarafe\Helpers\Utils;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigurationManager
 *
 * @package Alxarafe\Providers
 */
class ConfigurationManager
{
    /**
     * @var
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $configFile;

    /**
     * @var array
     */
    protected $configContent;

    /**
     * @var string
     */
    protected $routeFile;

    /**
     * @var array
     */
    protected $routeContent;

    /**
     * ConfigurationManager constructor.
     *
     * @param $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
        $this->configContent = [];
        $this->routeContent = [];
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param mixed $basePath
     */
    public function setBasePath($basePath): void
    {
        $this->basePath = $basePath;
    }

    /**
     * @return mixed
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * @param mixed $configFile
     */
    public function setConfigFile($configFile): void
    {
        $this->configFile = $configFile;
    }

    /**
     * @return string
     */
    public function getRouteFile(): string
    {
        return $this->routeFile;
    }

    /**
     * @param string $routeFile
     */
    public function setRouteFile(string $routeFile): void
    {
        $this->routeFile = $routeFile;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->getFile($this->configFile);
    }

    /**
     * Returns an array with the configuration defined in the configuration file.
     * If file not exists, return empty data
     *
     * @return array
     */
    private function getFile($fileName): array
    {
        $file = $this->basePath . $fileName;
        if ($this->fileExists($file)) {
            $yaml = file_get_contents($file);
            if ($yaml) {
                return Yaml::parse($yaml);
            }
        }
        return [];
    }

    /**
     * @param $filename
     *
     * @return bool
     */
    private function fileExists($filename)
    {
        return (isset($filename) && file_exists($filename) && is_file($filename));
    }

    /**
     *
     */
    public function loadConstants()
    {
        define('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        define('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_ENCODED));
        define('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME', FILTER_SANITIZE_ENCODED));
        define('SITE_URL', constant('APP_PROTOCOL') . '://' . constant('SERVER_NAME'));
        define('BASE_URI', constant('SITE_URL') . constant('APP_URI'));

        Utils::defineIfNotExists('ALXARAFE_FOLDER', constant('BASE_PATH') . '/src/Core');
        Utils::defineIfNotExists('CALL_CONTROLLER', 'call');
        Utils::defineIfNotExists('METHOD_CONTROLLER', 'method');
        Utils::defineIfNotExists('DEFAULT_CONTROLLER', ($this->fileExists($this->configFile) ? 'EditConfig' : 'CreateConfig'));
        Utils::defineIfNotExists('DEFAULT_METHOD', 'run');
    }

    /**
     * @return array
     */
    public function getConfigContent(): array
    {
        return $this->configContent;
    }

    /**
     * @param array $configContent
     */
    public function setConfigContent(array $configContent): void
    {
        $this->configContent = $configContent;
        $this->saveFile($this->configFile, $configContent);
    }

    /**
     * Stores all the variables in a permanent file so that they can be loaded later with loadConfigFile()
     * Returns true if there is no error when saving the file.
     *
     * @param string $fileName
     * @param array  $content
     *
     * @return bool
     */
    private function saveFile(string $fileName, array $content)
    {
        return file_put_contents($fileName, Yaml::dump($content)) !== false;
    }

    /**
     * @return array
     */
    public function getRouteContent(): array
    {
        return $this->routeContent;
    }

    /**
     * @param array $routeContent
     */
    public function setRouteContent(array $routeContent): void
    {
        $this->routeContent = $routeContent;
        $this->saveFile($this->routeFile, $routeContent);
    }
}
