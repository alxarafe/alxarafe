<?php

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
     * Runtime menu loader (Code-First, no DB required for now).
     * Scans controllers for #[Menu] attributes and returns built menus.
     * 
     * @param string $menuCode The menu identifier (e.g. 'admin_top_icons')
     * @return array
     */
    public static function get(string $menuCode): array
    {
        // 1. Scan Codebase (Cached in static to avoid re-scan per call)
        static $allMenus = null;
        if ($allMenus === null) {
            $allMenus = self::scanMenus();
        }



        $items = $allMenus[$menuCode] ?? [];

        // INJECT DYNAMIC ITEMS
        if ($menuCode === 'user_menu' && Auth::isLogged()) {
            $currentUri = ltrim($_SERVER['REQUEST_URI'] ?? '', '/');
            // Normalize current URI (remove leading slash)
            // Example: index.php?module=Admin...

            $defaultPage = Auth::$user->getDefaultPage();

            // Loose comparison: check if defaultPage is contained in currentUri or equal
            // Because REQUEST_URI might have extra slash or domain dependent things in some setups
            // Simple approach: exact match or strict containment if needed.
            // Let's rely on standard logic: stored 'index.php...' vs actual request.

            // Handle case where stored is 'index.php' and current is '' (directory index)
            if ($currentUri === '' && $defaultPage === 'index.php') {
                $isActive = true;
            } else {
                $isActive = ($currentUri === $defaultPage);
            }

            // Url to trigger action
            // We point to ProfileController::doSetDefaultPage
            $actionUrl = 'index.php?module=Admin&controller=Profile&action=setDefaultPage';

            $items[] = [
                'label' => $isActive ? Trans::_('default_page_active') : Trans::_('set_as_default_page'),
                'icon' => $isActive ? 'fas fa-star' : 'far fa-star',
                'route' => null,
                'url' => $actionUrl,
                'order' => -10, // Top of the list
                'permission' => null,
                'visibility' => 'auth',
                'badge' => null,
                'badgeClass' => null,
            ];
        }

        // 2. Sort by Order
        usort($items, fn($a, $b) => $a['order'] <=> $b['order']);

        // 3. Filter by Visibility & Permissions
        return array_filter($items, fn($item) => self::isVisible($item));
    }

    private static function isVisible(array $item): bool
    {
        $visibility = $item['visibility'] ?? 'auth';
        $permission = $item['permission'] ?? null;

        // 1. Check Auth State
        $isLogged = \Alxarafe\Lib\Auth::isLogged();

        if ($visibility === 'auth' && !$isLogged) {
            return false;
        }

        if ($visibility === 'guest' && $isLogged) {
            return false;
        }

        // 2. Check Permissions (only if logged in)
        if ($isLogged && $permission) {
            // Permission format: Module.Controller.Action
            // Or simple string if handled differently.
            // Auth::$user->can() expects (action, controller, module) or exact key ??
            // Let's check User::can signature.
            // can($action, $controller = null, $module = null)

            // If permission is a fully qualified string "Module.Controller.Action", we might need to parse it
            // OR User::can handles granular checks?
            // User::can implementation I saw earlier:
            // $checkKey = strtolower($module . '.' . $controller . '.' . $action);
            // It constructs the key.

            // If the attribute provides the FULL key (e.g. 'Admin.User.doIndex'),
            // we should probably split it or update User::can to accept a full key.

            // Let's parse the permission string assuming 'Module.Controller.Action' format
            $parts = explode('.', $permission);
            if (count($parts) === 3) {
                return \Alxarafe\Lib\Auth::$user->can($parts[2], $parts[1], $parts[0]);
            }

            // Fallback: Pass as action, generic. (Likely to fail if strict)
            return \Alxarafe\Lib\Auth::$user->can($permission);
        }

        return true;
    }

    private static function scanMenus(): array
    {
        $menus = [];
        // Uses existing Route discovery from framework
        $routesRaw = Routes::getAllRoutes();
        $controllers = $routesRaw['Controller'] ?? [];

        // Manually include Admin Controllers to guarantee they are scanned
        // This is a workaround for the autoloader issue in Docker environment
        // Manual path resolution because autoloader is broken for new files
        // Assuming BASE_PATH constant is defined or we can find src relative to this file
        // __DIR__ is src/Modules/Admin/Service. We need to go up to src/Modules/Admin/Controller.
        $baseDir = realpath(__DIR__ . '/../Controller');

        // Debug: Log the resolved path
        if (!$baseDir) {
            \Alxarafe\Tools\Debug::message("MenuManager: Controller directory not found at " . __DIR__ . '/../Controller');
            // Try absolute path if we know it (fallback)
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
                \Alxarafe\Tools\Debug::message("MenuManager: File note found $path");
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
                    // Infer Module/Controller names
                    $parts = explode('\\', $className);
                    $controllerName = substr(end($parts), 0, -10); // Remove 'Controller'
                    $module = $parts[1] === 'Admin' ? 'Admin' : $parts[1];

                    // Class Attributes
                    $classAttrs = $reflection->getAttributes(Menu::class);
                    \Alxarafe\Tools\Debug::message("MenuManager: Class $className has " . count($classAttrs) . " Menu attributes.");

                    if (count($classAttrs) > 0) {
                        // Check what the attribute contains
                        $inst = $classAttrs[0]->newInstance();
                        \Alxarafe\Tools\Debug::message("MenuManager: Attribute menu key: " . $inst->menu);
                    }

                    foreach ($classAttrs as $attribute) {
                        $menus = self::addToMenu($menus, $attribute->newInstance(), $module, $controllerName, 'index');
                    }
                    // Method Attributes
                    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                        foreach ($method->getAttributes(Menu::class) as $attribute) {
                            \Alxarafe\Tools\Debug::message("MenuManager: Method " . $method->getName() . " has Menu attribute.");
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

        \Alxarafe\Tools\Debug::message("MenuManager: Scan complete. Keys found: " . implode(', ', array_keys($menus)));

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
            $url = sprintf('index.php?module=%s&controller=%s&action=%s', $module, $controller, $action);
        }

        $menus[$attr->menu][] = [
            'label' => Trans::_($attr->label ?? $controller),
            'icon' => $attr->icon, // Icons should include prefix (fas/far/fab) in attribute
            'route' => $route,
            'url' => $url,
            'order' => $attr->order,
            'permission' => $attr->permission,
            'visibility' => $attr->visibility,
            'badge' => $badge,
            'badgeClass' => $attr->badgeClass,
        ];
        return $menus;
    }
}
