<?php

/**
 * collect_feedback.php — Recolector de propuestas de apps satélite
 *
 * Busca ficheros .yml en los directorios .alxarafe/feedback/ de las apps
 * del workspace, los valida y genera un informe.
 *
 * Uso:
 *   php src/Scripts/collect_feedback.php [--copy]
 *
 * Opciones:
 *   --copy   Copia las propuestas válidas a doc/feedback/proposals/
 *
 * @package Alxarafe\Scripts
 */

declare(strict_types=1);

namespace Alxarafe\Scripts;

// ---------------------------------------------------------------------------
// Bootstrap: localizar el directorio raíz de Alxarafe
// ---------------------------------------------------------------------------
$coreRoot = dirname(__DIR__, 2); // src/Scripts/../../ = raíz de alxarafe
$vendorAutoload = $coreRoot . '/vendor/autoload.php';

if (file_exists($vendorAutoload)) {
    require_once $vendorAutoload;
}

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

// ---------------------------------------------------------------------------
// Configuración
// ---------------------------------------------------------------------------

/** Campos obligatorios en cada propuesta */
const REQUIRED_FIELDS = ['id', 'title', 'app', 'date', 'priority', 'category', 'description', 'use_case'];

/** Valores válidos por campo */
const VALID_VALUES = [
    'priority' => ['high', 'medium', 'low'],
    'category' => ['feature', 'bugfix', 'improvement', 'breaking'],
];

// ---------------------------------------------------------------------------
// Funciones de utilidad
// ---------------------------------------------------------------------------

function output(string $message, string $type = 'info'): void
{
    $prefix = match ($type) {
        'ok'    => "\033[32m  ✓\033[0m ",
        'warn'  => "\033[33m  ⚠\033[0m ",
        'error' => "\033[31m  ✗\033[0m ",
        'title' => "\033[1;36m",
        default => "    ",
    };
    $suffix = $type === 'title' ? "\033[0m" : '';
    echo $prefix . $message . $suffix . PHP_EOL;
}

function banner(): void
{
    echo PHP_EOL;
    echo "\033[1;36m╔══════════════════════════════════════════════════════╗\033[0m" . PHP_EOL;
    echo "\033[1;36m║   Alxarafe — Feedback Collector                     ║\033[0m" . PHP_EOL;
    echo "\033[1;36m╚══════════════════════════════════════════════════════╝\033[0m" . PHP_EOL;
    echo PHP_EOL;
}

/**
 * Busca directorios de apps satélite en el directorio padre del workspace.
 * Convencion: busca carpetas hermanas que contengan .alxarafe/feedback/
 *
 * @return array<string, string> [appName => feedbackDir]
 */
function discoverApps(string $coreRoot): array
{
    $apps = [];
    $workspaceRoot = dirname($coreRoot); // un nivel arriba de alxarafe/

    $dirs = glob($workspaceRoot . '/*', GLOB_ONLYDIR);
    if ($dirs === false) {
        return $apps;
    }

    foreach ($dirs as $dir) {
        // Ignorar el propio core
        if (realpath($dir) === realpath($coreRoot)) {
            continue;
        }

        $feedbackDir = $dir . '/.alxarafe/feedback';
        if (is_dir($feedbackDir)) {
            $appName = basename($dir);
            $apps[$appName] = $feedbackDir;
        }
    }

    return $apps;
}

/**
 * Valida una propuesta parseada contra el esquema esperado.
 *
 * @return string[] Lista de errores encontrados (vacío si OK)
 */
function validateProposal(array $data, string $filename): array
{
    $errors = [];

    // Campos requeridos
    foreach (REQUIRED_FIELDS as $field) {
        if (!isset($data[$field]) || (is_string($data[$field]) && trim($data[$field]) === '')) {
            $errors[] = "Campo obligatorio ausente o vacío: '{$field}'";
        }
    }

    // Valores válidos
    foreach (VALID_VALUES as $field => $allowed) {
        if (isset($data[$field]) && !in_array($data[$field], $allowed, true)) {
            $errors[] = "Valor inválido para '{$field}': '{$data[$field]}'. Esperado: " . implode(', ', $allowed);
        }
    }

    // Formato de fecha
    if (isset($data['date'])) {
        $parsed = \DateTimeImmutable::createFromFormat('Y-m-d', $data['date']);
        if ($parsed === false) {
            $errors[] = "Formato de fecha inválido: '{$data['date']}'. Esperado: YYYY-MM-DD";
        }
    }

    return $errors;
}

