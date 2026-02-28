<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

use Alxarafe\Tools\Dispatcher\WebDispatcher;
use Alxarafe\Tools\Dispatcher\ApiDispatcher;
use Alxarafe\Base\Config;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;

// Define base paths
define('BASE_PATH', __DIR__); // skeleton/public
define('BASE_URL', \Alxarafe\Lib\Functions::getUrl());
$appPath = realpath(__DIR__ . '/../');
if (!$appPath) {
    $appPath = dirname(__DIR__);
}
define('APP_PATH', $appPath); // Root of the app (skeleton)

// Resolve ALX_PATH (Framework root)
// 1. Check if we're in a combined production layout (src exists in APP_PATH)
if (is_dir($appPath . '/src/Core') || is_dir($appPath . '/vendor/alxarafe/alxarafe')) {
    define('ALX_PATH', $appPath);
} else {
    // 2. Default to relative path for development
    $alxPath = realpath(__DIR__ . '/../../');
    define('ALX_PATH', $alxPath ?: dirname($appPath));
}

// Pre-define APP_PATH for Config class to find the config.json correctly
if (!defined('APP_PATH')) {
    define('APP_PATH', realpath(__DIR__ . '/../'));
}

// Load Configuration and Initialize Services
$config = Config::getConfig();

// Temporary App Branding (User Request)
if ($config && isset($config->main)) {
    $config->main->appName = 'Alxarafe';
    $config->main->appIcon = 'fas fa-cubes';
}

// Bootstrapping
Debug::initialize();
Trans::initialize();

if ($config && isset($config->main->language)) {
    Trans::setLang($config->main->language);
}

// Check if assets are installed. If not, try to install them.
// This is useful for Docker environments where volumes might obscure built assets.
if (!is_dir(__DIR__ . '/themes') || !is_dir(__DIR__ . '/css')) {
    // Only attempt in specific environments to avoid performance hit on prod?
    // For now, check if we are in dev/local.
    if (class_exists(\Alxarafe\Scripts\ComposerScripts::class)) {
        // We'll use a mocked IO for runtime execution
        $io = new class {
            public function write($msg)
            {
                error_log("[AssetAutoPublish] " . $msg);
            }
            public function getIO()
            {
                return $this;
            }
        };

        // Wrap in a mock event
        $event = new class($io) {
            private $io;
            public function __construct($io)
            {
                $this->io = $io;
            }
            public function getIO()
            {
                return $this->io;
            }
        };

        error_log("Assets missing. Triggering auto-publication...");
        \Alxarafe\Scripts\ComposerScripts::postUpdate($event);
    }
}

// Load Routes
$routesPath = constant('APP_PATH') . '/routes.php';
$configRoutesPath = constant('APP_PATH') . '/config/routes.php';
if (file_exists($configRoutesPath)) {
    require_once $configRoutesPath;
} elseif (file_exists($routesPath)) {
    require_once $routesPath;
}

// Simple Routing
if (php_sapi_name() === 'cli') {
    $module = $argv[1] ?? 'FrameworkTest';
    $controller = $argv[2] ?? 'Test';
    $method = $argv[3] ?? 'index';
} else {
    // Try Router first, but only if no module is explicitly provided in the query string
    $match = !isset($_GET['module']) ? \Alxarafe\Lib\Router::match($_SERVER['REQUEST_URI']) : null;
    if ($match) {
        $module = $match['module'];
        $controller = $match['controller'];
        $method = $match['action'];
        // Merge params into $_GET for transparency
        $_GET = array_merge($_GET, $match['params']);
    } else {
        $module = $_GET['module'] ?? 'FrameworkTest';
        $controller = $_GET['controller'] ?? 'Test';
        $method = $_GET['method'] ?? 'index';
    }
}

try {
    WebDispatcher::run($module, $controller, $method);
} catch (Throwable $e) {
    if (class_exists(\CoreModules\Admin\Controller\ErrorController::class) && !headers_sent()) {
        $trace = $e->getTraceAsString();
        $url = \CoreModules\Admin\Controller\ErrorController::url(true, false) . '&message=' . urlencode($e->getMessage()) . '&trace=' . urlencode($trace);
        \Alxarafe\Lib\Functions::httpRedirect($url);
    }

    echo "<h1>Error Fatal en la Aplicación</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
