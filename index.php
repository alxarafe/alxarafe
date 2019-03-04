<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */
define('BASE_PATH', __DIR__);
define('DEBUG', true);
//define('CORE_CACHE_ENABLED', true);

$autoload = constant('BASE_PATH') . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if (file_exists($autoload)) {
    // Manage the autoload from a class
    require_once constant('BASE_PATH') . '/src/Alxarafe/Core/Autoload/Load.php';
    new \Alxarafe\Core\Autoload\Load();

    $bootStrap = new \Alxarafe\Core\BootStrap(constant('BASE_PATH'), constant('DEBUG'));
    $bootStrap->init();
} else {
    echo "You need install composer and execute 'composer install' before to start";
}