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



        // 2. Ensure Authentication (except for AuthController itself)
        if (static::class !== AuthController::class && !Auth::isLogged()) {
            $currentUrl = Functions::getUrl() . '/index.php?' . $_SERVER['QUERY_STRING'];
            Functions::httpRedirect(AuthController::url(true, false) . '&redirect=' . urlencode($currentUrl));
        }

        $this->username = Auth::$user?->name;
    }
}
