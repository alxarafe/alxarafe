<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

define('BASE_PATH', __DIR__);

$autoload = constant('BASE_PATH') . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if (file_exists($autoload)) {
    require_once $autoload;

    $bootStrap = new \Alxarafe\BootStrap(constant('BASE_PATH'), true);
    $bootStrap->init();
} else {
    echo "You need to execute 'composer install' before to start";
}