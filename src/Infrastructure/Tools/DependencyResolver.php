<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace Alxarafe\Infrastructure\Tools;

/**
 * Resolves inter-module dependencies by scanning PHP `use` statements.
 *
 * This class builds a directed dependency graph where an edge A → B means
 * "module A uses classes from module B". When module B is disabled, all
 * modules that depend on it (directly or transitively) must also be disabled.
 *
 * The dependency graph is cached to avoid re-scanning on every request.
 *
 * @see doc/modules-and-dependencies.md for architecture documentation.
 */
class DependencyResolver
{
    /**
     * Cache of the dependency graph.
     * Structure: ['ModuleName' => ['DependsOnModule1', 'DependsOnModule2', ...]]
     */
    private static ?array $graph = null;

    /**
     * Path to the cached dependency graph file.
     */
    private static function getCachePath(): string
    {
        $basePath = realpath(constant('BASE_PATH') . '/..');
        return $basePath . '/var/cache/dependency_graph.php';
    }

    /**
     * Build (or load from cache) the full dependency graph.
     *
     * @return array<string, string[]> Map of module → modules it depends on.
     */
    public static function buildGraph(): array
    {
        if (self::$graph !== null) {
            return self::$graph;
        }

        $cachePath = self::getCachePath();
        if (file_exists($cachePath)) {
            self::$graph = include $cachePath;
            if (is_array(self::$graph)) {
                return self::$graph;
            }
        }

        self::$graph = self::scan();
        self::saveCache(self::$graph);

        return self::$graph;
    }

    /**
     * Invalidate the cached dependency graph.
     * Call this when modules are added, removed or their code changes.
     */
    public static function invalidate(): void
    {
        self::$graph = null;
        $cachePath = self::getCachePath();
        if (file_exists($cachePath)) {
            @unlink($cachePath);
        }
    }

    /**
     * Get the list of modules that $module depends on.
     *
     * @param string $module Module name (e.g. 'Sales')
     * @return string[] List of required module names.
     */
    public static function getRequirements(string $module): array
    {
        $graph = self::buildGraph();
        return $graph[$module] ?? [];
    }

    /**
     * Get the list of modules that depend on $module (reverse lookup).
     *
     * @param string $module Module name (e.g. 'CRM')
     * @return string[] Modules that would break if $module is disabled.
     */
    public static function getDependents(string $module): array
    {
        $graph = self::buildGraph();
        $dependents = [];
        foreach ($graph as $mod => $deps) {
            if (in_array($module, $deps, true)) {
                $dependents[] = $mod;
            }
        }
        return $dependents;
    }

    /**
     * Get ALL modules that would need to be disabled if $module is disabled.
     * This is a recursive/transitive closure of getDependents().
     *
     * @param string $module Module name to disable.
     * @return string[] Full cascade list (does not include $module itself).
     */
    public static function getCascadeDisable(string $module): array
    {
        $result = [];
        $queue = [$module];
        $visited = [$module => true];

        while (!empty($queue)) {
            $current = array_shift($queue);
            $dependents = self::getDependents($current);
            foreach ($dependents as $dep) {
                if (!isset($visited[$dep])) {
                    $visited[$dep] = true;
                    $result[] = $dep;
                    $queue[] = $dep;
                }
            }
        }

        return $result;
    }

    /**
     * Scan all module directories and extract cross-module dependencies
     * from PHP `use` statements.
     *
     * @return array<string, string[]>
     */
    private static function scan(): array
    {
        $routes = ModuleManager::routes();
        $graph = [];

        // Collect all module names and their paths
        $moduleMap = []; // name => [path, namespace_prefix]
        foreach ($routes as $route) {
            $modulesPath = $route['path'];
            $nsPrefix = $route['namespace']; // 'Modules' or 'Modules'
            if (!is_dir($modulesPath)) {
                continue;
            }
            $dirs = scandir($modulesPath);
            foreach ($dirs as $dir) {
                if ($dir === '.' || $dir === '..' || !is_dir($modulesPath . '/' . $dir)) {
                    continue;
                }
                $moduleMap[$dir] = [
                    'path' => $modulesPath . '/' . $dir,
                    'ns_prefix' => $nsPrefix,
                ];
                // Initialize graph node
                if (!isset($graph[$dir])) {
                    $graph[$dir] = [];
                }
            }
        }

        // For each module, scan its PHP files for `use` statements
        foreach ($moduleMap as $moduleName => $info) {
            $phpFiles = self::findPhpFiles($info['path']);
            foreach ($phpFiles as $file) {
                $uses = self::extractUseStatements($file);
                foreach ($uses as $fqcn) {
                    $depModule = self::resolveModuleFromNamespace($fqcn, $moduleMap);
                    if ($depModule !== null && $depModule !== $moduleName) {
                        if (!in_array($depModule, $graph[$moduleName], true)) {
                            $graph[$moduleName][] = $depModule;
                        }
                    }
                }
            }
        }

        return $graph;
    }

    /**
     * Find all .php files recursively in a directory.
     *
     * @return string[]
     */
    private static function findPhpFiles(string $directory): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        return $files;
    }

    /**
     * Extract `use` statements from a PHP file using simple regex.
     * This is intentionally lightweight — no full AST parsing needed.
     *
     * @return string[] List of fully qualified class names.
     */
    private static function extractUseStatements(string $filePath): array
    {
        $content = file_get_contents($filePath);
        if ($content === false) {
            return [];
        }

        $uses = [];
        // Match: use Modules\CRM\Controller\ThirdPartyController;
        // Match: use Modules\Admin\Model\Setting;
        if (preg_match_all('/^use\s+((?:Modules|Modules)\\\\[^;]+);/m', $content, $matches)) {
            $uses = $matches[1];
        }

        return $uses;
    }

    /**
     * Given a FQCN like "Modules\CRM\Controller\ThirdPartyController",
     * resolve it to the module name "CRM".
     *
     * @return string|null Module name, or null if not resolvable.
     */
    private static function resolveModuleFromNamespace(string $fqcn, array $moduleMap): ?string
    {
        // Expected patterns:
        // Modules\{ModuleName}\... 
        // Modules\{ModuleName}\...
        $parts = explode('\\', $fqcn);
        if (count($parts) < 2) {
            return null;
        }

        $prefix = $parts[0]; // 'Modules' or 'Modules'
        $moduleName = $parts[1];

        // Verify this module actually exists in our map
        if (isset($moduleMap[$moduleName])) {
            return $moduleName;
        }

        return null;
    }

    /**
     * Save the dependency graph to a PHP cache file.
     */
    private static function saveCache(array $graph): void
    {
        $cachePath = self::getCachePath();
        $dir = dirname($cachePath);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $export = var_export($graph, true);
        $content = "<?php\n// Auto-generated dependency graph — " . date('Y-m-d H:i:s') . "\nreturn {$export};\n";
        file_put_contents($cachePath, $content);
    }
}
