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

use Alxarafe\Lib\Routes;
use CoreModules\Admin\Model\Permission;
use ReflectionClass;
use ReflectionMethod;

class PermissionSyncer
{
    /**
     * Scans all registered controllers and synchronizes permissions in the database.
     * 
     * @return array Report of operations performed ['created' => int, 'restored' => int, 'deleted' => int]
     */
    public function sync(): array
    {
        $stats = [
            'created' => 0,
            'restored' => 0,
            'deleted' => 0,
        ];

        // 1. Discover all current Permissions from codebase
        $discovered = $this->discoverPermissions();

        // 2. Fetch all existing permissions from DB (including soft deleted)
        // We use the unique key "Module.Controller.Action" for comparison.
        $existing = Permission::withTrashed()->get()->keyBy(function ($item) {
            return $item->getKey(); // Returns Module.Controller.Action
        });

        // 3. Process Discovery
        foreach ($discovered as $key => $data) {
            if ($existing->has($key)) {
                // It exists in DB
                $permission = $existing->get($key);

                if ($permission->trashed()) {
                    // It was deleted but now exists in code -> Restore it
                    $permission->restore();
                    $stats['restored']++;
                }
            } else {
                // New permission found -> Create it
                Permission::create([
                    'module' => $data['module'],
                    'controller' => $data['controller'],
                    'action' => $data['action'],
                    'name' => $data['module'] . ' ' . $data['controller'] . ' ' . $data['action'], // Default name
                ]);
                $stats['created']++;
            }
        }

        // 4. Process Deletions (Items in DB but not in Discovery)
        foreach ($existing as $key => $permission) {
            if (!isset($discovered[$key]) && !$permission->trashed()) {
                // Exists in DB (active) but not in code -> Soft delete
                $permission->delete();
                $stats['deleted']++;
            }
        }

        return $stats;
    }

    /**
     * Scans controllers to find 'doAction' methods.
     * 
     * @return array [ 'Module.Controller.doAction' => ['module' => '...', 'controller' => '...', 'action' => '...'] ]
     */
    private function discoverPermissions(): array
    {
        $permissions = [];
        $routesRaw = Routes::getAllRoutes();
        $controllers = $routesRaw['Controller'] ?? [];

        foreach ($controllers as $module => $moduleControllers) {
            foreach ($moduleControllers as $controllerName => $info) {
                // $info is "Namespace\Class|/path/to/file.php"
                [$className, $filePath] = explode('|', $info);

                if (!class_exists($className)) {
                    if (file_exists($filePath)) {
                        require_once $filePath;
                    }
                }

                if (!class_exists($className)) {
                    continue; // Skip if class still doesn't exist
                }

                try {
                    $reflection = new ReflectionClass($className);

                    // Skip Public Controllers (descendants of GenericPublicController)
                    if ($reflection->isSubclassOf(\Alxarafe\Base\Controller\GenericPublicController::class)) {
                        continue;
                    }

                    if (in_array($controllerName, ['Auth', 'Error', 'Login'])) {
                        continue;
                    }

                    // 1. Add synthetic 'doAccess' permission (Controller-level access)
                    $accessKey = sprintf('%s.%s.%s', $module, $controllerName, 'doAccess');
                    $permissions[$accessKey] = [
                        'module' => $module,
                        'controller' => $controllerName,
                        'action' => 'doAccess',
                    ];

                    $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

                    foreach ($methods as $method) {
                        $methodName = $method->getName();

                        // Rule: Actions must start with "do" (e.g., doSave, doIndex)
                        // Skip 'doAccess' if it exists as a method to avoid duplication
                        if (str_starts_with($methodName, 'do') && $methodName !== 'doAccess') {
                            // Key format: Module.Controller.Action
                            $key = sprintf('%s.%s.%s', $module, $controllerName, $methodName);

                            $permissions[$key] = [
                                'module' => $module,
                                'controller' => $controllerName,
                                'action' => $methodName,
                            ];
                        }
                    }
                } catch (\ReflectionException $e) {
                    // Ignore reflection errors for uninstantiable classes
                    continue;
                }
            }
        }

        return $permissions;
    }
}
