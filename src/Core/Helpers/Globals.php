<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Controllers\EditConfig;
use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Core\Singletons\FlashMessages;
use Alxarafe\Core\Singletons\Logger;
use Alxarafe\Core\Singletons\PhpFileCache;
use Alxarafe\Core\Singletons\RegionalInfo;
use Alxarafe\Core\Singletons\Render;
use Alxarafe\Core\Singletons\Session;
use Alxarafe\Core\Singletons\Translator;
use Alxarafe\Database\DB;
use Alxarafe\Database\Schema;
use Alxarafe\Database\YamlSchema;

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
        define('TMP_DIR', BASE_DIR . '/tmp/');

        define('CONFIGURATION_DIR', BASE_DIR . '/config/');
        define('DEFAULT_STRING_LENGTH', 50);
        define('DEFAULT_INTEGER_SIZE', 10);

        define('MODULES_DIR', 'Modules');
    }

    public function __construct()
    {
        self::defineConstants();

        new Session();
        new FlashMessages();
        new RegionalInfo();
        new Logger();
        new Debug();
        new Translator();
        new Render();
        new PhpFileCache();

        new Config();
        if (!Config::loadConfig() || !Config::connectToDatabase()) {
            // Si falla la carga de la configuración, es que hay que generar el archivo.
            $run = new EditConfig();
            $run->main();
            die();
        }

        // TODO: Sólo debería de limpiarse caché al activar y desactivar un plugin, o a demanda.
        //       Pero en modo de depuración, debería de limpiarse para actualizar los cambios en las tablas.
        if (!YamlSchema::clearYamlCache()) {
            die('No se ha podido eliminar la caché');
        }
        Schema::checkDatabaseStructure();
    }
}
