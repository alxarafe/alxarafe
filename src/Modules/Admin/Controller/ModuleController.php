<?php

declare(strict_types=1);

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

namespace CoreModules\Admin\Controller;

use Alxarafe\Attribute\Menu;
use Alxarafe\Base\Controller\Controller;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\ModuleManager;
use CoreModules\Admin\Model\Setting;

/**
 * Class ModuleController.
 *
 * Admin UI for managing module activation state.
 * Lists all discovered modules and provides enable/disable toggles.
 * Module state is stored in the settings table with key 'module_enabled_{name}'.
 */
#[Menu(menu: 'admin|modules', label: 'Modules', icon: 'fas fa-puzzle-piece', order: 70)]
class ModuleController extends Controller
{
    protected string $template = 'page/modules';

    /**
     * List all discovered modules with their activation state.
     */
    public function doIndex(): bool
    {
        $modules = $this->getDiscoveredModules();
        $this->addVar('modules', $modules);
        $this->addVar('title', Trans::_('modules'));
        return true;
    }

    /**
     * Handle module toggle (enable/disable).
     */
    public function doToggle(): bool
    {
        $moduleName = $_POST['module'] ?? $_GET['module'] ?? '';
        if (empty($moduleName)) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Module name required']);
            return false;
        }

        // Core modules cannot be disabled
        if ($this->isCoreModule($moduleName)) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Core modules cannot be disabled']);
            return false;
        }

        $key = 'module_enabled_' . strtolower($moduleName);
        $currentlyEnabled = Setting::getBool($key, true);
        $newState = !$currentlyEnabled;

        Setting::set($key, $newState ? '1' : '0');

        // Regenerate menus after toggle
        ModuleManager::regenerate();

        $this->jsonResponse([
            'status' => 'success',
            'module' => $moduleName,
            'enabled' => $newState,
            'message' => $newState
                ? Trans::_('module_enabled')
                : Trans::_('module_disabled'),
        ]);

        return true;
    }

    /**
     * Discover all available modules and their current state.
     *
     * @return array Array of module info: [name, path, namespace, enabled, is_core]
     */
    private function getDiscoveredModules(): array
    {
        $modules = [];
        $routes = ModuleManager::routes();

        foreach ($routes as $route) {
            $modulesPath = $route['path'];
            if (!is_dir($modulesPath)) {
                continue;
            }

            $dirs = scandir($modulesPath);
            foreach ($dirs as $dirName) {
                if ($dirName === '.' || $dirName === '..') {
                    continue;
                }
                if (!is_dir($modulesPath . '/' . $dirName)) {
                    continue;
                }

                $isCoreModule = $route['namespace'] === 'CoreModules';
                $key = 'module_enabled_' . strtolower($dirName);
                $enabled = $isCoreModule ? true : Setting::getBool($key, true);

                $modules[] = [
                    'name' => $dirName,
                    'namespace' => $route['namespace'],
                    'path' => $modulesPath . '/' . $dirName,
                    'enabled' => $enabled,
                    'is_core' => $isCoreModule,
                ];
            }
        }

        return $modules;
    }

    /**
     * Check if a module is a core module (cannot be disabled).
     */
    private function isCoreModule(string $moduleName): bool
    {
        $routes = ModuleManager::routes();
        foreach ($routes as $route) {
            if ($route['namespace'] === 'CoreModules') {
                $path = $route['path'] . '/' . $moduleName;
                if (is_dir($path)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Needed by Controller base class.
     */
    protected function getModelClass()
    {
        return null;
    }
}
