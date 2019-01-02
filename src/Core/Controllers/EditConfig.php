<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Database\Engine;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;
use Symfony\Component\Yaml\Yaml;

/**
 * Class EditConfig
 *
 * @package Alxarafe\Controllers
 */
class EditConfig extends Controller
{

    /**
     * EditConfig constructor.
     */
    public function __construct()
    {
        Skin::setTemplate('config');

        parent::__construct();

        $vars = Config::configFileExists() ? Config::loadConfigurationFile() : [];

        $this->vars = [];
        $this->vars['dbEngines'] = Engine::getEngines();
        $this->vars['skins'] = Skin::getSkins();

        $this->vars['dbEngineName'] = $vars['dbEngineName'] ?? $this->vars['dbEngines'][0] ?? '';
        $this->vars['skin'] = $vars['skin'] ?? $this->vars['skins'][0] ?? '';
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

    /**
     * TODO: Undocummented
     */
    public function save()
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
