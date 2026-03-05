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

namespace CoreModules\Admin\Service;

use Alxarafe\Attribute\Menu;
use Alxarafe\Lib\Routes;
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Trans;
use Alxarafe\Base\Config;
use ReflectionClass;
use ReflectionMethod;

class MenuManager
{
    /**
     * Class-level static for the scanned menus cache.
     * Using a class-level property (instead of function-level static)
     * allows invalidateCache() to clear it.
     */
    private static ?array $allMenus = null;

    /**
     * Runtime menu loader (Code-First, no DB required for now).
     * Scans controllers for #[Menu] attributes and returns built menus.
     * Results are cached per-request and can be persisted to file per role.
     *
     * @param string $menuCode The menu identifier (e.g. 'top_menu')
     * @return array
     */
    public static function get(string $menuCode): array
    {
        // 1. Try role-based file cache first
        if (self::$allMenus === null) {
            $cached = self::loadFromFileCache();
            if ($cached !== null) {
                self::$allMenus = $cached;
            } else {
                // 2. Scan Codebase
                self::$allMenus = self::scanMenus();
                // 3. Save to file cache
                self::saveToFileCache(self::$allMenus);
            }
        }

        $items = self::$allMenus[$menuCode] ?? [];

        // INJECT DYNAMIC ITEMS
        if ($menuCode === 'user_menu' && Auth::isLogged()) {
            $currentUri = ltrim($_SERVER['REQUEST_URI'] ?? '', '/');

            $defaultPage = Auth::$user->getDefaultPage();

            if ($currentUri === '' && $defaultPage === 'index.php') {
                $isActive = true;
            } else {
                $isActive = ($currentUri === $defaultPage);
            }

            $actionUrl = 'index.php?module=Admin&controller=Profile&action=setDefaultPage';

            $items[] = [
                'label' => $isActive ? Trans::_('default_page_active') : Trans::_('set_as_default_page'),
                'icon' => $isActive ? 'fas fa-star' : 'far fa-star',
                'route' => null,
                'url' => $actionUrl,
                'order' => -10,
                'permission' => null,
                'visibility' => 'auth',
                'badge' => null,
                'badgeClass' => null,
                'module' => 'Admin',
            ];
        }

        // 2. Sort by Order
        usort($items, fn($a, $b) => $a['order'] <=> $b['order']);

        // 3. Filter by Visibility & Permissions
        return array_filter($items, fn($item) => self::isVisible($item));
    }

