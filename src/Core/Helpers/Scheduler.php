<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use Alxarafe\Base\View;
use Alxarafe\Controllers\EditConfig;

class Scheduler
{

    public function __construct()
    {
        $this->getConfiguration();
        $user = Config::$user->getUser();
        if ($user == null) {
            if (isset($_POST['username'])) {
                Config::$user->setUser($_POST['username'], $_POST['password']);
            }
            $user = Config::$user->getUser();
            if ($user == null) {
                Config::$user->login();
                return;
            }
        }
        if (isset($_GET['logout'])) {
            unset($_GET['logout']);
            Config::$user->logout();
            // TODO: Ver si hay mejor forma de hacerlo
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        $call = $_POST['call'] ?? 'index';

        (new EditConfig())->run();
    }

    private function getConfiguration()
    {
        $configFile = Config::getConfigurationFile();
        if (!file_exists($configFile)) {
            //echo "<p>Creating <strong>$configFile</strong>...</p>";
            /**
             * These are the default values.
             * It is not necessary to define them, if we are going to use these.
             */
            Config::setVar('templateEngine', 'twig');
            Config::setVar('templatesFolder', 'default');
            Config::setVar('commonTemplatesFolder', BASE_PATH . 'views/common/');

            /**
             * Database configuration parameters
             */
            Config::setVar('dbEngine', 'PdoMySql');
            Config::setVar('dbUser', 'root');
            Config::setVar('dbPass', '');
            Config::setVar('dbName', 'xfs');
            Config::setVar('dbHost', '');
            Config::setVar('dbPort', '');

            Config::saveConfigFile();
        }
        Config::loadConfig();

        /*
          echo "<p>The configuration of the <strong>$configFile</strong> file has been loaded...</p>";
          echo '<pre>' . file_get_contents($configFile) . '</pre>';
          echo '<p>This file contains the configuration of the database.</p>';
          echo '<p>If the file is not correct, delete it and it will be created again.</p>';
         */
    }

    static function run()
    {
        return;

        Debug::testArray('User', Config::$user);

        require_once 'Models\Person.php';

        $people = new Person();

// Load the record with id=3 in the active record, and display it
        Debug::testArray('Data of record with id=3', $people->getDataArray(3), true);
        echo '<p>Age modified but not saved! (using setter)</p>';
        $people->setAge(60);
        Debug::testArray('Data of record with id=3', $people->getDataArray(), true);
        echo '<p>Name modified but not saved! (assigning a value)</p>';
        $people->name = 'Another name for 3';
        Debug::testArray('Data of record with id=3', $people->getDataArray(), true);
        echo '<p>When loading the record with id = 2, unsaved changes are lost.</p>';
        $people->load(2);
        Debug::testArray('Data of record with id=2', $people->getDataArray(), true);
        $people->load(3);
        Debug::testArray('Data of record with id=3', $people->getDataArray(), true);
        $people->age = 50;
        $people->setName('John Smith');
        $people->save();
        Debug::testArray('Data of record with id=3', $people->getDataArray(), true);
        $people->load(2);
        Debug::testArray('Data of record with id=2', $people->getDataArray(), true);
        $people->load(3);
        Debug::testArray('Data of record with id=3', $people->getDataArray(), true);

        echo '<p>Lo dejamos como estaba</p>';
        $people->age = 21;
        $people->name = 'Person 3';
        $people->save();

        $vars['title'] = 'Título';
        $view = new View();
        $view->run($vars);
    }
}
