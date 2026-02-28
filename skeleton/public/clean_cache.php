<?php

/**
 * Alxarafe Cache Cleaner & Path Debugger
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<h1>Alxarafe Path Debugger & Cache Cleaner</h1>";

$scriptPath = $_SERVER['SCRIPT_FILENAME'] ?? __FILE__;
$basePath = dirname($scriptPath);
$appPath = realpath($basePath . '/../');

echo "<ul>";
echo "<li><strong>SCRIPT_FILENAME:</strong> " . htmlspecialchars($scriptPath) . "</li>";
echo "<li><strong>Calculated BASE_PATH:</strong> " . htmlspecialchars($basePath) . "</li>";
echo "<li><strong>Calculated APP_PATH:</strong> " . htmlspecialchars($appPath) . "</li>";
echo "</ul>";

$autoload = $appPath . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    // Try one more level up if it's weird
    $autoload = realpath($appPath . '/../vendor/autoload.php');
}

if ($autoload && file_exists($autoload)) {
    echo "<p>Autoload found at: <code>$autoload</code></p>";
    require_once $autoload;
} else {
    echo "<p style='color:red'>Autoload NOT found. Tried: <code>$appPath/vendor/autoload.php</code></p>";
}

$cacheDir = $appPath . '/var/cache/blade';
if (is_dir($cacheDir)) {
    echo "<p>Found cache directory: <code>$cacheDir</code></p>";

    // Simple fallback if framework classes aren't loaded
    function simpleRecursiveRemove($dir)
    {
        $count = 0;
        if (!is_dir($dir)) return 0;
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $path = "$dir/$file";
            if (is_dir($path) && !is_link($path)) {
                $count += simpleRecursiveRemove($path);
                if (@rmdir($path)) $count++;
            } else {
                if (@unlink($path)) $count++;
            }
        }
        return $count;
    }

    if (class_exists('Alxarafe\Lib\Functions')) {
        $count = \Alxarafe\Lib\Functions::recursiveRemove($cacheDir, false);
        echo "<p><strong>Success!</strong> Removed $count files/directories from cache using Framework.</p>";
    } else {
        $count = simpleRecursiveRemove($cacheDir);
        echo "<p><strong>Success!</strong> Removed $count files from cache using Fallback.</p>";
    }
} else {
    echo "<p style='color:red'>Cache directory not found at: <code>$cacheDir</code></p>";
}

echo "<h2>File Search for RoleController.php</h2>";
$cmd = "find " . escapeshellarg($appPath) . " -name RoleController.php";
$output = [];
exec($cmd, $output);
if (!empty($output)) {
    echo "<ul>";
    foreach ($output as $file) {
        echo "<li>Found: <code>$file</code></li>";
    }
    echo "</ul>";
} else {
    echo "<p>No duplicate RoleController.php found with find command. Trying PHP glob...</p>";
    $files = glob($appPath . "/**/RoleController.php");
    if ($files) {
        foreach ($files as $file) echo "<li>Found (glob): <code>$file</code></li>";
    } else {
        echo "<p>No files found with glob either.</p>";
    }
}

echo "<hr><p><a href='/'>Go to Homepage</a></p>";
