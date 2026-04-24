<?php
// Mocking index.php environment
$_SERVER['REQUEST_URI'] = '/index.php?module=Admin&controller=Error';
$_GET['module'] = 'Admin';
$_GET['controller'] = 'Error';

$baseAppPath = __DIR__ . '/skeleton/public/../';
$appPath = realpath($baseAppPath) ?: dirname(__DIR__ . '/skeleton/public');
define('APP_PATH', $appPath); // Root of the app

if (is_dir(constant('APP_PATH') . '/src/Core')) {
    define('ALX_PATH', constant('APP_PATH'));
} elseif (is_dir(constant('APP_PATH') . '/../src/Core')) {
    $alxPath = realpath(constant('APP_PATH') . '/..');
    define('ALX_PATH', $alxPath ?: dirname(constant('APP_PATH')));
} else {
    $alxPath = realpath(constant('APP_PATH') . '/../');
    define('ALX_PATH', $alxPath ?: dirname(constant('APP_PATH')));
}

echo "APP_PATH: " . APP_PATH . "\n";
echo "ALX_PATH: " . ALX_PATH . "\n";
