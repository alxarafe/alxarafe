<?php
require 'vendor/autoload.php';

define('BASE_PATH', __DIR__ . '/skeleton/public');
define('APP_PATH', __DIR__);
define('ALX_PATH', __DIR__);

$controller = new \Modules\Admin\Controller\ErrorController('index');
$controller->initViewTrait();

// Get the paths in the Template object
$ref = new ReflectionClass($controller->template);
$prop = $ref->getProperty('paths');
$prop->setAccessible(true);
$paths = $prop->getValue($controller->template);
echo "Template paths:\n";
print_r($paths);

try {
    $out = $controller->render('page/error');
    echo "Render successful.\n";
} catch (\Exception $e) {
    echo "Render failed:\n";
    echo $e->getMessage() . "\n";
    
    // Check finder paths
    $bladeContainer = \Illuminate\Container\Container::getInstance();
    $finder = $bladeContainer->make('view.finder');
    echo "Finder paths:\n";
    print_r($finder->getPaths());
}
