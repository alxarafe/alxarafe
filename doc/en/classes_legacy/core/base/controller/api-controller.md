# ApiController

::: info
**Namespace:** `Alxarafe\Base\Controller`  
**Uses:** `DbTrait`  
**Authentication:** JWT (JSON Web Tokens)  
**Status:** 🛠️ Refactored to PHP 8.5.1
:::

The `ApiController` is the base controller for building REST API services within the framework. Unlike view-based controllers, this one is optimized for communication via JSON objects and uses an execution flow that ends at buffer output.

## Key Features

### 1. Token Authentication
The controller automatically searches for a `token` parameter in the request (`$_REQUEST`). If it exists, it uses the **Firebase JWT** library to:
- Decode the token using the system security key defined in `Auth`.
- Identify the user and load them into the static property `static::$user`.

### 2. Standardized Responses
The class provides final methods to ensure all API outputs maintain the same consistent structure:
- `jsonResponse()`: For successful requests (HTTP 200 by default).
- `badApiCall()`: For client or server errors (HTTP 400 or 401 by default).

## Static Properties

| Property | Type | Description |
| :--- | :--- | :--- |
| `$user` | `?User` | User object identified after validating the JWT token. |

## Usage Example

```php
namespace Alxarafe\Controller\Api;

class ProfileController extends ApiController
{
    public function getInfo()
    {
        if (static::$user) {
            static::jsonResponse(['email' => static::$user->email]);
        }
        
        static::badApiCall('User not identified', 404);
    }
}
```

## Technical Changes (v8.5.1)

- Never Return Type: Response methods now use the `never` type, indicating script execution ends at that point.
- Debug Control: The `appendDebugInfo` method has been refined to include backtraces only if security is in debug mode.
- Internal Refactoring: Header sending has been centralized in the private `sendJsonResponse` method to avoid code duplication.
- JSON_THROW_ON_ERROR: Ensures the JSON encoder throws exceptions in case of serialization failure.
