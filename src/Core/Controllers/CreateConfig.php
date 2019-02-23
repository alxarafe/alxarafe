<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\SimpleController;
use Alxarafe\Helpers\Config;
use Alxarafe\Providers\FlashMessages;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

/**
 * Controller for editing database and skin settings.
 *
 * @package Alxarafe\Controllers
 */
class CreateConfig extends SimpleController
{

    /**
     * CreateConfig constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Main is invoked if method is not specified. Check if you have to save changes or just exit.
     *
     * @return Response
     */
    public function main(): Response
    {
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_ENCODED);
        switch ($action) {
            case 'save':
                $msg = ($this->save() ? 'Changes stored' : 'Changes not stored');
                $this->debugTool->addMessage('messages', $msg);
                FlashMessages::getInstance()::setInfo($msg);
                return $this->redirect(baseUrl('index.php'));
                break;
            case 'cancel':
                return $this->redirect(baseUrl('index.php'));
                break;
        }
        return $this->sendResponseTemplate();
    }

    /**
     * Save the form changes in the configuration file
     *
     * @return bool
     */
    private function save(): bool
    {
        $vars = [];
        $vars['dbEngineName'] = filter_input(INPUT_POST, 'dbEngineName', FILTER_SANITIZE_ENCODED);
        $vars['dbPrefix'] = filter_input(INPUT_POST, 'dbPrefix', FILTER_SANITIZE_ENCODED);
        $vars['skin'] = filter_input(INPUT_POST, 'skin', FILTER_SANITIZE_ENCODED);
        $vars['dbUser'] = filter_input(INPUT_POST, 'dbUser', FILTER_SANITIZE_ENCODED);
        $vars['dbPass'] = filter_input(INPUT_POST, 'dbPass', FILTER_SANITIZE_ENCODED);
        $vars['dbName'] = filter_input(INPUT_POST, 'dbName', FILTER_SANITIZE_ENCODED);
        $vars['dbHost'] = filter_input(INPUT_POST, 'dbHost', FILTER_SANITIZE_ENCODED);
        $vars['dbPort'] = filter_input(INPUT_POST, 'dbPort', FILTER_SANITIZE_ENCODED);

        $yamlFile = Config::getConfigFileName();
        $yamlData = Yaml::dump($vars);
        return (bool) file_put_contents($yamlFile, $yamlData);
    }

    /**
     * The start point of the controller.
     *
     * @return Response
     */
    public function indexMethod(): Response
    {
        return $this->index();
    }

    /**
     * Start point
     *
     * @return Response
     */
    public function index(): Response
    {
        parent::index();
        if (Config::configFileExists()) {
            return $this->redirect(baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=Login'));
        }
        $this->renderer->setTemplate('createconfig');
        return $this->sendResponseTemplate();
    }

    /**.
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'edit-configuration',
            'icon' => '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>',
            'description' => 'edit-configuration-description',
            'menu' => 'admin|edit-config',
        ];
        return $details;
    }
}
