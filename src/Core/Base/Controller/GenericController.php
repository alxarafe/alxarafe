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
    ) {
        $this->action = $action
            ?? $_POST['action']
            ?? $_GET['action']
            ?? 'index';

        $this->topMenu = ModuleManager::getArrayMenu();
        $this->sidebarMenu = ModuleManager::getArraySidebarMenu();

        // Automatic Trait Initialization (Boot Pattern)
        // Looks for methods named init{TraitName} and executes them
        foreach (class_uses_recursive(static::class) as $trait) {
            $method = 'init' . class_basename($trait);
            if (method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    /**
     * Returns the menu defined in the MENU constant.
     * * @return array|false
     */
    public static function getMenu(): string|array|false
    {
        if (!defined(static::class . '::MENU')) {
            return false;
        }
        return constant(static::class . '::MENU');
    }

    /**
     * Returns the combined sidebar menu (base + options).
     * * @return array|false
     */
    public static function getSidebarMenu(): array|false
    {
        if (!defined(static::class . '::MENU') || !defined(static::class . '::SIDEBAR_MENU')) {
            return false;
        }

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

    /**
     * Returns the module name, parsing class namespace if not overridden.
     */
    public static function getModuleName(): string
    {
        $parts = explode('\\', static::class);
        // Expecting Vendor\Module\... or Modules\Module\...
        if (count($parts) >= 2 && ($parts[0] === 'CoreModules' || $parts[0] === 'Modules')) {
            return $parts[1];
        }
        return '';
    }

    /**
     * Returns the controller name, parsing class name if not overridden.
     */
    public static function getControllerName(): string
    {
        $parts = explode('\\', static::class);
        $classname = end($parts);
        if (str_ends_with($classname, 'Controller')) {
            return substr($classname, 0, -10);
        }
        return $classname;
    }

    /**
     * Generates a URL for this controller.
     *
     * @param string|bool $action Action name (or 'index'), or legacy bool flag.
     * @param array|bool $params  Query parameters, or legacy bool flag.
     * @return string
     */
    public static function url($action = 'index', $params = []): string
    {
        $module = static::getModuleName();
        $controller = static::getControllerName();

        $url = "index.php?module={$module}&controller={$controller}";

        if (is_string($action) && $action !== 'index' && $action !== '') {
            $url .= "&action={$action}";
        }

        if (is_array($params) && !empty($params)) {
            $url .= '&' . http_build_query($params);
        }

        return $url;
    }

    /**
     * Output JSON response and exit.
     * 
     * @param array $data
     */
    protected function jsonResponse(array $data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
