<?php

/* Copyright (C) 2024       Rafael San José         <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
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

/**
 * Class ConfigController. App settings controller.
 */
class MigrationController extends Controller
{
    const MENU = 'admin|migrations';

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

        // Ensure DB connection is managed via DbTrait


        // List all migrations with status
        \Alxarafe\Tools\Debug::message("MigrationController::doIndex accessing migrations");
        $all = Config::getMigrations();
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
}
