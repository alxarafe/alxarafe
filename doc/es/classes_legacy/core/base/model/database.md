# Database (Gestor de Datos)

::: info
**Namespace:** `Alxarafe\Base`  
**Extiende:** `Illuminate\Database\Capsule\Manager`  
**Estado:** 🛠️ Refactorizado a php 8.2
:::

La clase `Database` es el corazón de la persistencia en Alxarafe. Hereda directamente de la cápsula de **Eloquent**, lo que permite utilizar el ORM de Laravel de forma independiente, añadiendo herramientas de diagnóstico y auto-instalación.

## Integración con DebugBar
En modo desarrollo, la clase detecta automáticamente la presencia de la `DebugBar`. Si está activa, añade un colector de PDO (`PDOCollector`), permitiendo inspeccionar todas las consultas SQL ejecutadas, su tiempo de respuesta y posibles errores directamente desde el navegador.

## Gestión de Conectividad y Esquema

El flujo de conexión es altamente preventivo y se divide en tres niveles:

| Nivel | Método | Propósito |
| :--- | :--- | :--- |
| **Servidor** | `checkConnection()` | Verifica si el host es alcanzable y los credenciales de usuario son válidos. |
| **Existencia** | `checkIfDatabaseExists()` | Confirma si la base de datos específica ya ha sido creada. |
| **Creación** | `createDatabaseIfNotExists()` | Intenta crear la base de datos si el usuario tiene permisos para ello. |

## Ejemplo de Uso Manual

Aunque se suele inicializar desde el núcleo, se puede usar para validar credenciales en un instalador:

```php
$data = (object)[
    'type' => 'mysql',
    'host' => 'localhost',
    'name' => 'nueva_db',
    'user' => 'root',
    'pass' => 'secret'
];

if (Database::checkDatabaseConnection($data, create: true)) {
    new Database($data);
}
```

## Cambios Técnicos (v8.5.1)

- Tipado Estricto: Se ha añadido declare(strict_types=1) y tipos definidos en todos los parámetros.
- Seguridad en Creación: Se ha añadido una limpieza básica de caracteres en el nombre de la base de datos para prevenir inyecciones SQL en comandos DDL.
- Refactorización de Lógica: El método checkDatabaseConnection ahora utiliza una expresión de retorno más limpia y directa.
- Compatibilidad DebugBar: Se ha simplificado la comprobación del colector para evitar excepciones innecesarias si el colector ya existe.
