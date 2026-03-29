<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

namespace Modules\Admin\Controller;

use Alxarafe\Infrastructure\Attribute\Menu;
use Alxarafe\Infrastructure\Attribute\ModuleInfo;
use Alxarafe\Infrastructure\Http\Controller\Controller;
use Alxarafe\Infrastructure\Lib\Trans;
use Alxarafe\Infrastructure\Tools\DependencyResolver;
use Alxarafe\Infrastructure\Tools\ModuleManager;
use Modules\Admin\Model\Setting;

/**
 * Class ModuleController.
 *
 * Admin UI for managing module activation state with automatic
 * dependency resolution.
 *
 * @see doc/modules-and-dependencies.md
 */
#[Menu(menu: 'main_menu', label: 'Modules', icon: 'fas fa-puzzle-piece', order: 30, parent: 'Administration')]
class ModuleController extends Controller
{
    /**
     * List all discovered modules with their activation state and metadata.
     */
    public function doIndex(): bool
    {
        $this->setDefaultTemplate('page/modules');
        $modules = $this->getDiscoveredModules();
        $this->addVariable('modules', $modules);
        $this->addVariable('title', Trans::_('modules'));
        return true;
    }

    /**
     * Handle module toggle (enable/disable) with dependency cascade.
     *
     * When disabling a module, if other modules depend on it,
     * returns the list of dependents for user confirmation.
     * The frontend must re-call with force=1 to confirm cascade.
     */
    public function doToggle(): bool
    {
        $moduleName = $_POST['module'] ?? $_GET['module'] ?? '';
        if (empty($moduleName)) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Module name required']);
            return false;
        }

