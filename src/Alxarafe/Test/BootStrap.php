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

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

define('DEBUG', false);

Kint::$enabled_mode = false;
(Config::getInstance())->loadConstants();
DebugTool::getInstance();
RegionalInfo::getInstance();
Logger::getInstance();
Container::getInstance();
Session::getInstance();
Router::getInstance();
Translator::getInstance();
CacheCore::getInstance()->getEngine();
Database::getInstance();
TemplateRender::getInstance();
FormatUtils::loadConfig();
