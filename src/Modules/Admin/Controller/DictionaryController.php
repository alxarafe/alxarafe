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
use Alxarafe\Base\Controller\ResourceController;

/**
 * Class DictionaryController.
 *
 * Generic CRUD controller for any reference/lookup table.
 * Accepts a model class name via ?model= parameter and auto-generates
 * list columns and edit fields from the model's schema.
 *
 * This eliminates the need to write individual controllers for
 * dozens of dictionary tables (countries, currencies, payment types, etc.).
 *
 * Usage: index.php?module=Admin&controller=Dictionary&model=CCountry
 */
#[Menu(menu: 'main_menu', label: 'Dictionaries', icon: 'fas fa-book', order: 20, parent: 'Configuration')]
class DictionaryController extends ResourceController
{
    /**
     * Allowed model namespace prefixes for security.
     * Only models in these namespaces can be accessed.
     *
     * Applications can extend this array via beforeConfig().
     */
    protected array $allowedNamespaces = [
        'CoreModules\\',
        'Modules\\',
        'Plugins\\',
    ];

    /**
     * Resolved model class name.
     */
    private ?string $resolvedModelClass = null;

    /**
     * Resolve the model class from the ?model= parameter.
     *
     * @return string
     */
    #[\Override]
    protected function getModelClass()
    {
        if ($this->resolvedModelClass) {
            return $this->resolvedModelClass;
        }

        $modelParam = $_GET['model'] ?? '';

        if (empty($modelParam)) {
            // If no model specified, show a placeholder
            return $this->getFallbackModelClass();
        }

        $this->resolvedModelClass = $this->resolveModelClass($modelParam);
        return $this->resolvedModelClass;
    }

    /**
     * Resolve a model parameter to a fully qualified class name.
     *
     * Tries several resolution strategies:
     * 1. Direct FQCN (if already fully qualified and in allowed namespace)
     * 2. Common namespace patterns (CoreModules\*\Model\*, Modules\*\Model\*, etc.)
     *
     * @param string $model Short or full model name
     * @return string Resolved FQCN
     * @throws \RuntimeException If model cannot be resolved or is not allowed
     */
    private function resolveModelClass(string $model): string
    {
        // Security: strip directory traversal attempts
        $model = str_replace(['/', '..', "\0"], '', $model);

        // Strategy 1: Direct FQCN with namespace separators
        if (str_contains($model, '\\') && class_exists($model)) {
            $this->validateNamespace($model);
            return $model;
        }

        // Strategy 2: Try common namespace patterns
        $candidates = [];

        // Try CoreModules\*\Model\{Model}
        $moduleDirs = glob(defined('ALX_PATH') ? constant('ALX_PATH') . '/Modules/*' : __DIR__ . '/../../*', GLOB_ONLYDIR);
        if ($moduleDirs) {
            foreach ($moduleDirs as $dir) {
                $moduleName = basename($dir);
                $candidates[] = "CoreModules\\{$moduleName}\\Model\\{$model}";
            }
        }

        // Try Modules (skeleton)
        $skeletonDirs = glob(defined('BASE_PATH') ? constant('BASE_PATH') . '/Modules/*' : '', GLOB_ONLYDIR);
        if ($skeletonDirs) {
            foreach ($skeletonDirs as $dir) {
                $moduleName = basename($dir);
                $candidates[] = "Modules\\{$moduleName}\\Model\\{$model}";
            }
        }

        // Try Plugins
        $pluginDirs = glob(defined('BASE_PATH') ? constant('BASE_PATH') . '/plugins/*/Model' : '', GLOB_ONLYDIR);
        if ($pluginDirs) {
            foreach ($pluginDirs as $dir) {
                $pluginName = basename(dirname($dir));
                $candidates[] = "Plugins\\{$pluginName}\\Model\\{$model}";
            }
        }

        foreach ($candidates as $fqcn) {
            if (class_exists($fqcn)) {
                $this->validateNamespace($fqcn);
                return $fqcn;
            }
        }

        throw new \RuntimeException("Dictionary model not found: {$model}");
    }

    /**
     * Validate that a model class is in an allowed namespace.
     *
     * @throws \RuntimeException If namespace is not allowed
     */
    private function validateNamespace(string $fqcn): void
    {
        foreach ($this->allowedNamespaces as $ns) {
            if (str_starts_with($fqcn, $ns)) {
                return;
            }
        }
        throw new \RuntimeException("Model namespace not allowed: {$fqcn}");
    }

    /**
     * Returns a fallback model class when no ?model= parameter is given.
     * Override in child classes for a specific default.
     */
    protected function getFallbackModelClass(): string
    {
        // Default: use the Setting model as a safe fallback
        return \CoreModules\Admin\Model\Setting::class;
    }

    /**
     * Override title to show the model name.
     */
    public function getTitle(): string
    {
        $model = $_GET['model'] ?? 'Dictionary';
        return \Alxarafe\Lib\Trans::_('dictionary') . ': ' . $model;
    }
}