        if ($this->isCoreModule($moduleName)) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Core modules cannot be disabled']);
            return false;
        }

        $key = 'module_enabled_' . strtolower($moduleName);
        $currentlyEnabled = Setting::getBool($key, true);
        $newState = !$currentlyEnabled;

        // If disabling, check for cascade dependencies
        if (!$newState) {
            $cascade = DependencyResolver::getCascadeDisable($moduleName);
            // Filter out already-disabled and core modules
            $cascade = array_filter($cascade, function ($mod) {
                if ($this->isCoreModule($mod)) {
                    return false;
                }
                return Setting::getBool('module_enabled_' . strtolower($mod), true);
            });
            $cascade = array_values($cascade);

            $force = ($_POST['force'] ?? $_GET['force'] ?? '0') === '1';

            if (!empty($cascade) && !$force) {
                // Ask user to confirm cascade
                $this->jsonResponse([
                    'status' => 'confirm_cascade',
                    'module' => $moduleName,
                    'dependents' => $cascade,
                    'message' => 'Disabling this module will also disable: ' . implode(', ', $cascade),
                ]);
                return true;
            }

            // Proceed with cascade disable
            Setting::set($key, '0');
            foreach ($cascade as $dep) {
                Setting::set('module_enabled_' . strtolower($dep), '0');
            }
        } else {
            // Enabling — check that all requirements are active
            $requirements = DependencyResolver::getRequirements($moduleName);
            $missingDeps = [];
            foreach ($requirements as $req) {
                // Core modules are always active, skip them
                if ($this->isCoreModule($req)) {
                    continue;
                }
                $reqKey = 'module_enabled_' . strtolower($req);
                if (!Setting::getBool($reqKey, true)) {
                    $missingDeps[] = $req;
                }
            }

            $force = ($_POST['force'] ?? $_GET['force'] ?? '0') === '1';

            if (!empty($missingDeps) && !$force) {
                // Ask user to confirm enabling dependencies
                $this->jsonResponse([
                    'status' => 'confirm_enable_deps',
                    'module' => $moduleName,
                    'missing_deps' => $missingDeps,
                    'message' => 'This module requires: ' . implode(', ', $missingDeps) . ' (currently disabled)',
                ]);
                return true;
            }

            // Enable the module and its missing dependencies
            Setting::set($key, '1');
            foreach ($missingDeps as $dep) {
                Setting::set('module_enabled_' . strtolower($dep), '1');
            }
        }

        ModuleManager::regenerate();
        DependencyResolver::invalidate();

        // Detect setup URL
        $setupUrl = $this->findSetupUrl($moduleName);

        $this->jsonResponse([
            'status' => 'success',
            'module' => $moduleName,
            'enabled' => $newState,
            'setup_url' => $setupUrl,
            'message' => $newState
                ? Trans::_('module_enabled')
                : Trans::_('module_disabled'),
        ]);

        return true;
    }

    /**
     * Disable all non-core modules.
     */
    public function doDisableAll(): bool
    {
        $modules = $this->getDiscoveredModules();
        foreach ($modules as $module) {
            if (!$module['is_core']) {
                Setting::set('module_enabled_' . strtolower($module['name']), '0');
            }
        }

        ModuleManager::regenerate();
        DependencyResolver::invalidate();
        $this->jsonResponse(['status' => 'success', 'message' => Trans::_('all_modules_disabled')]);
        return true;
    }

    /**
     * Enable all discovered modules.
     */
    public function doEnableAll(): bool
    {
        $modules = $this->getDiscoveredModules();
        foreach ($modules as $module) {
            Setting::set('module_enabled_' . strtolower($module['name']), '1');
        }

        ModuleManager::regenerate();
        DependencyResolver::invalidate();
        $this->jsonResponse(['status' => 'success', 'message' => Trans::_('all_modules_enabled')]);
        return true;
    }

    /**
     * Discover all available modules with metadata, state, and dependencies.
     *
     * @return array
     */
    protected function getDiscoveredModules(): array
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

                $isCoreModule = $route['namespace'] === 'Modules';
                $key = 'module_enabled_' . strtolower($dirName);

                // Read ModuleInfo metadata if Module.php exists
                $metadata = $this->readModuleMetadata($modulesPath . '/' . $dirName, $route['namespace'], $dirName);

                // App-level core modules (ModuleInfo::core = true) are always enabled
                $isAppCore = $metadata['core'] ?? false;
                $enabled = ($isCoreModule || $isAppCore) ? true : Setting::getBool($key, true);

                // Check for SetupController
                $setupUrl = $this->findSetupUrl($dirName);

                $modules[] = [
                    'name' => $dirName,
                    'namespace' => $route['namespace'],
                    'path' => $modulesPath . '/' . $dirName,
                    'enabled' => $enabled,
                    'is_core' => $isCoreModule || $isAppCore,
                    'description' => $metadata['description'] ?? '',
                    'icon' => $metadata['icon'] ?? 'fas fa-puzzle-piece',
                    'setup_url' => $setupUrl ?? $metadata['setup_url'] ?? null,
                    'requires' => DependencyResolver::getRequirements($dirName),
                    'dependents' => DependencyResolver::getDependents($dirName),
                ];
            }
        }

        return $modules;
    }

    /**
     * Read ModuleInfo attribute from Module.php if it exists.
     */
    private function readModuleMetadata(string $modulePath, string $nsPrefix, string $moduleName): array
    {
        $moduleFile = $modulePath . '/Module.php';
        if (!file_exists($moduleFile)) {
            return [];
        }

        try {
            $fqcn = $nsPrefix . '\\' . $moduleName . '\\Module';
            if (!class_exists($fqcn, true)) {
                return [];
            }
            $ref = new \ReflectionClass($fqcn);
            $attrs = $ref->getAttributes(ModuleInfo::class);
            if (empty($attrs)) {
                return [];
            }
            $info = $attrs[0]->newInstance();
            return [
                'description' => $info->description,
                'icon' => $info->icon,
                'core' => $info->core,
                'setup_url' => $info->setupController
                    ? "index.php?module={$moduleName}&controller=Setup"
                    : null,
            ];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Finds if a module has a SetupController.php file.
     */
    private function findSetupUrl(string $moduleName): ?string
    {
        $routes = ModuleManager::routes();
        foreach ($routes as $route) {
            $path = $route['path'] . '/' . $moduleName . '/Controller/SetupController.php';
            if (is_dir($route['path'] . '/' . $moduleName) && file_exists($path)) {
                return "index.php?module={$moduleName}&controller=Setup";
            }
        }
        return null;
    }

    /**
     * Check if a module is a core module (cannot be disabled).
     */
    private function isCoreModule(string $moduleName): bool
    {
        $routes = ModuleManager::routes();
        foreach ($routes as $route) {
            if ($route['namespace'] === 'Modules') {
                if (is_dir($route['path'] . '/' . $moduleName)) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function getModelClass()
    {
        return null;
    }
}
