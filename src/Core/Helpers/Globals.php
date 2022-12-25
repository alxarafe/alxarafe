<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Core\Singletons\FlashMessages;
use Alxarafe\Core\Singletons\PhpFileCache;
use Alxarafe\Core\Singletons\Render;
use Alxarafe\Core\Singletons\Session;
use Alxarafe\Core\Singletons\Translator;

/**
 * Class Globals, load all globals utilities.
 *
 * @package Alxarafe\Core\Base
 */
class Globals
{
    /**
     * The application name
     */
    const APP_NAME = 'Alxarafe';

    /**
     * The application Version
     */
    const APP_VERSION = '2023.0-Beta';

    /**
     * GET variable used to indicate the name of the module in which to look for the controller
     */
    const MODULE_GET_VAR = 'module';

    /**
     * GET variable used to indicate the name of the controller to use
     */
    const CONTROLLER_GET_VAR = 'controller';

    /**
     * GET variable that contains the name of the module to use, if none is specified
     */
    const DEFAULT_MODULE_NAME = 'main';

    /**
     * GET variable that contains the name of the controller to use, if none is specified
     */
    const DEFAULT_CONTROLLER_NAME = 'init';

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

        define('MODULES_FOLDER', 'Modules');
    }

    public function __construct()
    {
        self::defineConstants();

        // Se carga la configuración
        new Config();
        if (!Config::loadConfig()) {
            // Si falla la carga de la configuración, es que hay que generar el archivo.
        }

        new Session();
        new FlashMessages();
        new Debug();
        new Translator();
        new Render();
        new PhpFileCache();
    }
}
