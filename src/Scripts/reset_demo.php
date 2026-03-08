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
use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;

// Define base paths if not already defined (CLI execution)
if (!defined('ALX_PATH')) {
    $alxPath = realpath(__DIR__ . '/../../');
    if (!$alxPath && is_dir(__DIR__ . '/../../src/Core')) {
        $alxPath = dirname(__DIR__, 2);
    }
    define('ALX_PATH', $alxPath ?: dirname(__DIR__, 2));
}
if (!defined('APP_PATH')) {
    $appPath = realpath(ALX_PATH . '/skeleton');
    define('APP_PATH', $appPath ?: ALX_PATH . '/skeleton');
}
if (!defined('BASE_PATH')) {
    $basePath = realpath(APP_PATH . '/public');
    define('BASE_PATH', $basePath ?: APP_PATH . '/public');
}

echo "Starting Alxarafe Demo Reset..." . PHP_EOL;

$config = Config::getConfig(true);
if (!$config || !isset($config->db)) {
    $configFile = Config::getConfigFilename();
    echo "Error: Configuration (config.json) not found or database not configured." . PHP_EOL;
    echo "Attempted to load from: " . $configFile . PHP_EOL;
    if (!file_exists($configFile)) {
        echo "The file does not exist at that path." . PHP_EOL;
    }
    echo "BASE_PATH: " . (defined('BASE_PATH') ? BASE_PATH : 'Undefined') . PHP_EOL;
    echo "APP_PATH: " . (defined('APP_PATH') ? APP_PATH : 'Undefined') . PHP_EOL;
    exit(1);
}

try {
    echo "Connecting to database: {$config->db->name}..." . PHP_EOL;
    $db = Database::createConnection($config->db);
    $schema = $db->getConnection()->getSchemaBuilder();

    echo "Dropping all existing tables..." . PHP_EOL;
    $db->getConnection()->statement('SET FOREIGN_KEY_CHECKS = 0');
    $schema->dropAllTables();
    echo "Done." . PHP_EOL;

    echo "Running migrations..." . PHP_EOL;
    if (Config::doRunMigrations()) {
        echo "Migrations completed successfully." . PHP_EOL;
    } else {
        echo "Warning: Some migrations might have failed. Errors:" . PHP_EOL;
        foreach (Messages::getMessages() as $message) {
            if ($message['type'] === 'danger') {
                echo " - " . $message['text'] . PHP_EOL;
            }
        }
    }

    echo "Running seeders (demo data)..." . PHP_EOL;
    if (Config::runSeeders()) {
        echo "Seeders completed successfully." . PHP_EOL;
    } else {
        echo "Warning: Some seeders might have failed. Errors:" . PHP_EOL;
        foreach (Messages::getMessages() as $message) {
            if ($message['type'] === 'danger') {
                echo " - " . $message['text'] . PHP_EOL;
            }
        }
    }

    $db->getConnection()->statement('SET FOREIGN_KEY_CHECKS = 1');
    echo "Alxarafe Demo Reset completed successfully at " . date('Y-m-d H:i:s') . PHP_EOL;
} catch (\Throwable $e) {
    if (isset($db)) {
        $db->getConnection()->statement('SET FOREIGN_KEY_CHECKS = 1');
    }
    echo "CRITICAL ERROR: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}
