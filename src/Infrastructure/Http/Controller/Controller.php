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

declare(strict_types=1);

namespace Alxarafe\Infrastructure\Http\Controller;

use Alxarafe\Infrastructure\Http\Controller\Trait\DbTrait;
use Alxarafe\Infrastructure\Auth\Auth;
use Alxarafe\Infrastructure\Lib\Functions;
use Alxarafe\Infrastructure\Lib\Trans;
use Alxarafe\Infrastructure\Lib\Messages;

/**
 * Class Controller.
 *
 * General purpose controller that requires user authentication and
 * active database connection.
 *
 * @package Alxarafe\Infrastructure\Persistence
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

        // Authentication and Authorization Checks
        if ($this->shouldEnforceAuth()) {
            // 1. Authentication Check
            if (!Auth::isLogged()) {
                $currentUrl = Functions::getUrl() . '/index.php?' . $_SERVER['QUERY_STRING'];
                Functions::httpRedirect(\Modules\Admin\Controller\AuthController::url(true, false) . '&redirect=' . urlencode($currentUrl));
            }

            // 2. Module Activation Check (Ockham's Razor)
            $moduleName = static::getModuleName();
            if ($moduleName !== '' && $moduleName !== 'Admin') {
                if (class_exists('\Modules\Admin\Service\MenuManager') && !\Modules\Admin\Service\MenuManager::isModuleEnabled($moduleName)) {
                    Messages::addError(Trans::_('module_disabled', ['module' => $moduleName]));
                    Functions::httpRedirect(\Modules\Admin\Controller\ErrorController::url(true, false) . '&message=' . urlencode(Trans::_('module_disabled', ['module' => $moduleName])));
                }
            }

            // 3. Authorization Check
            // At this point Auth::$user is set (isLogged ensures it)
            $actionName = $this->action ?: 'index';
            if (Auth::$user && !Auth::$user->can($actionName, static::getControllerName(), static::getModuleName())) {
                Messages::addError(Trans::_('access_denied'));
                Functions::httpRedirect(\Modules\Admin\Controller\ErrorController::url(true, false) . '&message=' . urlencode(Trans::_('access_denied')));
            }
        }

        $this->username = Auth::$user?->name;
    }

    /**
     * Determine if this controller requires authentication.
     * Can be overridden by child classes (e.g., ConfigController during install).
     */
    protected function shouldEnforceAuth(): bool
    {
        return true;
    }
}
