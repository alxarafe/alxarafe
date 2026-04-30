# Base Classes – API Reference

`Namespace: Alxarafe\Base`

Core foundation classes for configuration, database, template rendering, and data seeding.

---

## `Config` (abstract)

**Namespace:** `Alxarafe\Base\Config`  
**Source:** [Config.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Base/Config.php)

Manages the application configuration file (`config.json`), database migrations, and seeders. All methods are static.

### Configuration Structure

```json
{
  "main": { "path": "", "url": "", "data": "", "theme": "default", "language": "en", "timezone": "" },
  "db":   { "type": "mysql", "host": "localhost", "user": "", "pass": "", "name": "", "port": 3306, "prefix": "", "charset": "utf8mb4", "collation": "utf8mb4_unicode_ci" },
  "security": { "debug": false, "unique_id": "", "https": false, "jwt_secret_key": "" }
}
```

### Methods

| Method | Signature | Description |
|---|---|---|
| `getConfig()` | `static getConfig(bool $reload = false): ?stdClass` | Retrieves config. Reloads from disk if `$reload = true`. |
| `setConfig()` | `static setConfig(stdClass $data): bool` | Merges data into config and saves to disk. |
| `saveConfig()` | `static saveConfig(): bool` | Writes current config to `config.json`. |
| `getConfigFilename()` | `static getConfigFilename(): string` | Resolves the config file path (searches `APP_PATH/config/`, `APP_PATH/`, `ALX_PATH/config/`, `ALX_PATH/skeleton/config/`). |
| `getPublicRoot()` | `static getPublicRoot(): string` | Returns the public directory path. |
| `registerSection()` | `static registerSection(string $section, array $keys = []): void` | Register custom config sections from apps/plugins. |
| `getConfigStructure()` | `static getConfigStructure(): array` | Returns merged core + custom config structure. |
| `getDefaultMainFileInfo()` | `static getDefaultMainFileInfo(): stdClass` | Returns default `main` section values from constants. |
| `doRunMigrations()` | `static doRunMigrations(): bool` | Executes all pending database migrations. |
| `getMigrations()` | `static getMigrations(): array` | Collects migration files from all registered modules. |
| `runSeeders()` | `static runSeeders(): bool` | Runs all database seeders from registered modules. |

### Example

```php
use Alxarafe\Base\Config;

// Read config
$config = Config::getConfig();
$dbHost = $config->db->host;

// Register custom section
Config::registerSection('blog', ['posts_per_page', 'enable_comments']);

// Update config
Config::setConfig((object)['blog' => (object)['posts_per_page' => 10]]);
```

---

## `Database`

**Namespace:** `Alxarafe\Base\Database`  
**Extends:** `Illuminate\Database\Capsule\Manager`  
**Source:** [Database.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Base/Database.php)

Extends Illuminate Capsule to manage database connections, schema creation, and DebugBar integration.

### Methods

| Method | Signature | Description |
|---|---|---|
| `__construct()` | `__construct(stdClass $db)` | Initializes connection, boots Eloquent, integrates DebugBar PDO collector. |
| `createConnection()` | `static createConnection(stdClass $db): self` | Factory method (singleton pattern). |
| `getDbDrivers()` | `static getDbDrivers(): array` | Returns supported drivers: `['mysql' => 'MySQL', 'pgsql' => 'PostgreSQL']`. |
| `checkDatabaseConnection()` | `static checkDatabaseConnection(stdClass $data, bool $create = false): bool` | Validates connection; optionally creates DB. |
| `checkConnection()` | `static checkConnection(stdClass $data, bool $quiet = false): bool` | Checks if DB engine is reachable. |
| `checkIfDatabaseExists()` | `static checkIfDatabaseExists(stdClass $data, bool $quiet = false): bool` | Checks if specific database exists. |
| `createDatabaseIfNotExists()` | `static createDatabaseIfNotExists(stdClass $data): bool` | Creates the database schema. |

---

## `Model` (abstract)

**Namespace:** `Alxarafe\Base\Model\Model`  
**Extends:** `Illuminate\Database\Eloquent\Model`  
**Source:** [Model.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Base/Model/Model.php)

Base model providing schema inspection and field metadata for UI auto-generation.

### Methods

| Method | Signature | Description |
|---|---|---|
| `existsInSchema()` | `public existsInSchema(): bool` | Checks if the model's table exists in the database. |
| `primaryColumn()` | `public primaryColumn(): string` | Returns primary key column name. |
| `getFields()` | `static getFields(): array<string, array>` | Returns field metadata from `SHOW COLUMNS`: `field`, `label`, `genericType`, `dbType`, `required`, `length`, `nullable`, `default`. |

### Generic Type Mapping

| DB Type | Generic Type |
|---|---|
| `bool`, `tinyint` | `boolean` |
| `int`, `bigint`, etc. | `integer` |
| `decimal`, `float`, `double` | `decimal` |
| `datetime`, `timestamp` | `datetime` |
| `date` | `date` |
| `time` | `time` |
| `text`, `blob` | `textarea` |
| Everything else | `text` |

### Example

```php
namespace Modules\Blog\Model;

use Alxarafe\Base\Model\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['title', 'body', 'status', 'slug'];
    
    // All Eloquent features available (relationships, scopes, etc.)
}
```

---

## `Seeder` (abstract)

**Namespace:** `Alxarafe\Base\Seeder`  
**Source:** [Seeder.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Base/Seeder.php)

Base class for database seeders. Seeders are discovered automatically from `Modules/{Module}/Seeders/` directories.

---

## `Template`

**Namespace:** `Alxarafe\Base\Template`  
**Source:** [Template.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Base/Template.php)

Manages Blade template compilation and rendering. Wraps `BladeContainer` with path management and variable injection.

### Methods

| Method | Signature | Description |
|---|---|---|
| `setTemplateName()` | `public setTemplateName(?string $name): void` | Sets the template to render. |
| `getTemplateName()` | `public getTemplateName(): ?string` | Gets current template name. |
| `setPaths()` | `public setPaths(array $paths): void` | Sets template search paths. |
| `addPath()` | `public addPath(string $path): void` | Appends a search path. |
| `render()` | `public render(?string $viewPath, array $data): string` | Compiles and returns rendered HTML. |

---

## `BladeContainer`

**Namespace:** `Alxarafe\Base\BladeContainer`  
**Source:** [BladeContainer.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Base/BladeContainer.php)

Singleton wrapper around `Jenssegers\Blade\Blade`. Manages the Blade instance lifecycle with dynamic path registration.

---

## Model Trait

### `DtoTrait`

**Namespace:** `Alxarafe\Base\Model\Trait\DtoTrait`  
**Source:** [DtoTrait.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Base/Model/Trait/DtoTrait.php)

Provides Data Transfer Object methods for models — serializing model data for API/view consumption.

### `HasAuditLog`

**Namespace:** `Alxarafe\Base\Model\Trait\HasAuditLog`  
**Source:** [HasAuditLog.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Base/Model/Trait/HasAuditLog.php)

Adds automatic audit logging to model changes (create, update, delete). Writes entries to the `sys_audit_logs` table.
