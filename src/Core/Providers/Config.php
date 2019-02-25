<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Alxarafe\Helpers\Utils;

/**
 * Class ConfigurationManager
 *
 * @package Alxarafe\Providers
 */
class Config
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Contains the config content.
     *
     * @var array
     */
    protected $configContent;

    /**
     * ConfigurationManager constructor.
     *
     * @param $basePath
     */
    public function __construct()
    {
        if (!isset($this->configContent)) {
            $this->separateConfigFile = true;
            $this->initSingleton();
            $this->getConfigContent();
        }
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
            $allContent = $this->getConfig();
            $this->configContent = $allContent;
        }
        return $this->configContent;
    }

    /**
     * Return this instance.
     *
     * @return Config
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
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

        Utils::defineIfNotExists('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        Utils::defineIfNotExists('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_ENCODED));
        Utils::defineIfNotExists('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME', FILTER_SANITIZE_ENCODED));
        Utils::defineIfNotExists('SITE_URL', constant('APP_PROTOCOL') . '://' . constant('SERVER_NAME'));
        Utils::defineIfNotExists('BASE_URI', constant('SITE_URL') . constant('APP_URI'));

        /**
         * Must be defined in main index.php file
         */
        Utils::defineIfNotExists('VENDOR_FOLDER', constant('BASE_PATH') . '/vendor');
        Utils::defineIfNotExists('ALXARAFE_FOLDER', constant('BASE_PATH') . '/src/Core');
        Utils::defineIfNotExists('DEFAULT_TEMPLATES_FOLDER', constant('BASE_PATH') . '/vendor/alxarafe/alxarafe/templates');
        Utils::defineIfNotExists('VENDOR_URI', constant('BASE_URI') . '/vendor');
        Utils::defineIfNotExists('ALXARAFE_URI', constant('BASE_URI') . '/vendor/alxarafe/alxarafe/src/Core');
        Utils::defineIfNotExists('DEFAULT_TEMPLATES_URI', constant('BASE_URI') . '/vendor/alxarafe/alxarafe/templates');

        Utils::defineIfNotExists('CONFIGURATION_PATH', constant('BASE_PATH') . '/config');
        Utils::defineIfNotExists('DEFAULT_STRING_LENGTH', 50);
        Utils::defineIfNotExists('DEFAULT_INTEGER_SIZE', 10);

        Utils::defineIfNotExists('CALL_CONTROLLER', 'call');
        Utils::defineIfNotExists('METHOD_CONTROLLER', 'method');
        Utils::defineIfNotExists('DEFAULT_CONTROLLER', ($this->fileExists($this->getFilePath()) ? 'EditConfig' : 'CreateConfig'));
        Utils::defineIfNotExists('DEFAULT_METHOD', 'index');

        // Use cache on Core
        Utils::defineIfNotExists('CORE_CACHE_ENABLED', true);

        // Default number of rows per page.
        Utils::defineIfNotExists('DEFAULT_ROWS_PER_PAGE', 25);

        // Carry Return (retorno de carro) & Line Feed (salto de línea).
        Utils::defineIfNotExists('CRLF', "\n\t");
    }


    /**
     * Return true y the config file exists
     *
     * @return bool
     */
    public function configFileExists(): bool
    {
        return (file_exists($this->getFilePath()) && is_file($this->getFilePath()));
    }
}
