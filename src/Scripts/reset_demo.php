<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace Alxarafe\Scripts;

/**
 * Reset Demo Script.
 * Use this to completely reset the Alxarafe database to a clean demo state.
 * It will drop all tables, run migrations, and execute all seeders.
 * 
 * CRON Usage (example): 0 0 * * * php /path/to/alxarafe/src/Scripts/reset_demo.php
 */

require __DIR__ . '/../../vendor/autoload.php';

use Alxarafe\Base\Config;
use Alxarafe\Base\Database;
use Alxarafe\Lib\Trans;

// Define base paths if not already defined (CLI execution)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', realpath(__DIR__ . '/../../skeleton/public'));
}
if (!defined('APP_PATH')) {
    define('APP_PATH', realpath(__DIR__ . '/../../skeleton'));
}
if (!defined('ALX_PATH')) {
    define('ALX_PATH', realpath(__DIR__ . '/../../'));
}

echo "Starting Alxarafe Demo Reset..." . PHP_EOL;

$config = Config::getConfig(true);
if (!$config || !isset($config->db)) {
    echo "Error: Configuration (config.json) not found or database not configured." . PHP_EOL;
    exit(1);
}

try {
    echo "Connecting to database: {$config->db->name}..." . PHP_EOL;
    $db = Database::createConnection($config->db);
    $schema = $db->getConnection()->getSchemaBuilder();

    echo "Dropping all existing tables..." . PHP_EOL;
    $schema->dropAllTables();
    echo "Done." . PHP_EOL;

    echo "Running migrations..." . PHP_EOL;
    if (Config::doRunMigrations()) {
        echo "Migrations completed successfully." . PHP_EOL;
    } else {
        echo "Warning: Some migrations might have failed." . PHP_EOL;
    }

    echo "Running seeders (demo data)..." . PHP_EOL;
    if (Config::runSeeders()) {
        echo "Seeders completed successfully." . PHP_EOL;
    } else {
        echo "Warning: Some seeders might have failed." . PHP_EOL;
    }

    echo "Alxarafe Demo Reset completed successfully at " . date('Y-m-d H:i:s') . PHP_EOL;
} catch (\Throwable $e) {
    echo "CRITICAL ERROR: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}
