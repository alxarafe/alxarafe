<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\Translator;
use Alxarafe\Database\Engine;
use Alxarafe\Database\SqlHelper;
use DebugBar\DebugBarException;

/**
 * Class Controller
 *
 * The controller is who responds to the various events.
 *
 * @package Alxarafe\Core\Base
 */
abstract class Controller extends BasicController
{
    /**
     * The database engine.
     *
     * @var Engine
     */
    public static Engine $engine;

    /**
     * The database SQL Helper.
     *
     * @var SqlHelper
     */
    public static SqlHelper $sqlHelper;

    /**
     * It contains an instance of the view class, or null if it is
     * not assigned, or does not have an associated view.
     *
     * @var View
     */
    public View $view;

    public function __construct()
    {
        parent::__construct();

        $this->hasMenu = true;
    }

    /**
     * Initialization of variables required for all controllers
     *
     * @return bool
     * @throws DebugBarException
     */
    public function preLoad(): bool
    {
        if (!parent::preLoad() || /* !$this->configExists || */ !Config::connectToDatabaseAndAuth()) {
            return false;
        }

        self::$engine = Config::getEngine();
        self::$sqlHelper = Config::getSqlHelper();

        $this->action = filter_input(INPUT_POST, 'action', FILTER_DEFAULT);

        // TODO: This will have to be assigned in a yaml file, when activating and deactivating modules.
//        Translator::addDirs([
//            constant('BASE_FOLDER'),
//        ]);

        return true;
    }
}
