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
        $this->separateConfigFile = true;
        $this->initSingleton();
        $this->getConfigContent();
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
        Utils::defineIfNotExists('DEFAULT_CONTROLLER', ($this->fileExists($this->getFilePath()) ? 'EditConfig' : 'CreateConfig'));
        Utils::defineIfNotExists('DEFAULT_METHOD', 'run');

        // Use cache on Core
        define('CORE_CACHE_ENABLED', true);

        // Default number of rows per page.
        define('DEFAULT_ROWS_PER_PAGE', 25);

        // Carry Return (retorno de carro) & Line Feed (salto de línea).
        define('CRLF', "\n\t");
    }

    /**
     * Return this instance.
     *
     * @return Config
     */
    public function getInstance(): self
    {
        return $this::getInstanceTrait();
    }
}
