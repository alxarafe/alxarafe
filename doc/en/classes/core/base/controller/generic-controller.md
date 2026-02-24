# Controller (Authenticated Base)

::: info
**Namespace:** `Alxarafe\Base\Controller`  
**Extends:** `ViewController`  
**Uses:** `DbTrait`  
:::

The `Controller` class is the base controller for all private sections of the application. Unlike the public controller, this imposes strict access and connectivity restrictions.

## Execution Requirements

When instantiating any class extending `Controller`, the following validations are automatically executed in the constructor:

1.  **Configuration Exclusion:** If the current controller is `ConfigController`, validations are skipped to allow initial system configuration.
2.  **Database Validation:** Checks that the database configuration exists and the connection is successful. If it fails, redirects the user to the configuration panel.
3.  **Authentication Control:** Verifies if the user is logged in. If not (and we are not already on the login page), automatically redirects to `AuthController`.

## Properties

| Property | Type | Description |
| :--- | :--- | :--- |
| `$username` | `?string` | Stores the authenticated user's name (extracted from `Auth::$user`). |

## Usage Example

```php
namespace Alxarafe\Controller;

use Alxarafe\Base\Controller\Controller;

class Dashboard extends Controller
{
    public function doIndex(): bool
    {
        // If we reach here, the user is logged in and DB connected.
        $this->addVariable('user', $this->username);
        return true;
    }
}
```

## Technical Changes (v8.5.1)

- Type Safety: `$username` typed as nullable string and strict mode activated.
- Nullsafe Operator: Use of `Auth::$user?->name` to avoid errors if the user object is not fully loaded.
- Readability: Validation flow in the constructor structured to be more linear and easier to debug.
