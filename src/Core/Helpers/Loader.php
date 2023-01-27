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
use Alxarafe\Core\Singletons\Translator;
use Alxarafe\Database\DB;
use Alxarafe\Database\YamlSchema;
use Alxarafe\Database\Schema;

/**
 * Class Loader
 *
 * Inicializa las clases globales
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 *
 * @package Alxarafe\Core\Helpers
 */
abstract class Loader
{
    /**
     * Inicializa todas las clases necesarias para que el núcleo funcione
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @throws \DebugBar\DebugBarException
     */
    public static function load()
    {
        Globals::load();
        Config::load();
        FlashMessages::load();
        RegionalInfo::load();
        Logger::load();
        Debug::load();
        Translator::load();
        Render::load();
        PhpFileCache::load();

        if (!DB::connectToDatabase()) {
            FlashMessages::setError(Translator::trans('database-connection-error'));
            $run = new EditConfig();
            $run->main();
            die();
        }

        if (!YamlSchema::clearYamlCache()) {
            die('No se ha podido eliminar la caché');
        }
        Schema::checkDatabaseStructure();
    }
}