// ---------------------------------------------------------------------------
// Main
// ---------------------------------------------------------------------------

banner();

$shouldCopy = in_array('--copy', $argv ?? [], true);
$apps = discoverApps($coreRoot);

if (empty($apps)) {
    output("No se encontraron apps satélite con .alxarafe/feedback/ en el workspace.", 'warn');
    output("Las apps deben estar en directorios hermanos de: {$coreRoot}");
    output("Cada app debe tener un directorio .alxarafe/feedback/ con ficheros .yml");
    echo PHP_EOL;
    exit(0);
}

output(count($apps) . " app(s) encontrada(s):", 'title');
echo PHP_EOL;

$totalProposals = 0;
$totalValid = 0;
$totalErrors = 0;
$allProposals = [];

foreach ($apps as $appName => $feedbackDir) {
    output("📦 {$appName}", 'title');
    output("Directorio: {$feedbackDir}");

    $files = glob($feedbackDir . '/*.yml');
    if ($files === false || empty($files)) {
        output("Sin propuestas .yml", 'warn');
        echo PHP_EOL;
        continue;
    }

    foreach ($files as $file) {
        $filename = basename($file);
        $totalProposals++;

        try {
            $data = Yaml::parseFile($file);
        } catch (ParseException $e) {
            output("{$filename}: YAML inválido — {$e->getMessage()}", 'error');
            $totalErrors++;
            continue;
        }

        if (!is_array($data)) {
            output("{$filename}: el fichero no contiene datos YAML válidos", 'error');
            $totalErrors++;
            continue;
        }

        $errors = validateProposal($data, $filename);

        if (empty($errors)) {
            $title = $data['title'] ?? '(sin título)';
            $priority = $data['priority'] ?? '?';
            $category = $data['category'] ?? '?';
            output("{$filename}: [{$priority}] [{$category}] {$title}", 'ok');
            $totalValid++;
            $allProposals[] = [
                'file' => $file,
                'data' => $data,
                'app'  => $appName,
            ];
        } else {
            output("{$filename}: {$errors[0]}", 'error');
            foreach (array_slice($errors, 1) as $err) {
                output("  → {$err}", 'error');
            }
            $totalErrors++;
        }
    }

    echo PHP_EOL;
}

// ---------------------------------------------------------------------------
// Resumen
// ---------------------------------------------------------------------------

echo "\033[1;36m══════════════════════════════════════════════════════════\033[0m" . PHP_EOL;
output("Resumen: {$totalProposals} propuesta(s), {$totalValid} válida(s), {$totalErrors} con errores", 'title');
echo PHP_EOL;

// ---------------------------------------------------------------------------
// Copiar propuestas si --copy
// ---------------------------------------------------------------------------

if ($shouldCopy && $totalValid > 0) {
    $proposalsDir = $coreRoot . '/doc/feedback/proposals';

    if (!is_dir($proposalsDir)) {
        mkdir($proposalsDir, 0755, true);
    }

    output("Copiando {$totalValid} propuesta(s) válida(s) a doc/feedback/proposals/", 'title');

    foreach ($allProposals as $proposal) {
        $appPrefix = strtoupper($proposal['app']);
        $id = $proposal['data']['id'] ?? '000';
        $destName = "{$appPrefix}-{$id}-" . basename($proposal['file']);
        $destPath = $proposalsDir . '/' . $destName;

        if (copy($proposal['file'], $destPath)) {
            output("→ {$destName}", 'ok');
        } else {
            output("No se pudo copiar: {$proposal['file']}", 'error');
        }
    }
    echo PHP_EOL;
}

if (!$shouldCopy && $totalValid > 0) {
    output("Usa --copy para copiar las propuestas válidas al core.", 'info');
    echo PHP_EOL;
}

exit($totalErrors > 0 ? 1 : 0);
