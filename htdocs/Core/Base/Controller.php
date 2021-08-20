<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Database\Engine;
use Alxarafe\Database\SqlHelper;
use DebugBar\DebugBarException;

/**
 * Class Controller
 *
 * @package Alxarafe\Base
 */
abstract class Controller extends Globals
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
     * Indicates whether the closing of the browser is protected
     * against accidental exit or closing
     *
     * @var bool
     */
    public bool $protectedClose;

    /**
     * Contains the action to execute or null if there is no action
     *
     * @var string|null
     */
    public ?string $action;

    /**
     * It contains an instance of the view class, or null if it is
     * not assigned, or does not have an associated view.
     *
     * @var View
     */
    public View $view;

    /**
     * Controller constructor.
     *
     * @throws DebugBarException
     */
    public function __construct()
    {
        parent::__construct();

        $this->preLoad();
    }

    /**
     * Initialization of variables required for all controllers
     *
     * @throws DebugBarException
     */
    public function preLoad()
    {
        $this->config->loadConfig();
        $this->config->connectToDatabase();

        self::$engine = $this->config->getEngine();
        self::$sqlHelper = $this->config->getSqlHelper();

        $this->protectedClose = false;
        $this->action = filter_input(INPUT_POST, 'action', FILTER_DEFAULT);

        // TODO: This will have to be assigned in a yaml file, when activating and deactivating modules.
        $this->translator->addDirs([
            constant('BASE_FOLDER') . '/Modules/Main',
        ]);
    }

    /**
     * Returns an url to access to any controller of a specific module
     *
     * @param $module
     * @param $controller
     *
     * @return string
     */
    public function url($module, $controller): string
    {
        return BASE_URI . '?' . self::MODULE_GET_VAR . '=' . $module . '&' . self::CONTROLLER_GET_VAR . '=' . $controller;
    }

    /**
     * Main is the entry point (execution) of the controller.
     */
    public function main()
    {
        if (isset($this->action)) {
            $this->doAction();
        }
        $this->view = $this->setView();
    }

    /**
     * Executes any action
     */
    public function doAction()
    {
        switch ($this->action) {
            case 'save':
                $this->doSave();
                break;
            case 'exit':
                $this->doExit();
                break;
            default:
                trigger_error("The '$this->action' action has not been defined!");
        }
    }

    /**
     * Execute the Save action (overwrite it, if necessary!)
     */
    public function doSave()
    {
    }

    /**
     * Exit to the main route
     */
    public function doExit()
    {
        header('Location: ' . BASE_URI);
        die();
    }

    /**
     * Return an instance to the corresponding View class
     *
     * @return View
     */
    abstract public function setView(): View;

    /**
     * ¿Not used?
     *
     * @param $string
     *
     * @return string
     * @deprecated Not used?
     */
    public function getResource($string): string
    {
        return $this->render->getResource($string);
    }

}
