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

use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;
use Alxarafe\Tools\ModuleManager;
use Illuminate\Support\Str;

/**
 * Base controller providing common functionality for all controllers.
 */
abstract class GenericController
{
    /**
     * Action name to execute.
     */
    public string $action;

    /**
     * Top and sidebar menu items.
     */
    public array $topMenu = [];
    public array $sidebarMenu = [];

    /**
     * @param string|null $action Optional action override.
     * @param mixed $data Arbitrary data passed to the controller.
     */
    public function __construct(
        ?string      $action = null,
        public mixed $data = null
    )
    {
        $this->action = $action
            ?? $_POST['action']
            ?? $_GET['action']
            ?? 'index';

        $this->topMenu = ModuleManager::getArrayMenu();
        $this->sidebarMenu = ModuleManager::getArraySidebarMenu();
    }

    /**
     * Returns the menu defined in the MENU constant.
     * * @return array|false
     */
    public static function getMenu(): array|false
    {
        return constant(static::class . '::MENU') ?? false;
    }

    /**
     * Returns the combined sidebar menu (base + options).
     * * @return array|false
     */
    public static function getSidebarMenu(): array|false
    {
        $menu = constant(static::class . '::MENU');
        $sidebar = constant(static::class . '::SIDEBAR_MENU');

        if (!$menu || !$sidebar) {
            return false;
        }

        return [
            'base' => $menu,
            'options' => $sidebar,
        ];
    }

    /**
     * Returns a list of available actions (methods starting with 'do').
     * * @return array<string>
     */
    public static function getActions(): array
    {
        return array_filter(
            get_class_methods(static::class),
            fn($method) => str_starts_with($method, 'do')
        );
    }

    /**
     * Default entry point.
     */
    public function index(bool $executeActions = true): bool
    {
        return $executeActions ? $this->executeAction() : false;
    }

    /**
     * Executes the dynamic method corresponding to the action.
     */
    protected function executeAction(): bool
    {
        $actionMethod = 'do' . ucfirst(Str::camel($this->action));

        if (!method_exists($this, $actionMethod)) {
            Debug::message(
                Trans::_('unknown_method', ['method' => $actionMethod])
            );
            return false;
        }

        return $this->beforeAction()
            && $this->$actionMethod()
            && $this->afterAction();
    }

    /**
     * Hook executed before the main action.
     */
    public function beforeAction(): bool
    {
        return true;
    }

    /**
     * Hook executed after the main action.
     */
    public function afterAction(): bool
    {
        return true;
    }
}