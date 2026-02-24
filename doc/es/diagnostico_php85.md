# Diagnóstico y Plan de Adaptación a PHP 8.5.1 - Alxarafe

Este documento resume el estado actual del núcleo de **Alxarafe** y propone una hoja de ruta para aprovechar las capacidades de **PHP 8.5.1**.

## 1. Diagnóstico General de la Arquitectura

El núcleo del microframework presenta una base sólida pero con una deuda técnica acumulada en patrones que PHP 8.x permite modernizar.

### Puntos Críticos Identificados
*   **Dependencia de Estados Estáticos:** El uso extensivo de métodos estáticos en `Database`, `Trans`, `Debug` y `Routes` dificulta la testabilidad y el desacoplamiento.
*   **Abuso de `stdClass`:** Las configuraciones y el manejo de datos dependen de objetos anónimos, perdiendo los beneficios del tipado fuerte de PHP.
*   **Magia en DTOs:** El `DtoTrait` utiliza métodos mágicos (`__get`, `__set`) que pueden ser sustituidos por características nativas más eficientes.
*   **Manejo de Ciclo de Vida:** El uso de `die()` y `header()` dentro de funciones de librería interrumpe el flujo controlado de la aplicación.

---

## 2. Recomendaciones de Mejora para PHP 8.5.1

### A. Implementación de Property Hooks (PHP 8.4+)
Sustituir la lógica de métodos mágicos en `DtoTrait` por hooks nativos. Esto permite validaciones y transformaciones de datos directamente en la definición de la propiedad, mejorando el rendimiento y la legibilidad.

### B. Clases Readonly y DTOs Tipados
Migrar todas las estructuras de configuración (actualmente en `Config.php`) y objetos de datos a clases `readonly`.
*   **Beneficio:** Inmutabilidad garantizada y autocompletado total en el IDE sin depender de comentarios PHPDoc para `stdClass`.

### C. Constructor Property Promotion
Simplificar los constructores de controladores y servicios eliminando la declaración repetitiva de propiedades.

### D. Modernización del Sistema de Rutas y Dispatcher
*   **Caché de Rutas:** El sistema actual escanea directorios con `glob` en cada petición. Se recomienda implementar un generador de caché que produzca un mapa de rutas en un archivo PHP estático.
*   **Middleware:** Introducir una capa de middleware para manejar la autenticación y la inicialización, eliminando la lógica de redirección manual en los constructores de los controladores.

### E. Tipado Estricto y Retornos
Asegurar que todos los archivos incluyan `declare(strict_types=1);` y que todos los métodos tengan tipos de retorno definidos, eliminando el uso de `mixed` donde sea posible.

---

## 3. Hoja de Ruta Sugerida

1.  **Fase 1: Modernización de DTOs y Modelos**
    *   Refactorizar `DtoTrait` para usar Property Hooks.
    *   Introducir clases de datos para las configuraciones.
2.  **Fase 2: Limpieza de Dependencias**
    *   Actualizar componentes de Illuminate a la versión 11.
    *   Evaluar la sustitución de `jenssegers/blade` por el motor nativo de Illuminate\View.
3.  **Fase 3: Refactorización del Flujo de Ejecución**
    *   Migrar el `Dispatcher` a un modelo basado en eventos o middleware.
    *   Eliminar llamadas a `die()` y centralizar la gestión de respuestas HTTP.

---
*Documento generado por Junie (JetBrains AI) el 1 de febrero de 2026.*
