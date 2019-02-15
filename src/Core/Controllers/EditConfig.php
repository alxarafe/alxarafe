<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\PageController;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;
use Alxarafe\PreProcessors;
use Alxarafe\Views\EditConfigView;
use Symfony\Component\Yaml\Yaml;

/**
 * Controller for editing database and skin settings.
 *
 * @package Alxarafe\Controllers
 */
class EditConfig extends PageController
{
    /**
     * @var array
     */
    protected $searchDir;

    /**
     * The constructor creates the view.
     */
    public function __construct()
    {
        parent::__construct();
        $this->searchDir = [
            'Alxarafe' => constant('ALXARAFE_FOLDER'),
        ];
    }

    /**
     * Start point
     *
     * @return void
     */
    public function index(): void
    {
        parent::index();
        Skin::setView(new EditConfigView($this));
    }

    /**
     * Main is invoked if method is not specified. Check if you have to save changes or just exit.
     *
     * @return void
     */
    public function main(): void
    {
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_ENCODED);
        switch ($action) {
            case 'clear-cache':
                Config::$cacheEngine->clear();
                Config::setInfo('Cache cleared successfully.');
                break;
            case 'regenerate-data':
                Config::$cacheEngine->clear();
                Config::setInfo('Cache cleared successfully.');

                $this->regenerateData();
                break;
            case 'save':
                $msg = ($this->save() ? 'Changes stored' : 'Changes not stored');
                Config::setInfo($msg);
                // The database or prefix may have been changed and have to be regenerated.
                Config::$cacheEngine->clear();
                $this->userAuth->logout();
                break;
            case 'cancel':
            default:
                header('Location: ' . constant('BASE_URI') . '/index.php');
                break;
        }
    }

    /**
     * The start point of the controller.
     *
     * @return void
     */
    public function run(): void
    {
        $this->index();
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
        $vars['language'] = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_ENCODED);
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
            //'menu' => 'admin|edit-config',
            'menu' => 'admin',
        ];
        return $details;
    }

    /**
     * Regenerate some needed data.
     *
     * @return void
     */
    private function regenerateData(): void
    {
        if (!set_time_limit(0)) {
            Config::setError('cant-increase-time-limit');
        }

        new PreProcessors\Models($this->searchDir);
        new PreProcessors\Pages($this->searchDir);
    }
}
