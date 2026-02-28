<?php
/**
 * Alxarafe Cache Cleaner
 * Temporary script to clear Blade cache on production server.
 */

// Basic security check - you can add a token here if needed
// if (($_GET['token'] ?? '') !== 'some_secret') { die('Unauthorized'); }

$autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
} else {
    // Fallback if vendor is not exactly where expected
    $autoload = __DIR__ . '/vendor/autoload.php';
    if (file_exists($autoload)) {
        require_once $autoload;
    }
}

$cacheDir = __DIR__ . '/../var/cache/blade';
if (!is_dir($cacheDir)) {
    // Try absolute path from server root if known
    $cacheDir = '/home/u826748402/domains/alxarafe.com/var/cache/blade';
}

echo "<h1>Alxarafe Cache Cleaner</h1>";

if (is_dir($cacheDir)) {
    echo "<p>Found cache directory: <code>$cacheDir</code></p>";
    
    // We use the framework's recursive remove if available
    if (class_exists('\\Alxarafe\\Lib\\Functions')) {
        $count = \\Alxarafe\\Lib\\Functions::recursiveRemove($cacheDir, false);
        echo "<p><strong>Success!</strong> Removed $count files/directories from cache.</p>";
    } else {
        // Simple fallback if framework classes aren't loaded
        function simpleRecursiveRemove($dir) {
            $count = 0;
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                $path = "$dir/$file";
                if (is_dir($path)) {
                    $count += simpleRecursiveRemove($path);
                    rmdir($path);
                    $count++;
                } else {
                    unlink($path);
                    $count++;
                }
            }
            return $count;
        }
        $count = simpleRecursiveRemove($cacheDir);
        echo "<p><strong>Success (Fallback)!</strong> Removed $count files from cache.</p>";
    }
} else {
    echo "<p style='color:red'>Cache directory not found at $cacheDir</p>";
    echo "<p>Current directory: " . __DIR__ . "</p>";
}

echo "<p><a href='/'>Go to Homepage</a></p>";
