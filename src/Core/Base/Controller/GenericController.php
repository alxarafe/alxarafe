<?php

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
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

namespace Alxarafe\Base\Controller;

use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;
use Alxarafe\Tools\ModuleManager;
use Illuminate\Support\Str;

/**
 * Class GenericController. The generic controller contains what is necessary for any controller
 *
 * @package Alxarafe\Base
 */
abstract class GenericController
{
    /**
     * Contains the action to execute.
     *
     * @var string|null
     */
    public ?string $action;

    public array $top_menu = [];
    public array $sidebar_menu = [];

    /**
     * GenericController constructor.
     */
    public function __construct()
    {
        $this->action = filter_input(INPUT_POST, 'action');
        if ($this->action === null) {
            $this->action = filter_input(INPUT_GET, 'action');
        }
        if ($this->action === null) {
            $this->action = 'index';
        }

        $this->top_menu = ModuleManager::getArrayMenu();

        $this->sidebar_menu = ModuleManager::getArraySidebarMenu();

        // Debe de tomar el sidebar_menu que se corresponda con la página cargada.

        // $this->sidebar_menu = $sidebar_menu['prueba']['ejemplo'] ?? [];
    }

    /**
     * Returns the generic url of the controller;
     *
     * @param $full
     *
     * @return string
     */
    public static function url($full = true)
    {
        $url = '';
        if ($full) {
            $url .= constant('BASE_URL') . '/index.php';
        }

        $url .=
            '?module=' . filter_input(INPUT_GET, 'module') .
            '&controller=' . filter_input(INPUT_GET, 'controller');

        $action = filter_input(INPUT_GET, 'action');
        if ($action) {
            $url .= '&action=' . $action;
        }

        return $url;
    }

    public static function getMenu()
    {
        if (!defined('static::MENU')) {
            return false;
        }
        return static::MENU;
    }

    public static function getSidebarMenu()
    {
        if (!defined('static::MENU') || !defined('static::SIDEBAR_MENU')) {
            return false;
        }

        return [
            'base' => static::MENU,
            'options' => static::SIDEBAR_MENU,
        ];
    }

    /**
     * Returns an array with the controller actions.
     *
     * @return array
     */
    public static function getActions(): array
    {
        $actions = [];

        $methods = get_class_methods(static::class);
        foreach ($methods as $method) {
            if (!str_starts_with($method, 'do')) {
                continue;
            }
            $actions[static::class][] = lcfirst(substr($method, 2));
        }

        return $actions;
    }

    /**
     * Execute the selected action, returning true if successful.
     *
     * @param bool $executeActions
     *
     * @return bool
     */
    public function index(bool $executeActions = true): bool
    {
        if (!$executeActions) {
            return false;
        }
        return $this->executeAction();
    }

    /**
     * Execute the selected action, returning true if successful.
     *
     * @return bool
     */
    private function executeAction(): bool
    {
        $actionMethod = 'do' . ucfirst(Str::camel($this->action ?? 'index'));
        if (!method_exists($this, $actionMethod)) {
            Debug::message(Trans::_('unknown_method', ['method' => $actionMethod]));
            return false;
        }
        return $this->beforeAction() && $this->$actionMethod() && $this->afterAction();
    }

    /**
     * You can include code here that is common to call all controller actions.
     * If you need to do something, override this method.
     *
     * @return bool
     */
    public function beforeAction(): bool
    {
        return true;
    }

    /**
     * You can include code here common to calling all controller actions, which will be executed after the action.
     * If you need to do something, override this method.
     *
     * @return bool
     */
    public function afterAction(): bool
    {
        return true;
    }
}
