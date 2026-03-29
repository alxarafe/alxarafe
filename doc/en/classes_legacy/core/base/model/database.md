# Database (Data Manager)

::: info
**Namespace:** `Alxarafe\Base`  
**Extends:** `Illuminate\Database\Capsule\Manager`  
**Status:** 🛠️ Refactored to PHP 8.5.1
:::

The `Database` class is the heart of persistence in Alxarafe. It inherits directly from the **Eloquent** capsule, allowing the Laravel ORM to be used independently, adding diagnostic and auto-installation tools.

## DebugBar Integration
In development mode, the class automatically detects the presence of `DebugBar`. If active, it adds a PDO collector (`PDOCollector`), allowing inspection of all executed SQL queries, their response time, and potential errors directly from the browser.

## Connectivity and Schema Management

The connection flow is highly preventive and divided into three levels:

| Level | Method | Purpose |
| :--- | :--- | :--- |
| **Server** | `checkConnection()` | Verifies if the host is reachable and user credentials are valid. |
| **Existence** | `checkIfDatabaseExists()` | Confirms if the specific database has already been created. |
| **Creation** | `createDatabaseIfNotExists()` | Attempts to create the database if the user has permissions to do so. |

## Manual Usage Example

Although usually initialized from the core, it can be used to validate credentials in an installer:

```php
$data = (object)[
    'type' => 'mysql',
    'host' => 'localhost',
    'name' => 'new_db',
    'user' => 'root',
    'pass' => 'secret'
];

if (Database::checkDatabaseConnection($data, create: true)) {
    new Database($data);
}
```

## Technical Changes (v8.5.1)

- Strict Typing: Added `declare(strict_types=1)` and defined types on all parameters.
- Creation Security: Added basic character cleansing on the database name to prevent SQL injections in DDL commands.
- Logic Refactoring: The `checkDatabaseConnection` method now uses a cleaner and more direct return expression.
- DebugBar Compatibility: Simplified collector check to avoid unnecessary exceptions if the collector already exists.
