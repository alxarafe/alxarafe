<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;
use Alxarafe\Database\Engine;
use Symfony\Component\Yaml\Yaml;

class EditConfig extends Controller
{

    public function __construct()
    {
        Skin::setTemplate('dbconfig');

        parent::__construct();

        $dbEngines = Engine::getEngines();

        $yaml = file_get_contents(Config::getConfigurationFile());
        if ($yaml == true) {
            $vars = YAML::parse($yaml);
        }

        $this->vars['dbEngines'] = $dbEngines;
        $this->vars['dbEngineName'] = $this->vars['dbEngineName'] ?? $dbEngines[0] ?? '';
        $this->vars['dbConfig']['dbUser'] = $vars['dbUser'] ?? 'root';
        $this->vars['dbConfig']['dbPass'] = $vars['dbPass'] ?? '';
        $this->vars['dbConfig']['dbName'] = $vars['dbName'] ?? 'alxarafe';
        $this->vars['dbConfig']['dbHost'] = $vars['dbHost'] ?? 'localhost';
        $this->vars['dbConfig']['dbPort'] = $vars['dbPort'] ?? '';

        if (isset($_POST['cancel'])) {
            header('Location: ' . BASE_URI);
        }
        if (isset($_POST['submit'])) {
            $this->save();
            header('Location: ' . BASE_URI);
        }
    }

    function save()
    {
        $vars['dbEngineName'] = $_POST['dbEngineName'] ?? '';
        $vars['dbUser'] = $_POST['dbUser'] ?? '';
        $vars['dbPass'] = $_POST['dbPass'] ?? '';
        $vars['dbName'] = $_POST['dbName'] ?? '';
        $vars['dbHost'] = $_POST['dbHost'] ?? '';
        $vars['dbPort'] = $_POST['dbPort'] ?? '';

        $yamlFile = Config::getConfigurationFile();
        $yamlData = YAML::dump($vars);
        file_put_contents($yamlFile, $yamlData);
    }
}
