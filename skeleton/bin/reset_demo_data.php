#!/usr/bin/env php
<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * Reset demo data for alxarafe.com
 *
 * This script truncates all Agenda tables and re-seeds them with demo data.
 * It also ensures the admin and user accounts exist.
 *
 * Intended to be run via cron every 30 minutes.
 */

// Resolve paths
$baseDir = realpath(__DIR__ . '/..');
$rootDir = realpath($baseDir . '/..');

// Load autoloader
require_once $rootDir . '/vendor/autoload.php';

// Define constants
if (!defined('APP_PATH')) {
    define('APP_PATH', $baseDir);
}
if (!defined('BASE_PATH')) {
    define('BASE_PATH', $baseDir . '/public');
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}
if (!defined('ALX_PATH')) {
    define('ALX_PATH', $rootDir);
}

use Alxarafe\Base\Config;
use Alxarafe\Base\Database;
use Alxarafe\Lib\Messages;
use Illuminate\Database\Capsule\Manager as DB;

echo "=== Alxarafe Demo Data Reset ===\n";
echo date('Y-m-d H:i:s') . "\n\n";

// Load configuration
$config = Config::getConfig();
if (!$config || empty($config->db)) {
    echo "ERROR: No config found. Cannot reset data.\n";
    exit(1);
}

// Initialize database connection
try {
    new Database($config->db);
} catch (\Exception $e) {
    echo "ERROR: Cannot connect to database: " . $e->getMessage() . "\n";
    exit(1);
}

try {
    // Disable foreign key checks for clean truncation
    DB::statement('SET FOREIGN_KEY_CHECKS = 0');

    // 1. Truncate Agenda tables (in order)
    $tables = [
        'contact_contact_channel',
        'address_contact',
        'contact_channels',
        'addresses',
        'contacts',
    ];

    foreach ($tables as $table) {
        if (DB::schema()->hasTable($table)) {
            DB::table($table)->truncate();
            echo "  ✓ Truncated: $table\n";
        } else {
            echo "  ⚠ Table not found (skipped): $table\n";
        }
    }

    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    echo "\n--- Re-seeding data ---\n\n";

    // 2. Re-seed contact channels (master data)
    echo "Seeding ContactChannelSeeder...\n";
    new \Modules\Agenda\Seeders\ContactChannelSeeder();
    echo "  ✓ ContactChannelSeeder completed.\n";

    // 3. Re-seed demo contacts
    echo "Seeding AgendaSeeder...\n";
    new \Modules\Agenda\Seeders\AgendaSeeder();
    echo "  ✓ AgendaSeeder completed.\n";

    // 4. Ensure admin and user accounts exist
    echo "Seeding UserSeeder...\n";
    new \CoreModules\Admin\Seeders\UserSeeder();
    echo "  ✓ UserSeeder completed.\n";

    echo "\n=== Demo data reset completed successfully! ===\n";
} catch (\Exception $e) {
    DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    echo "\nERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
