<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Helpers\Utils\ClassUtils;

/**
 * Class ConfigurationManager
 *
 * @package Alxarafe\Core\Providers
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
    public function getConfigContent(): array
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
     * @return self
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Return default values
     *
     * @return array
     */
    public static function getDefaultValues(): array
    {
        // Not really needed
        return [];
    }

    /**
     * Loads some constants.
     */
    public function loadConstants(): void
    {
        /**
         * It is recommended to define BASE_PATH as the first line of the index.php file of the application.
         *
         * define('BASE_PATH', __DIR__);
         */
        ClassUtils::defineIfNotExists('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');
        ClassUtils::defineIfNotExists('LANG', 'en');
        ClassUtils::defineIfNotExists('DEBUG', false);
        ClassUtils::defineIfNotExists('CACHE', !constant('DEBUG'));

        ClassUtils::defineIfNotExists('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        ClassUtils::defineIfNotExists('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_ENCODED));
        ClassUtils::defineIfNotExists('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME', FILTER_SANITIZE_ENCODED));
        ClassUtils::defineIfNotExists('SITE_URL', constant('APP_PROTOCOL') . '://' . constant('SERVER_NAME'));
        ClassUtils::defineIfNotExists('BASE_URI', constant('SITE_URL') . constant('APP_URI'));

        $request_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $uri_length = strlen(constant('APP_URI'));
        $params = trim(substr($request_uri, $uri_length), '/');

        ClassUtils::defineIfNotExists('URL_PARAMS', explode('/', $params));

        /**
         * Must be defined in main index.php file
         */
        ClassUtils::defineIfNotExists('VENDOR_FOLDER', basePath('vendor'));
        ClassUtils::defineIfNotExists('ALXARAFE_FOLDER', basePath('src' . DIRECTORY_SEPARATOR . 'Alxarafe' . DIRECTORY_SEPARATOR . 'Core'));
        ClassUtils::defineIfNotExists('VENDOR_URI', baseUrl('vendor'));

        ClassUtils::defineIfNotExists('CONFIGURATION_PATH', basePath('config'));
        ClassUtils::defineIfNotExists('DEFAULT_STRING_LENGTH', 50);
        ClassUtils::defineIfNotExists('DEFAULT_INTEGER_SIZE', 10);

        ClassUtils::defineIfNotExists('CALL_CONTROLLER', 'call');
        ClassUtils::defineIfNotExists('METHOD_CONTROLLER', 'method');
        ClassUtils::defineIfNotExists('DEFAULT_CONTROLLER', ($this->fileExists($this->getFilePath()) ? 'EditConfig' : 'CreateConfig'));
        ClassUtils::defineIfNotExists('DEFAULT_METHOD', 'index');

        // Use cache on Core
        ClassUtils::defineIfNotExists('CORE_CACHE_ENABLED', true);

        // Default number of rows per page.
        ClassUtils::defineIfNotExists('DEFAULT_ROWS_PER_PAGE', 25);

        // Carry Return (retorno de carro) & Line Feed (salto de línea).
        ClassUtils::defineIfNotExists('CRLF', "\n\t");
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
