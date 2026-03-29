# Clases Base – Referencia de API

`Namespace: Alxarafe\Base`

Clases fundacionales para configuración, base de datos, renderizado de plantillas y seeding de datos.

---

## `Config` (abstract)

**Namespace:** `Alxarafe\Base\Config`

Gestiona el archivo de configuración (`config.json`), migraciones y seeders. Todos los métodos son estáticos.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `getConfig()` | `static getConfig(bool $reload = false): ?stdClass` | Obtiene configuración. Recarga si `$reload = true`. |
| `setConfig()` | `static setConfig(stdClass $data): bool` | Fusiona datos y guarda en disco. |
| `saveConfig()` | `static saveConfig(): bool` | Escribe config actual a `config.json`. |
| `registerSection()` | `static registerSection(string $section, array $keys): void` | Registra secciones personalizadas. |
| `doRunMigrations()` | `static doRunMigrations(): bool` | Ejecuta todas las migraciones pendientes. |
| `runSeeders()` | `static runSeeders(): bool` | Ejecuta todos los seeders. |

---

## `Database`

**Extiende:** `Illuminate\Database\Capsule\Manager`

Gestiona conexiones de BD, creación de esquemas e integración con DebugBar.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `__construct()` | `__construct(stdClass $db)` | Inicializa conexión e integra DebugBar. |
| `checkDatabaseConnection()` | `static checkDatabaseConnection(stdClass $data, bool $create): bool` | Valida conexión; opcionalmente crea BD. |
| `getDbDrivers()` | `static getDbDrivers(): array` | Drivers soportados: `mysql`, `pgsql`. |

---

## `Model` (abstract)

**Extiende:** `Illuminate\Database\Eloquent\Model`

Modelo base con inspección de esquema y metadatos de campos para auto-generación de UI.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `existsInSchema()` | `existsInSchema(): bool` | Verifica si la tabla existe. |
| `getFields()` | `static getFields(): array` | Metadatos de campos: `field`, `label`, `genericType`, etc. |

---

## `Template`

Gestiona compilación y renderizado de plantillas Blade.

## `BladeContainer`

Wrapper singleton sobre `Jenssegers\Blade\Blade`.

## `Seeder` (abstract)

Clase base para seeders de BD. Auto-descubiertos desde `Modules/{Module}/Seeders/`.

## Traits de Modelo

- **`DtoTrait`**: Métodos de Data Transfer Object para serialización.
- **`HasAuditLog`**: Logging automático de cambios en modelos.
