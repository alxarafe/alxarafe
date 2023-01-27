<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

/**
 * Class Globals
 *
 * Carga las constantes predefinidas
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 *
 * @package Alxarafe\Core\Helpers
 */
abstract class Globals
{
    /**
     * Nombre de la aplicación
     */
    const APP_NAME = 'Alxarafe';

    /**
     * Versión de la aplicación
     */
    const APP_VERSION = '2023.0-Beta';

    /**
     * Nombre de la variable GET usada para indicar el nombre del módulo en la URL
     */
    const MODULE_GET_VAR = 'module';

    /**
     * Nombre de la variable GET usada para indicar el nombre del controlador en la URL
     */
    const CONTROLLER_GET_VAR = 'controller';

    /**
     * Valor por defecto de la variable GET 'MODULE_GET_VAR', si no se ha especificado en la URL
     */
    const DEFAULT_MODULE_NAME = 'main';

    /**
     * Valor por defecto de la variable GET 'CONTROLLER_GET_VAR', si no se ha especificado en la URL
     */
    const DEFAULT_CONTROLLER_NAME = 'init';

    /**
     * Define las constantes de la aplicación
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     */
    public static function load()
    {
        define('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        define('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME'));
        define('SERVER_PORT', filter_input(INPUT_SERVER, 'SERVER_PORT'));
        define('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME'));
        define('SITE_URL', constant('APP_PROTOCOL') . '://' . constant('SERVER_NAME'));
        define('BASE_URI', constant('SITE_URL') . constant('APP_URI'));

        define('VENDOR_URI', constant('BASE_URI') . '/vendor/');
        define('TMP_DIR', constant('BASE_DIR') . '/tmp/');

        define('CONFIGURATION_DIR', constant('BASE_DIR') . '/config/');
        define('MODULES_DIR', 'Modules');
    }
}
