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
     * The base path where config files are placed.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Full path to config file.
     *
     * @var string
     */
    protected $configFile;

    /**
     * Contains the config content.
     *
     * @var array
     */
    protected $configContent;

    /**
     * Full path to route file.
     *
     * @var string
     */
    protected $_routeFile;

    /**
     * Containts the routes content.
     *
     * @var array
     */
    protected $_routeContent;

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
     * Returns the base path.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Sets the base path.
     *
     * @param string $basePath
     */
    public function setBasePath($basePath): void
    {
        $this->basePath = $basePath;
    }

    /**
     * Return the full config file path.
     *
     * @return string
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * Sets the config file.
     *
     * @param string $configFile
     */
    public function setConfigFile(string $configFile): void
    {
        $this->configFile = $this->basePath . constant('DIRECTORY_SEPARATOR') . $configFile;
    }

    /**
     * Returns the full route file path.
     *
     * @return string
     */
    public function _getRouteFile(): string
    {
        return $this->routeFile;
    }

    /**
     * Sets the route file path.
     *
     * @param string $routeFile
     */
    public function _setRouteFile(string $routeFile): void
    {
        $this->routeFile = $this->basePath . constant('DIRECTORY_SEPARATOR') . $routeFile;
    }

    /**
     * Loads some constants.
     */
    public function loadConstants()
    {
        /**
         * It is recommended to define BASE_PATH as the first line of the index.php file of the application.
         *
         * define('BASE_PATH', __DIR__);
         */
        Utils::defineIfNotExists('BASE_PATH', __DIR__ . '/../../../..');
        Utils::defineIfNotExists('LANG', 'en');
        Utils::defineIfNotExists('DEBUG', false);

        define('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        define('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_ENCODED));
        define('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME', FILTER_SANITIZE_ENCODED));
        define('SITE_URL', constant('APP_PROTOCOL') . '://' . constant('SERVER_NAME'));
        define('BASE_URI', constant('SITE_URL') . constant('APP_URI'));

        /**
         * Must be defined in main index.php file
         */
        Utils::defineIfNotExists('VENDOR_FOLDER', constant('BASE_PATH') . '/vendor');
        Utils::defineIfNotExists('ALXARAFE_FOLDER', constant('BASE_PATH') . '/src/Core');
        Utils::defineIfNotExists('DEFAULT_TEMPLATES_FOLDER', constant('BASE_PATH') . '/vendor/alxarafe/alxarafe/templates');
        Utils::defineIfNotExists('VENDOR_URI', constant('BASE_URI') . '/vendor');
        Utils::defineIfNotExists('ALXARAFE_URI', constant('BASE_URI') . '/vendor/alxarafe/alxarafe/src/Core');
        Utils::defineIfNotExists('DEFAULT_TEMPLATES_URI', constant('BASE_URI') . '/vendor/alxarafe/alxarafe/templates');

        define('CONFIGURATION_PATH', constant('BASE_PATH') . '/config');
        define('DEFAULT_STRING_LENGTH', 50);
        define('DEFAULT_INTEGER_SIZE', 10);

        Utils::defineIfNotExists('CALL_CONTROLLER', 'call');
        Utils::defineIfNotExists('METHOD_CONTROLLER', 'method');
        Utils::defineIfNotExists('DEFAULT_CONTROLLER', ($this->fileExists($this->configFile) ? 'EditConfig' : 'CreateConfig'));
        Utils::defineIfNotExists('DEFAULT_METHOD', 'run');

        // Use cache on Core
        define('CORE_CACHE_ENABLED', true);

        // Default number of rows per page.
        define('DEFAULT_ROWS_PER_PAGE', 25);

        // Carry Return (retorno de carro) & Line Feed (salto de línea).
        define('CRLF', "\n\t");
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
     * Returns the config content.
     * If config content is empty, load from file.
     * Otherwise return data from property.
     *
     * @return array
     */
    public function getConfigContent()
    {
        if (empty($this->configContent)) {
            $this->configContent = $this->getFile($this->configFile);
        }
        return $this->configContent;
    }

    /**
     * Sets new config content and store to config file.
     *
     * @param array $configContent
     */
    public function setConfigContent(array $configContent): void
    {
        $this->configContent = $configContent;
        $this->saveFile($this->configFile, $configContent);
    }

    /**
     * Returns an array with the configuration defined in the configuration file.
     * If file not exists, return empty data
     *
     * @param string $fileName
     *
     * @return array
     */
    private function getFile(string $fileName): array
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
     * Returns the route content.
     * If route content is empty, load from file.
     * Otherwise return data from property.
     *
     * @return array
     */
    public function getRouteContent(): array
    {
        if (empty($this->routeContent)) {
            $this->routeContent = $this->getFile($this->routeFile);
        }
        return $this->routeContent;
    }

    /**
     * Sets new route content and store to config file.
     *
     * @param array $routeContent
     */
    public function setRouteContent(array $routeContent): void
    {
        $this->routeContent = $routeContent;
        $this->saveFile($this->routeFile, $routeContent);
    }
}
