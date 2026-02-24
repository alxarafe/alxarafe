# DbTrait

::: info
**Namespace:** `Alxarafe\Base\Controller\Trait`  
**Usage:** Injected into controllers requiring data access.  
**Status:** 🛠️ Refactored to PHP 8.5.1
:::

The `DbTrait` provides an abstraction layer for managing database connections within controllers. It implements a pattern similar to *Singleton* to ensure multiple unnecessary connections are not created during the request lifecycle.

## Main Functionality

The Trait manages a simplified static property `$db` containing the active database instance.

### `connectDb()` Method
This method is responsible for initializing the connection.
- If an active connection already exists, it returns `true` immediately.
- If valid configuration is provided, it uses `Database::checkDatabaseConnection()` to validate credentials before instantiating the object.

## Static Properties

| Property | Type | Description |
| :--- | :--- | :--- |
| `$db` | `?Database` | Global database instance for the controller context. |

## Usage Example in a Controller

```php
namespace Alxarafe\Controller;

use Alxarafe\Base\Controller\GenericController;
use Alxarafe\Base\Controller\Trait\DbTrait;

class MyController extends GenericController
{
    use DbTrait;

    public function __construct($action = null)
    {
        parent::__construct($action);
        // Attempt to connect with default configuration
        static::connectDb($this->config->db);
    }
}
```

## Technical Changes (v8.5.1)

- Strict Typing: Added `declare(strict_types=1)` and explicit typing in method parameters.
- Instance Validation: Use of `instanceof` for more robust verification of the static property `$db`.
- Logic Simplification: Optimized configuration check flow to avoid unnecessary nesting.
