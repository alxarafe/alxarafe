<?php

declare(strict_types=1);

namespace Alxarafe\Service;

/**
 * HookService - Permite la inyección de código y UI entre módulos.
 * 
 * Basado en el patrón Observer/Event. Los módulos pueden registrar 'hooks'
 * para añadir elementos a la UI o lógica de negocio de otros módulos de forma desacoplada.
 */
class HookService
{
    private static array $hooks = [];

    /**
     * Registra un callback para un hook específico.
     * 
     * @param string $hookName Nombre del hook (ej: 'ui.order.buttons')
     * @param callable $callback Función que devuelve contenido o realiza una acción
     * @param int $priority Prioridad de ejecución (menor número = antes)
     */
    public static function add(string $hookName, callable $callback, int $priority = 10): void
    {
        self::$hooks[$hookName][] = [
            'callback' => $callback,
            'priority' => $priority
        ];

        // Re-ordenar por prioridad
        usort(self::$hooks[$hookName], fn($a, $b) => $a['priority'] <=> $b['priority']);
    }

    /**
     * Ejecuta todos los callbacks registrados para un hook y devuelve los resultados.
     * 
     * @param string $hookName
     * @param mixed ...$args Argumentos para pasar al callback (ej: el modelo actual)
     * @return array Lista de resultados recogidos de todos los módulos
     */
    public static function execute(string $hookName, ...$args): array
    {
        if (!isset(self::$hooks[$hookName])) {
            return [];
        }

        $results = [];
        foreach (self::$hooks[$hookName] as $hook) {
            $results[] = call_user_func_array($hook['callback'], $args);
        }

        return $results;
    }

    /**
     * Versión simplificada para hooks que devuelven strings (HTML).
     */
    public static function render(string $hookName, ...$args): string
    {
        return implode('', self::execute($hookName, ...$args));
    }
}
