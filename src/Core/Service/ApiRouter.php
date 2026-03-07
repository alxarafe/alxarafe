<?php

declare(strict_types=1);

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

namespace Alxarafe\Service;

use Alxarafe\Attribute\ApiRoute;
use Alxarafe\Attribute\RequirePermission;
use Alxarafe\Attribute\RequireRole;
use Alxarafe\Lib\Trans;
use Exception;
use ReflectionClass;
use ReflectionMethod;

class ApiRouter
{
    private const CACHE_FILE = 'tmp/api_routes.php';
    private array $routes = [];

    public function __construct(private bool $useCache = true)
    {
        $this->loadRoutes();
    }

    /**
     * Finds the route information handling the given URI and METHOD.
     */
    public function match(string $method, string $uri): ?array
    {
        // Normalize
        $method = strtoupper($method);
        $uri = rtrim(parse_url($uri, PHP_URL_PATH), '/');

        // Clean query parameters just in case
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                // Future expansion: regex matching for dynamic parameters like /api/users/{id}
                // For now, exact matching
                if ($route['path'] === $uri) {
                    return $route;
                }
            }
        }

        return null;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    private function getAppRoot(): string
    {
        if (defined('APP_PATH')) {
            $path = APP_PATH;
            // PHPUnit sometimes defines APP_PATH in skeleton/
            if (str_ends_with($path, 'skeleton') || str_ends_with($path, 'skeleton/')) {
                return dirname(rtrim($path, '/'));
            }
            return rtrim($path, '/');
        }
        return dirname(__DIR__, 4); // Backup relative to src/Core/Service/
    }

    private function loadRoutes(): void
    {
        $appRoot = $this->getAppRoot();
        $cacheFile = $appRoot . '/' . self::CACHE_FILE;

        if ($this->useCache && file_exists($cacheFile)) {
            $this->routes = require $cacheFile;
            return;
        }

        $this->routes = $this->scanForRoutes($appRoot);

        if ($this->useCache) {
            $dir = dirname($cacheFile);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            file_put_contents($cacheFile, '<?php return ' . var_export($this->routes, true) . ';');
        }
    }

    public function clearCache(): void
    {
        $appRoot = $this->getAppRoot();
        $cacheFile = $appRoot . '/' . self::CACHE_FILE;
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }

    /**
     * Scans the system for classes containing #[ApiRoute] methods.
     * Currently focuses on the `src/Modules/*` and `skeleton/Modules/*` paths.
     */
    private function scanForRoutes(string $appRoot): array
    {
        $routes = [];

        // In Alxarafe:
        // Core modules are in /src/Modules
        // App modules are in /skeleton/Modules or /app/Modules
        $searchDirs = [
            $appRoot . '/src/Modules',
            $appRoot . '/skeleton/Modules',
            $appRoot . '/app/Modules'
        ];

        foreach ($searchDirs as $baseDir) {
            if (!is_dir($baseDir)) {
                continue;
            }

            $moduleDirs = glob($baseDir . '/*', GLOB_ONLYDIR);
            
            // Si glob falla o devuelve false
            if (!is_array($moduleDirs)) {
                continue;
            }

            foreach ($moduleDirs as $moduleDir) {
                // Notice the casing, it might be 'api' or 'Api'. Alxarafe typically uses 'Api'
                $apiDir = $moduleDir . '/Api';
                if (!is_dir($apiDir)) {
                    continue;
                }

                $files = glob($apiDir . '/*.php');
                if (!is_array($files)) continue;

                foreach ($files as $file) {
                    $classData = $this->extractClassRoutes($file);
                    if ($classData) {
                        $routes = array_merge($routes, $classData);
                    }
                }
            }
        }

        return $routes;
    }

    private function extractClassRoutes(string $filePath): array
    {
        $routes = [];
        $className = $this->getClassNameFromFile($filePath);

        if (!$className || !class_exists($className, false)) {
            // Require it locally to be able to reflect over it if auto-loader didn't catch it
            require_once $filePath;
            $className = $this->getClassNameFromFile($filePath);
            if (!$className || !class_exists($className, false)) {
                return [];
            }
        }

        try {
            $reflection = new ReflectionClass($className);
            
            // Class level metadata (Roles, Permissions)
            $classRoles = [];
            $classPermissions = [];

            foreach ($reflection->getAttributes(RequireRole::class) as $attr) {
                $classRoles = array_merge($classRoles, $attr->newInstance()->roles);
            }
            foreach ($reflection->getAttributes(RequirePermission::class) as $attr) {
                $classPermissions[] = $attr->newInstance()->permission;
            }

            // Method level routes
            foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                $routeAttributes = $method->getAttributes(ApiRoute::class);
                
                foreach ($routeAttributes as $attr) {
                    /** @var ApiRoute $routeAttr */
                    $routeAttr = $attr->newInstance();

                    // Method metadata
                    $methodRoles = [];
                    $methodPermissions = [];

                    foreach ($method->getAttributes(RequireRole::class) as $roleAttr) {
                        $methodRoles = array_merge($methodRoles, $roleAttr->newInstance()->roles);
                    }
                    foreach ($method->getAttributes(RequirePermission::class) as $permAttr) {
                        $methodPermissions[] = $permAttr->newInstance()->permission;
                    }

                    $routes[] = [
                        'path' => rtrim($routeAttr->path, '/'),
                        'method' => strtoupper($routeAttr->method),
                        'class' => $className,
                        'function' => $method->getName(),
                        'roles' => array_unique(array_merge($classRoles, $methodRoles)),
                        'permissions' => array_unique(array_merge($classPermissions, $methodPermissions)),
                    ];
                }
            }
        } catch (Exception $e) {
            error_log("ApiRouter Reflection Error on $className: " . $e->getMessage());
        }

        return $routes;
    }

    /**
     * Extracts full namespace and class name from a PSR-4 file reliably.
     */
    private function getClassNameFromFile(string $filePath): ?string
    {
        $contents = file_get_contents($filePath);
        $namespace = '';
        $className = '';

        $tokens = token_get_all($contents);
        $count = count($tokens);
        $i = 0;

        while ($i < $count) {
            $token = $tokens[$i];

            if (is_array($token)) {
                if ($token[0] === T_NAMESPACE) {
                    $i++; // skip T_NAMESPACE
                    while ($i < $count && is_array($tokens[$i]) && $tokens[$i][0] === T_WHITESPACE) {
                        $i++;
                    }
                    while ($i < $count && (is_array($tokens[$i]) && ($tokens[$i][0] === T_STRING || $tokens[$i][0] === T_NAME_QUALIFIED))) {
                        $namespace .= $tokens[$i][1];
                        $i++;
                    }
                } elseif ($token[0] === T_CLASS) {
                    $i++; // skip T_CLASS
                    while ($i < $count && is_array($tokens[$i]) && $tokens[$i][0] === T_WHITESPACE) {
                        $i++;
                    }
                    if ($i < $count && is_array($tokens[$i]) && $tokens[$i][0] === T_STRING) {
                        $className = $tokens[$i][1];
                        break;
                    }
                }
            }
            $i++;
        }

        if ($className === '') {
            return null;
        }

        return $namespace ? $namespace . '\\' . $className : $className;
    }
}
