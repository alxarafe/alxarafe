<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace CoreModules\Admin\Controller;

use Alxarafe\Base\Controller\Controller;
use Alxarafe\Base\Config;
use Alxarafe\Base\Database;
use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Auth;
use Alxarafe\Attribute\Menu;

/**
 * Class ConfigController. App settings controller.
 */
#[Menu(
    menu: 'main_menu',
    label: 'Migrations',
    icon: 'fas fa-bolt',
    order: 85,
    permission: 'Admin.Migration.doIndex'
)]
class MigrationController extends Controller
{


    public function __construct(?string $action = null, mixed $data = null)
    {
        parent::__construct($action, $data);
    }

    /**
     * Returns the module name for use in url function
     *
     * @return string
     */
    #[\Override]
    public static function getModuleName(): string
    {
        return 'Admin';
    }

    /**
     * Returns the controller name for use in url function
     *
     * @return string
     */
    #[\Override]
    public static function getControllerName(): string
    {
        return 'Migration';
    }

    public function doGetProcesses(): void
    {
        $this->template = null;
        $migrations = array_merge(Config::getMigrations());
        $result = [];
        foreach ($migrations as $key => $migration) {
            $data = explode("@", $key);
            if (count($data) < 2) {
                continue;
            }
            $class = $data[0];
            $module = $data[1];
            $result[] = [
                'class' => $class,
                'module' => $module,
                'migration' => $migration,
                'message' => Trans::_('processing_migration', ['name' => $module . '::' . $class]),
            ];
        }
        die(json_encode($result));
    }

    public function doExecuteProcess(): void
    {
        $this->template = null;
        header('Content-Type: application/json');

        $module = $_POST['module'] ?? '';
        $class = $_POST['class'] ?? '';
        $key = $class . '@' . $module;

        try {
            // Get all migrations
            $migrations = Config::getMigrations();

            if (!isset($migrations[$key])) {
                throw new \Exception("Migration not found: $key");
            }

            $path = $migrations[$key];

            // Check if already executed
            if (\CoreModules\Admin\Model\Migration::where('migration', $key)->exists()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Already executed'
                ]);
                exit;
            }

            // Run schema change
            if (!file_exists($path)) {
                throw new \Exception("File not found: $path");
            }

            $migration = require_once $path;

            // Support both anonymous class return (Laravel style) and class declaration (Legacy)
            if (is_object($migration) && method_exists($migration, 'up')) {
                $migration->up();
            } elseif (class_exists($class)) {
                // Legacy support: if the file declares a class named $class without namespace or in global
                // This part depends on how legacy migrations were written. 
                // Given the user context, we focus on the object return first.
                $instance = new $class();
                $instance->up();
            }

            // Log to DB
            $batch = \CoreModules\Admin\Model\Migration::getLastBatch() + 1;
            \CoreModules\Admin\Model\Migration::create([
                'migration' => $key,
                'batch' => $batch,
            ]);

            echo json_encode([
                'status' => 'success',
                'message' => 'Processed successfully ' . $key
            ]);
        } catch (\Throwable $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    /**
     * Shows the migration status page.
     */
    public function doIndex(): bool
    {
        $this->setDefaultTemplate('page/migration');
        $this->addVariable('title', Trans::_('migrations'));

        // Ensure DB connection is managed via DbTrait


        // List all migrations with status
        \Alxarafe\Tools\Debug::message("MigrationController::doIndex accessing migrations");
        $all = Config::getMigrations();

        // Sort by filename specifically handling date formats (YYYYMMDD vs YYYY_MM_DD)
        uksort($all, function ($a, $b) use ($all) {
            $pathA = basename($all[$a]);
            $pathB = basename($all[$b]);
            // Remove underscores to normalize 2026_02_10 to 20260210, making it comparable to 20260215
            $cleanA = str_replace('_', '', $pathA);
            $cleanB = str_replace('_', '', $pathB);
            return strcmp($cleanA, $cleanB);
        });

        $migrationsWithStatus = [];

        try {
            $executed = \CoreModules\Admin\Model\Migration::pluck('migration')->toArray();
            foreach ($all as $name => $path) {
                $isExecuted = in_array($name, $executed);
                $migrationsWithStatus[$name] = [
                    'path' => $path,
                    'status' => $isExecuted ? 'completed' : 'pending'
                ];
            }
        } catch (\Exception $e) {
            // Table might not exist yet if it's a fresh install - ALL PENDING
            foreach ($all as $name => $path) {
                $migrationsWithStatus[$name] = [
                    'path' => $path,
                    'status' => 'pending'
                ];
            }
        }

        $this->addVariable('allMigrationsWithStatus', $migrationsWithStatus);

        return true;
    }

    /**
     * AJAX endpoint to run migrations.
     */
    public function doRunBatchAjax(): void
    {
        $this->template = null;
        header('Content-Type: application/json');

        try {
            Config::doRunMigrations();
            Config::runSeeders();

            echo json_encode([
                'status' => 'success',
                'message' => 'Migrations and seeders executed successfully.'
            ]);
        } catch (\Throwable $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    /**
     * CLI or direct execution fallback.
     */
    public function doRunMigrationsAndSeeders(): bool
    {
        $this->template = null;
        if (php_sapi_name() === 'cli') {
            echo "Running migrations...\n";
            Config::doRunMigrations();
            echo "Running seeders...\n";
            Config::runSeeders();
            echo "Done.\n";
            return true;
        }

        // If called from browser directly without AJAX (legacy fallback)
        Config::doRunMigrations();
        Config::runSeeders();
        echo "Migrations and seeders executed.";
        return true;
    }

    public function doExit()
    {
        $this->setDefaultTemplate('page/public');
        return true;
    }

    /**
     * Determine if this controller requires authentication.
     * Use to allow access during installation (when DB/Tables are missing).
     */
    #[\Override]
    protected function shouldEnforceAuth(): bool
    {
        $config = \Alxarafe\Base\Config::getConfig();

        // If no config or no DB connection -> Allow access (return false)
        if (!$config || empty($config->db) || !\Alxarafe\Base\Database::checkIfDatabaseExists($config->db, true)) {
            return false;
        }

        // If DB exists, check for users table
        try {
            $dsn = "{$config->db->type}:host={$config->db->host};dbname={$config->db->name};charset={$config->db->charset}";
            $pdo = new \PDO($dsn, $config->db->user, $config->db->pass);
            $prefix = $config->db->prefix ?? '';
            // Use explicit prepared statement or simple query
            $stmt = $pdo->query("SHOW TABLES LIKE '{$prefix}users'");
            if ($stmt && $stmt->rowCount() === 0) {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }

        // DB and Tables exist -> Enforce Auth
        return true;
    }
}
