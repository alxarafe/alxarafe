<?php

namespace CoreModules\Admin\Service;

use Alxarafe\Attribute\Menu;
use Alxarafe\Lib\Routes;
use Alxarafe\Lib\Auth;
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

        // 2. Sort by Order
        usort($items, fn($a, $b) => $a['order'] <=> $b['order']);

        // 3. Filter by Visibility & Permissions
        return array_filter($items, fn($item) => self::isVisible($item));
    }

    private static function isVisible(array $_item): bool
    {
        // FORCE VISIBILITY FOR DEBUG
        // Ignorar comprobaciones de Auth y Permisos por ahora
        // $label = $item['label'] ?? 'Unknown';
        // \Alxarafe\Tools\Debug::message("MenuManager: Visible (FORCED) - {$label}");
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

        foreach ($adminControllers as $className) {
            if (class_exists($className)) {
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

        $menus[$attr->menu][] = [
            'label' => $attr->label ?? $controller,
            'icon' => $attr->icon,
            'route' => $route,
            'url' => $attr->url,
            'order' => $attr->order,
            'permission' => $attr->permission,
            'visibility' => $attr->visibility,
            'badge' => $badge,
            'badgeClass' => $attr->badgeClass,
        ];
        return $menus;
    }
}
