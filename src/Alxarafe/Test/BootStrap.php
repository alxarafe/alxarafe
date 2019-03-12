<?php

use Alxarafe\Core\Base\CacheCore;
use Alxarafe\Core\Helpers\FormatUtils;
use Alxarafe\Core\Helpers\Session;
use Alxarafe\Core\Providers\Config;
use Alxarafe\Core\Providers\Container;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\DebugTool;
use Alxarafe\Core\Providers\Logger;
use Alxarafe\Core\Providers\RegionalInfo;
use Alxarafe\Core\Providers\Router;
use Alxarafe\Core\Providers\TemplateRender;
use Alxarafe\Core\Providers\Translator;
use Kint\Kint;

$root = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

require_once $root . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

define('DEBUG', false);

$configOrig = $root . 'config' . DIRECTORY_SEPARATOR . 'config.yaml';

if (strpos(__DIR__, '/home/scrutinizer') !== false) {
    $config = $root . 'config' . DIRECTORY_SEPARATOR . 'config-scrutinizer.yaml';
    copy($config, $configOrig);
} elseif (strpos(__DIR__, '/home/travis') !== false) {
    $config = $root . 'config' . DIRECTORY_SEPARATOR . 'config-travis.yaml';
    copy($config, $configOrig);
} elseif (!file_exists($configOrig)) {
    die($configOrig . " not found!\n");
}

Kint::$enabled_mode = false;
$configManager = Config::getInstance();
$configManager->loadConstants();
$configData = $configManager->getConfigContent();
DebugTool::getInstance();
RegionalInfo::getInstance();
Logger::getInstance();
Container::getInstance();
Session::getInstance();
Router::getInstance();
Translator::getInstance();
CacheCore::getInstance()->getEngine();
$configData = $configManager->getConfigContent();
if (!empty($configData)) {
    $database = Database::getInstance();
    $database->connectToDatabase();
}
TemplateRender::getInstance();
FormatUtils::loadConfig();
