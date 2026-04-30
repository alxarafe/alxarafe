# Config (Gestión de Sistema)

::: info
**Namespace:** `Alxarafe\Base`  
**Archivo físico:** `config.json` (fuera del Document Root)  
**Estado:** 🛠️ Refactorizado a php 8.2
:::

La clase `Config` es el centro de control del framework. Se encarga de la persistencia de los ajustes globales y de coordinar la evolución de la base de datos mediante migraciones y seeders.

## Gestión de Configuración

El framework utiliza un archivo `config.json` para almacenar credenciales de base de datos, rutas de carpetas privadas y ajustes de seguridad.

- **Carga Automática:** La configuración se carga bajo demanda (*lazy loading*) y se mantiene en memoria para evitar accesos repetitivos a disco.
- **Validación de Estructura:** Solo se guardan los parámetros definidos en `CONFIG_STRUCTURE`, protegiendo el archivo de datos basura.

## Migraciones y Seeders



`Config` actúa como el motor de ejecución para la base de datos:

| Proceso | Método | Descripción |
| :--- | :--- | :--- |
| **Migraciones** | `doRunMigrations()` | Ejecuta archivos `.php` de migración en orden cronológico basándose en lotes (*batches*). |
| **Seeders** | `runSeeders()` | Puebla la base de datos con datos iniciales (provincias, roles, etc.) tras una instalación. |

## Métodos Destacados

- `getConfig(bool $reload)`: Punto de entrada principal para leer ajustes.
- `setConfig(stdClass $data)`: Actualiza el archivo físico y reinicia el sistema de depuración e idiomas.

## Cambios Técnicos (v8.5.1)

- **JSON Seguro:** Se ha implementado `JSON_THROW_ON_ERROR` en la carga de archivos para capturar sintaxis corruptas.
- **Operador Null Coalescing Assignment:** Uso de `??=` para una inicialización de secciones más limpia en `setConfig`.
- **Detección de Constantes:** Mejora en `getDefaultMainFileInfo` para evitar errores si `BASE_PATH` no está definida.
- **Tipado de Constantes:** Uso de `public const array` y `protected const string` para mayor claridad en el diseño.
