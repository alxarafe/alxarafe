<?php

namespace Tests;

use Alxarafe\Base\Config;
use Alxarafe\Base\Database;
use Alxarafe\Tools\Debug;
use Alxarafe\Lib\Trans;

class Bootstrapper
{
    public static function boot()
    {
        if (!defined('ALX_TESTING')) {
            define('ALX_TESTING', true);
        }

        // Define base paths if not already defined
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', __DIR__ . '/../skeleton/public');
        }
        if (!defined('BASE_URL')) {
            define('BASE_URL', 'http://localhost');
        }
        if (!defined('ALX_PATH')) {
            define('ALX_PATH', realpath(__DIR__ . '/../'));
        }
        if (!defined('APP_PATH')) {
            define('APP_PATH', realpath(__DIR__ . '/../skeleton/'));
        }

        // Initialize Services
        Debug::initialize();
        Trans::initialize();
        Config::getConfig(); // Load config

        // Override Database Config for Testing
        if ($config = Config::getConfig()) {
            if (isset($config->db)) {
                $config->db->name = 'alxarafe_test';

                $dbHost = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? ($_SERVER['DB_HOST'] ?? false));

                // Fallback for GitHub Actions if DB_HOST is missing
                if ($dbHost === false && getenv('GITHUB_ACTIONS') === 'true') {
                    fwrite(STDERR, "Debug: DB_HOST not found, defaulting to 'mysql' for GITHUB_ACTIONS.\n");
                    $dbHost = 'mysql';
                }

                if ($dbHost !== false) {
                    fwrite(STDERR, "Debug: Using DB_HOST: $dbHost\n");
                    $config->db->host = $dbHost;
                } else {
                    fwrite(STDERR, "Debug: No DB_HOST override found. Using config default: " . ($config->db->host ?? 'unknown') . "\n");
                }

                $dbUser = getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? ($_SERVER['DB_USER'] ?? false));
                if ($dbUser !== false) {
                    $config->db->user = $dbUser;
                }
                $dbPass = getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? ($_SERVER['DB_PASS'] ?? false));
                if ($dbPass !== false) {
                    $config->db->pass = $dbPass;
                }
                $dbPort = getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? ($_SERVER['DB_PORT'] ?? false));
                if ($dbPort !== false) {
                    $config->db->port = $dbPort;
                }

                // Ensure connection to server to create DB if needed
                Database::checkDatabaseConnection($config->db, true);

                // Connect to the test database
                Database::createConnection($config->db);

                // Run Migrations
                Config::doRunMigrations();
            }
        }

        // Set Test User Constant
        if (!defined('ALX_TEST_USER')) {
            define('ALX_TEST_USER', true);
        }
    }
}
