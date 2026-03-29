# Config (System Management)

::: info
**Namespace:** `Alxarafe\Base`  
**Physical File:** `config.json` (outside Document Root)  
**Status:** 🛠️ Refactored to PHP 8.5.1
:::

The `Config` class is the control center of the framework. It handles global settings persistence and coordinates database evolution via migrations and seeders.

## Configuration Management

The framework uses a `config.json` file to store database credentials, private folder paths, and security settings.

- **Automatic Loading:** Configuration is loaded on demand (*lazy loading*) and kept in memory to avoid repetitive disk access.
- **Structure Validation:** Only parameters defined in `CONFIG_STRUCTURE` are saved, protecting the file from garbage data.

## Migrations and Seeders

`Config` acts as the execution engine for the database:

| Process | Method | Description |
| :--- | :--- | :--- |
| **Migrations** | `doRunMigrations()` | Executes migration `.php` files in chronological order based on *batches*. |
| **Seeders** | `runSeeders()` | Populates the database with initial data (provinces, roles, etc.) after installation. |

## Featured Methods

- `getConfig(bool $reload)`: Main entry point for reading settings.
- `setConfig(stdClass $data)`: Updates the physical file and restarts the debug and language system.

## Technical Changes (v8.5.1)

- **Secure JSON:** Implemented `JSON_THROW_ON_ERROR` in file loading to capture corrupt syntax.
- **Null Coalescing Assignment Operator:** Use of `??=` for cleaner section initialization in `setConfig`.
- **Constant Detection:** Improvement in `getDefaultMainFileInfo` to avoid errors if `BASE_PATH` is not defined.
- **Constant Typing:** Use of `public const array` and `protected const string` for greater design clarity.
