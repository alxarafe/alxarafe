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

namespace Alxarafe\Base\Controller;

use Alxarafe\Base\Controller\Trait\DbTrait;
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Functions;
use CoreModules\Admin\Controller\AuthController;
use CoreModules\Admin\Controller\ConfigController;

/**
 * Class Controller.
 *
 * General purpose controller that requires user authentication and
 * active database connection.
 *
 * @package Alxarafe\Base
 */
abstract class Controller extends ViewController
{
    use DbTrait;

    /**
     * Name of the authenticated user.
     */
    public ?string $username = null;

    /**
     * @param string|null $action Optional action override.
     * @param mixed $data Arbitrary data for the controller.
     */
    public function __construct(?string $action = null, mixed $data = null)
    {
        parent::__construct($action, $data);

        // Skip checks if we are already in the Configuration module
        if (static::class === ConfigController::class) {
            return;
        }

        // 1. Ensure Database connection
        $dbConfig = $this->config->db ?? null;
        if (!$dbConfig || !static::connectDb($dbConfig)) {
            Functions::httpRedirect(ConfigController::url(true, false));
        }

        // 2. Ensure Authentication (except for AuthController itself)
        if (static::class !== AuthController::class && !Auth::isLogged()) {
            Functions::httpRedirect(AuthController::url(true, false));
        }

        $this->username = Auth::$user?->name;
    }
}