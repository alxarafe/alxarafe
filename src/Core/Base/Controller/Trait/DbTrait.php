<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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

declare(strict_types=1);

namespace Alxarafe\Base\Controller\Trait;

use Alxarafe\Base\Database;
use stdClass;

/**
 * Trait DbTrait.
 * * Provides static database connection management for controllers.
 */
trait DbTrait
{
    /**
     * Database instance shared across the controller lifecycle.
     */
    public static ?Database $db = null;

    /**
     * Connects to the specified database if not already connected.
     *
     * @param stdClass|null $dbConfig Database configuration object.
     * @return bool True if connected or already established, false otherwise.
     */
    public static function connectDb(?stdClass $dbConfig = null): bool
    {
        // Singleton-like pattern: return true if already connected
        if (static::$db instanceof Database) {
            return true;
        }

        // Validate configuration and connectivity before instantiating
        if ($dbConfig === null || !Database::checkDatabaseConnection($dbConfig)) {
            return false;
        }

        static::$db = new Database($dbConfig);

        return true;
    }
    /**
     * Automatic initialization method called by GenericController.
     */
    public function initDbTrait(): void
    {
        // Ensure config is loaded
        $config = \Alxarafe\Base\Config::getConfig();

        // Attempt connection. If it fails, redirect to Config.
        if (!$config || !isset($config->db) || !static::connectDb($config->db)) {
            // Avoid redirect loops if we are already in ConfigController
            // (Just in case DbTrait is used there in the future)
            if (static::class !== \CoreModules\Admin\Controller\ConfigController::class) {
                \Alxarafe\Lib\Functions::httpRedirect(
                    \CoreModules\Admin\Controller\ConfigController::url(true, false)
                );
            }
        }
    }
}
