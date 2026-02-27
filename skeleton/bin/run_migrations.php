<?php
define('APP_PATH', realpath(__DIR__ . '/../'));
define('ALX_PATH', realpath(__DIR__ . '/../../'));
define('BASE_PATH', APP_PATH . '/public');
require_once APP_PATH . '/vendor/autoload.php';

use Alxarafe\Base\Config;
use Alxarafe\Lib\Messages;

echo "--- Starting Migration Process ---\n";

// Initialize Config
$config = Config::getConfig();
if (!$config) {
    die("CRITICAL: Configuration file not loaded.\n");
}

echo "Database: " . ($config->db->name ?? 'Unknown') . "\n";

// Run Migrations
if (Config::doRunMigrations()) {
    echo "SUCCESS: Migrations executed.\n";
} else {
    echo "ERROR: Migration failed.\n";
    print_r(Messages::getMessages());
}
