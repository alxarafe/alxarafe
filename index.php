<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */
define('BASE_PATH', __DIR__);
define('DEBUG', true);

$autoload = constant('BASE_PATH') . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if (file_exists($autoload)) {
    require_once $autoload;

    $bootStrap = new \Alxarafe\BootStrap(constant('BASE_PATH'), constant('DEBUG'));
    $bootStrap->init();
} else {
    echo "You need install composer and execute 'composer install' before to start";
}