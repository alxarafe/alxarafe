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

        $config = Config::getConfig();
        if ($config === null) {
            // Create a dummy config for testing if file is missing
            $config = new \stdClass();
            $config->main = Config::getDefaultMainFileInfo();
            $config->db = new \stdClass();
            $config->db->type = getenv('DB_CONNECTION') ?: 'mysql';
            $config->db->host = getenv('DB_HOST') ?: '127.0.0.1';
            $config->db->port = getenv('DB_PORT') ?: 3306;
            $config->db->user = getenv('DB_USER') ?: 'root';
            $config->db->pass = getenv('DB_PASS') ?: 'root';
            $config->db->name = getenv('DB_DATABASE') ?: 'alxarafe_test';
            $config->db->charset = 'utf8mb4';
            $config->db->collation = 'utf8mb4_unicode_ci';

            Config::setConfig($config);
            $config = Config::getConfig(true);
        }

        // Override Database Config for Testing
        if ($config) {
            if (isset($config->db)) {
                $config->db->name = getenv('DB_DATABASE') ?: ($config->db->name ?? 'alxarafe_test');

                $dbHost = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? ($_SERVER['DB_HOST'] ?? false));

                // Fallback for GitHub Actions if DB_HOST is missing
                if ($dbHost === false && getenv('GITHUB_ACTIONS') === 'true') {
                    $dbHost = 'mysql';
                }

                if ($dbHost !== false) {
                    $config->db->host = $dbHost;
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
