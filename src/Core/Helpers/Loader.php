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
use Alxarafe\Database\YamlSchema;
use Alxarafe\Database\Schema;

/**
 * Class Loader, load all globals utilities.
 *
 * @package Alxarafe\Core\Base
 */

/**
 * Class Loader
 *
 * Inicializa las clases globales
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 * @version 2023.0115
 *
 * @package Alxarafe\Core\Helpers
 */
class Loader
{
    /**
     * Constructor de Loader
     *
     * @throws \DebugBar\DebugBarException
     */
    public function __construct()
    {
        new Globals();
        new Config();
        new Session();
        new FlashMessages();
        new RegionalInfo();
        new Logger();
        new Debug();
        new Translator();
        new Render();
        new PhpFileCache();

        if (!Config::connectToDatabase()) {
            FlashMessages::setError(Translator::trans('database-connection-error'));
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
