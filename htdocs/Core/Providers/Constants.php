<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Base\Provider;
use Symfony\Component\Yaml\Yaml;

/**
 * Class RegionalInfo
 *
 * @package Alxarafe\Core\Providers
 */
class Constants extends Provider
{
    public static ?string $configFilename;

    public function __construct()
    {
        parent::__construct();

        self::$configFilename = self::getConfigFileName();
    }

    /**
     * Returns the name of the configuration file. By default, create the config
     * folder and enter the config.yaml file inside it.
     * If you want to use another folder for the configuration, you will have to
     * define it in the constant CONFIGURATION_PATH before invoking this method,
     * this folder must exist.
     *
     * @return string|null
     */
    public static function getConfigFileName(): ?string
    {
        if (isset(self::$configFilename)) {
            return self::$configFilename;
        }
        $filename = constant('CONFIGURATION_PATH') . '/config.yaml';
        if (file_exists($filename) || is_dir(constant('CONFIGURATION_PATH')) || mkdir(constant('CONFIGURATION_PATH'), 0777, true)) {
            self::$configFilename = $filename;
        }
        return self::$configFilename;
    }

    /**
     * Define the constants of the application
     */
    public static function defineConstants()
    {
        define('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        define('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME'));
        define('SERVER_PORT', filter_input(INPUT_SERVER, 'SERVER_PORT'));
        define('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME'));
        define('SITE_URL', APP_PROTOCOL . '://' . SERVER_NAME);
        define('BASE_URI', SITE_URL . APP_URI);

        define('VENDOR_URI', BASE_URI . '/vendor/');

        define('CONFIGURATION_PATH', BASE_FOLDER . '/config');
        define('DEFAULT_STRING_LENGTH', 50);
        define('DEFAULT_INTEGER_SIZE', 10);
    }

    /**
     * Loads the constants defined in the config.yaml file
     *
     * @return void
     */
    public static function loadConstants(): void
    {
        self::$configFilename = self::getConfigFileName();
        $configFileContent = Yaml::parseFile(self::$configFilename);
        if (!empty($configFileContent) && isset($configFileContent['constants'])) {
            foreach ($configFileContent['constants'] as $type => $data) {
                foreach ($data as $name => $value) {
                    if (!defined($name)) {
                        switch (strtolower($type)) {
                            case 'boolean':
                                define($name, boolval($value));
                                break;
                            case 'integer':
                                define($name, intval($value));
                                break;
                            case 'float':
                            case 'real':
                            case 'numeric':
                                define($name, floatval($value));
                                break;
                            default:
                                define($name, $value);
                        }
                    }
                }
            }
        }
    }

    /**
     * Return default values
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        return [
        ];
    }
}