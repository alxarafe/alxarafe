<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;
use Alxarafe\Views\ConfigView;
use Symfony\Component\Yaml\Yaml;

/**
 * Controller for editing database and skin settings
 *
 * @package Alxarafe\Controllers
 */
class EditConfig extends Controller
{

    /**
     * The constructor creates the view
     */
    public function __construct()
    {
        parent::__construct();

        Skin::setView(new ConfigView($this));
    }

    /**
     * Main is invoked if method is not specified.
     * Check if you have to save changes or just exit
     *
     * @return void
     */
    public function main()
    {
        if (filter_input(INPUT_POST, 'cancel', FILTER_SANITIZE_ENCODED)) {
            header('Location: ' . constant('BASE_URI'));
        }

        if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_ENCODED)) {
            $this->save();
            header('Location: ' . constant('BASE_URI'));
        }
    }

    /**
     * Save the form changes in the configuration file
     *
     * @return void
     */
    private function save()
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
        $yamlData = YAML::dump($vars);
        file_put_contents($yamlFile, $yamlData);
    }
}
