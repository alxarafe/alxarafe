<?php

require __DIR__ . '/../vendor/autoload.php';

use Alxarafe\Tools\Dispatcher\WebDispatcher;
use Alxarafe\Tools\Dispatcher\ApiDispatcher;
use Alxarafe\Base\Config;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;

// Define base paths
define('BASE_PATH', __DIR__); // skeleton/public
define('BASE_URL', 'http://localhost:8081');
define('ALX_PATH', realpath(__DIR__ . '/../../')); // Root of the repo (framework)
define('APP_PATH', realpath(__DIR__ . '/../'));    // Root of the app (skeleton)

// Load Configuration and Initialize Services
$config = Config::getConfig();

// Bootstrapping
Debug::initialize();
Trans::initialize();

if ($config && isset($config->main->language)) {
    Trans::setLang($config->main->language);
}

// Simple Routing for Demo
$module = $_GET['module'] ?? 'Demo';
$controller = $_GET['controller'] ?? 'Home';
$method = $_GET['method'] ?? 'index';

try {
    WebDispatcher::run($module, $controller, $method);
} catch (Throwable $e) {
    echo "<h1>Error Fatal en la Aplicación</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
