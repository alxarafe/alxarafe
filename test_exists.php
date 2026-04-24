<?php

require 'vendor/autoload.php';
define('BASE_PATH', __DIR__);
define('ALX_PATH', __DIR__);

use Alxarafe\Infrastructure\Component\ComponentRenderer;
use Alxarafe\ResourceController\Component\Container\TabGroup;

$tabGroup = new TabGroup([
    new \Alxarafe\ResourceController\Component\Container\Tab('test', 'test', 'test', [])
]);

$viewName = \Alxarafe\ResourceBlade\ViewHelper::getViewName($tabGroup);
echo "View name from ViewHelper: " . $viewName . "\n";

// Emulate ComponentRenderer setup
$template = new \Alxarafe\Infrastructure\Persistence\Template();
$template->addPath(__DIR__ . '/templates');
// Path to other templates if needed

// Force Blade init
$template->render('dummy_view_just_to_init');

// Reflection to get $blade
$ref = new ReflectionClass($template);
$prop = $ref->getProperty('blade');
$prop->setAccessible(true);
$blade = $prop->getValue($template);

$exists = $blade->exists($viewName);
echo "Blade exists(" . $viewName . "): " . ($exists ? "TRUE" : "FALSE") . "\n";

// Check Finder paths
$finder = $blade->compiler()->getContainer()->make('view.finder');
echo "Finder paths: \n";
print_r($finder->getPaths());
