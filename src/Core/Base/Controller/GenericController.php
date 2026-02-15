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
    public array $sidebar_menu = []; // Legacy support for Blade
    public ?string $backUrl = null;

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
        // Merge traditional sidebar menu with MenuManager items
        $sidebarMenu = ModuleManager::getArraySidebarMenu();
        if (!is_array($sidebarMenu)) {
            $sidebarMenu = [];
        }

        try {
            // Fetch items from new Menu attribute system
            $newSidebarItems = \CoreModules\Admin\Service\MenuManager::get('admin_sidebar');

            \Alxarafe\Tools\Debug::message("MenuManager Items: " . json_encode($newSidebarItems));

            foreach ($newSidebarItems as $item) {
                // Adapt to legacy structure: ['Group' => ['Label' => 'URL']]
                // Use 'Admin' as default group if parent is not set
                $group = $item['parent'] ?: 'admin';
                // Normalize label
                $label = $item['label']; // Should be translation key or text

                // Build URL
                $url = $item['url'] ?: GenericController::url(false, ['route' => $item['route']]);
                if (!$item['url'] && $item['route'] && strpos($item['route'], '.') !== false) {
                    $parts = explode('.', $item['route']);
                    if (count($parts) >= 3) {
                        $url = "index.php?module={$parts[0]}&controller={$parts[1]}&action={$parts[2]}";
                    }
                }

                // Add to sidebar array (merging)
                $sidebarMenu[$group][strtolower($label)] = $url;
            }
        } catch (\Throwable $e) {
            // Ignore errors if class missing
            \Alxarafe\Tools\Debug::message("MenuManager Error: " . $e->getMessage());
        }

        // New Menu System Integration
        try {
            $this->data['header_user_menu'] = \CoreModules\Admin\Service\MenuManager::get('header_user');
        } catch (\Throwable $e) {
            // Fail gracefully if class not found or error
            $this->data['header_user_menu'] = [];
        }

        // Automatic Trait Initialization (Boot Pattern)
        // Looks for methods named init{TraitName} and executes them
        foreach (class_uses_recursive(static::class) as $trait) {
            $method = 'init' . class_basename($trait);
            if (method_exists($this, $method)) {
                $this->$method();
            }
        }

        // SYNC for Blade Template: side_bar.blade.php uses $me->sidebar_menu
        $this->sidebar_menu = $sidebarMenu;
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
        $isPublic = ($this instanceof \Alxarafe\Base\Controller\GenericPublicController) || (static::getControllerName() === 'Error');
        if (!$isPublic && \Alxarafe\Lib\Auth::$user) {
            if (!\Alxarafe\Lib\Auth::$user->can($this->action, static::getControllerName(), static::getModuleName())) {
                $msg = Trans::_('access_denied_action', ['action' => $this->action]);
                Debug::message($msg);
                \Alxarafe\Lib\Functions::httpRedirect("index.php?module=Admin&controller=Error&action=index&message=" . urlencode($msg));
                return false;
            }
        }

        $actionMethod = 'do' . ucfirst(Str::camel($this->action));

        if (!method_exists($this, $actionMethod)) {
            $msg = Trans::_('unknown_method', ['method' => $actionMethod]);
            Debug::message($msg);
            \Alxarafe\Lib\Functions::httpRedirect("index.php?module=Admin&controller=Error&action=index&message=" . urlencode($msg));
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

        // Try to generate friendly URL
        $actionStr = is_string($action) ? $action : 'index';
        $paramsArr = is_array($params) ? $params : [];
        $friendlyUrl = \Alxarafe\Lib\Router::generate($module, $controller, $actionStr, $paramsArr);
        if ($friendlyUrl) {
            return $friendlyUrl;
        }

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
