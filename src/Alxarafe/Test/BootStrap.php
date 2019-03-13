<?php

use Alxarafe\Core\Base\CacheCore;
use Alxarafe\Core\BootStrap;
use Alxarafe\Core\Helpers\FormatUtils;
use Alxarafe\Core\Helpers\Session;
use Alxarafe\Core\Providers\Config;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\DebugTool;
use Alxarafe\Core\Providers\Logger;
use Alxarafe\Core\Providers\RegionalInfo;
use Alxarafe\Core\Providers\Router;
use Alxarafe\Core\Providers\TemplateRender;
use Alxarafe\Core\Providers\Translator;
use Kint\Kint;

$root = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');

require_once $root . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$configOrig = $root . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.yaml';

if (!file_exists($configOrig)) {
    die($configOrig . " not found!\n");
}

Kint::$enabled_mode = false;
$configManager = Config::getInstance();
$configManager->loadConfigConstants();
$configManager->loadConstants();
$configData = $configManager->getConfigContent();
DebugTool::getInstance();
RegionalInfo::getInstance();
Logger::getInstance();
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
new BootStrap();