    /**
     * Clear the in-memory menu cache AND delete all role-based file caches.
     * Must be called after module activation/deactivation changes.
     */
    public static function invalidateCache(): void
    {
        self::$allMenus = null;

        // Delete all cached menu files
        $cacheDir = self::getCacheDir();
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . '/menu_*.php');
            foreach ($files as $file) {
                @unlink($file);
            }
        }
    }

    /**
     * Get the cache directory for menu files.
     * Uses the application's var/cache directory.
     */
    private static function getCacheDir(): string
    {
        if (defined('APP_PATH')) {
            return realpath(constant('APP_PATH')) . '/var/cache/menus';
        }
        if (defined('BASE_PATH')) {
            return realpath(constant('BASE_PATH') . '/..') . '/var/cache/menus';
        }
        return sys_get_temp_dir() . '/alxarafe/cache/menus';
    }

    /**
     * Generate a cache key based on the current user's role.
     * If no user is logged in, uses 'guest'.
     */
    private static function getCacheKey(): string
    {
        if (Auth::isLogged() && Auth::$user) {
            // Use role ID if available, otherwise user ID
            try {
                $role = Auth::$user->role ?? null;
                if ($role && isset($role->id)) {
                    return 'role_' . $role->id;
                }
            } catch (\Throwable $e) {
                // Role not available, fall through
            }
            return 'user_' . Auth::$user->id;
        }
        return 'guest';
    }

    /**
     * Try to load menus from the role-based file cache.
     * Returns null if no valid cache exists.
     */
    private static function loadFromFileCache(): ?array
    {
        $cacheDir = self::getCacheDir();
        $cacheKey = self::getCacheKey();
        $cachePath = $cacheDir . '/menu_' . $cacheKey . '.php';

        if (!file_exists($cachePath)) {
            return null;
        }

        // Check cache age (max 1 hour to auto-refresh)
        $maxAge = 3600;
        if (time() - filemtime($cachePath) > $maxAge) {
            @unlink($cachePath);
            return null;
        }

        try {
            $data = require $cachePath;
            return is_array($data) ? $data : null;
        } catch (\Throwable $e) {
            @unlink($cachePath);
            return null;
        }
    }

    /**
     * Save menus to a role-based file cache.
     */
    private static function saveToFileCache(array $menus): void
    {
        $cacheDir = self::getCacheDir();
        $cacheKey = self::getCacheKey();
        $cachePath = $cacheDir . '/menu_' . $cacheKey . '.php';

        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }

        $export = var_export($menus, true);
        $content = "<?php\n// Auto-generated menu cache — " . date('Y-m-d H:i:s') . "\n// Cache key: {$cacheKey}\nreturn {$export};\n";

        @file_put_contents($cachePath, $content, LOCK_EX);
    }

    private static function isVisible(array $item): bool
    {
        $visibility = $item['visibility'] ?? 'auth';
        $permission = $item['permission'] ?? null;

        // 1. Check Auth State
        $isLogged = Auth::isLogged();

        if ($visibility === 'auth' && !$isLogged) {
            return false;
        }

        if ($visibility === 'guest' && $isLogged) {
            return false;
        }

        // 2. Check Permissions (only if logged in)
        if ($isLogged && $permission) {
            $parts = explode('.', $permission);
            if (count($parts) === 3) {
                return Auth::$user->can($parts[2], $parts[1], $parts[0]);
            }

            // Fallback: Pass as action
            return Auth::$user->can($permission);
        }

        return true;
    }

    /**
     * Check if a module is enabled in the settings.
     * Core modules (Admin) are always enabled.
     * This provides defense-in-depth filtering independent of Routes cache.
     */
    private static function isModuleEnabled(string $moduleName): bool
    {
        // Core module Admin is always enabled
        if ($moduleName === 'Admin') {
            return true;
        }

        try {
            if (!class_exists('\CoreModules\Admin\Model\Setting')) {
                return true;
            }
            $value = \CoreModules\Admin\Model\Setting::get(
                'module_enabled_' . strtolower($moduleName)
            );
            if ($value === null) {
                return true; // Default enabled if no setting exists
            }
            return in_array($value, ['1', 'true', 'yes'], true);
        } catch (\Throwable $e) {
            return true; // If settings table doesn't exist yet, allow all
        }
    }

    private static function scanMenus(): array
    {
        $menus = [];
        // Uses existing Route discovery from framework
        $routesRaw = Routes::getAllRoutes();
        $controllers = $routesRaw['Controller'] ?? [];

        // Manually include Admin Controllers to guarantee they are scanned
        // This is a workaround for the autoloader issue in Docker environment
        $baseDir = '';
        if (defined('ALX_PATH')) {
            $baseDir = realpath(constant('ALX_PATH') . '/src/Modules/Admin/Controller');
        }

        if (!$baseDir) {
            $baseDir = realpath(__DIR__ . '/../Controller');
        }

        if (!$baseDir) {
            // Fallback for some docker setups
            $baseDir = '/var/www/html/src/Modules/Admin/Controller';
        }

        $manualIncludes = [
            'RoleController' => $baseDir . '/RoleController.php',
            'UserController' => $baseDir . '/UserController.php',
            'ConfigController' => $baseDir . '/ConfigController.php',
            'AuthController' => $baseDir . '/AuthController.php',
        ];

        foreach ($manualIncludes as $path) {
            if (file_exists($path)) {
                require_once $path;
            } else {
                \Alxarafe\Tools\Debug::message("MenuManager: File not found $path");
            }
        }

        $adminControllers = [
            'CoreModules\Admin\Controller\RoleController',
            'CoreModules\Admin\Controller\UserController',
            'CoreModules\Admin\Controller\ConfigController',
            'CoreModules\Admin\Controller\AuthController',
        ];

        $scannedClasses = [];

        foreach ($adminControllers as $className) {
            if (class_exists($className)) {
                if (in_array($className, $scannedClasses)) continue;
                $scannedClasses[] = $className;

                try {
                    $reflection = new ReflectionClass($className);
                    $parts = explode('\\', $className);
                    $controllerName = substr(end($parts), 0, -10);
                    $module = $parts[1] === 'Admin' ? 'Admin' : $parts[1];

                    // Class Attributes
                    $classAttrs = $reflection->getAttributes(Menu::class);

                    foreach ($classAttrs as $attribute) {
                        $menus = self::addToMenu($menus, $attribute->newInstance(), $module, $controllerName, 'index');
                    }
                    // Method Attributes
                    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                        foreach ($method->getAttributes(Menu::class) as $attribute) {
                            $menus = self::addToMenu($menus, $attribute->newInstance(), $module, $controllerName, $method->getName());
                        }
                    }
                } catch (\Throwable $e) {
                    \Alxarafe\Tools\Debug::message("MenuManager Scan Error: " . $e->getMessage());
                    continue;
                }
            } else {
                \Alxarafe\Tools\Debug::message("MenuManager: Class $className does not exist even after require.");
            }
        }

        foreach ($controllers as $module => $moduleControllers) {
            // Defense-in-depth: skip controllers from disabled modules
            if (!self::isModuleEnabled($module)) {
                continue;
            }

            foreach ($moduleControllers as $controllerName => $info) {
                [$className, $filePath] = explode('|', $info);

                if (!class_exists($className)) {
                    if (file_exists($filePath)) require_once $filePath;
                }

                if (!class_exists($className)) continue;
                if (in_array($className, $scannedClasses)) continue;
                $scannedClasses[] = $className;

                try {
                    $reflection = new ReflectionClass($className);
                    // Class Attributes
                    foreach ($reflection->getAttributes(Menu::class) as $attribute) {
                        $menus = self::addToMenu($menus, $attribute->newInstance(), $module, $controllerName, 'index');
                    }
                    // Method Attributes
                    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                        foreach ($method->getAttributes(Menu::class) as $attribute) {
                            $menus = self::addToMenu($menus, $attribute->newInstance(), $module, $controllerName, $method->getName());
                        }
                    }
                } catch (\Throwable $e) {
                    continue;
                }
            }
        }

        return $menus;
    }

    private static function addToMenu(array $menus, Menu $attr, string $module, string $controller, string $action): array
    {
        $route = $attr->route ?? sprintf('%s.%s.%s', $module, $controller, $action);

        // Resolve Badge (Runtime!)
        $badge = null;
        if ($attr->badgeResolver && is_callable($attr->badgeResolver)) {
            $badge = call_user_func($attr->badgeResolver);
        }

        // Generate Default URL if not provided
        $url = $attr->url;
        if (empty($url)) {
            $url = sprintf('/index.php?module=%s&controller=%s&action=%s', $module, $controller, $action);
        }

        $menus[$attr->menu][] = [
            'label' => Trans::_($attr->label ?? $controller),
            'icon' => $attr->icon,
            'route' => $route,
            'url' => $url,
            'parent' => $attr->parent,
            'class' => $attr->class,
            'order' => $attr->order,
            'permission' => $attr->permission,
            'visibility' => $attr->visibility,
            'badge' => $badge,
            'badgeClass' => $attr->badgeClass,
            'module' => $attr->module ?? $module,
        ];
        return $menus;
    }
}
