<?php

require 'vendor/autoload.php';
define('BASE_PATH', __DIR__);
define('ALX_PATH', __DIR__);

use Alxarafe\Infrastructure\Component\ComponentRenderer;
use Alxarafe\ResourceController\Component\Container\TabGroup;

$tabGroup = new TabGroup([
    new \Alxarafe\ResourceController\Component\Container\Tab('test', 'test', 'test', [])
]);

try {
    $out = ComponentRenderer::render($tabGroup);
    echo "RENDER SUCCESS\n";
} catch (\Exception $e) {
    echo "RENDER EXCEPTION: " . $e->getMessage() . "\n";
}
