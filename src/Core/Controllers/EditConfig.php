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

/**
 * Class EditConfig
 *
 * @package Alxarafe\Controllers
 */
class EditConfig extends Controller
{

    public function __construct()
    {
        parent::__construct();

        Skin::setView(new ConfigView($this));
    }

    public function main()
    {
        if (isset($_POST['cancel'])) {
            header('Location: ' . BASE_URI);
        }

        if (isset($_POST['submit'])) {
            $this->save();
            header('Location: ' . BASE_URI);
        }
    }

    /**
     * TODO: Undocummented
     */
    private function save()
    {
        $vars = [];
        $vars['dbEngineName'] = $_POST['dbEngineName'] ?? '';
        $vars['skin'] = $_POST['skin'] ?? '';
        $vars['dbUser'] = $_POST['dbUser'] ?? '';
        $vars['dbPass'] = $_POST['dbPass'] ?? '';
        $vars['dbName'] = $_POST['dbName'] ?? '';
        $vars['dbHost'] = $_POST['dbHost'] ?? '';
        $vars['dbPort'] = $_POST['dbPort'] ?? '';

        $yamlFile = Config::getConfigFileName();
        $yamlData = YAML::dump($vars);
        file_put_contents($yamlFile, $yamlData);
    }
}
