<?php

require 'vendor/autoload.php';
define('BASE_PATH', __DIR__);

use Alxarafe\Infrastructure\Persistence\Template;

$template = new Template();
$template->setPaths([
    __DIR__ . '/skeleton/public/templates',
    __DIR__ . '/templates',
    __DIR__ . '/../resource-blade/templates'
]);

$exists = $template->render('component/container/tab_group');
var_dump($exists);
