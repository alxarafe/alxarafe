# API Development in Alxarafe

Alxarafe facilitates the creation of RESTful APIs through dedicated controllers and an intelligent dispatcher. This document explains how to implement, document, and test API endpoints.

## 1. Structure of an API Controller

API controllers must:
1.  Be located in the `Api/` folder of your module (e.g., `Modules/Mymodule/Api/`).
2.  Extend `Alxarafe\Base\Controller\ApiController`.
3.  Have the `ApiController` suffix (recommended to differentiate from web controllers, although the dispatcher handles it).

### Example: `PersonApiController` (Skeleton)

Location: `skeleton/Modules/Agenda/Api/PersonApiController.php`

```php
<?php

namespace Modules\Agenda\Api;

use Alxarafe\Base\Controller\ApiController;
use Modules\Agenda\Model\Person;

/**
 * Class PersonApiController.
 *
 * API Endpoint for managing Person resources.
 *
 * @package Modules\Agenda\Api
 */
class PersonApiController extends ApiController
{
    /**
     * Retrieve a Person by ID.
     *
     * @param int $id The unique identifier of the person.
     * @return never Outputs JSON response and terminates execution.
     */
    public function get(int $id)
    {
        $person = Person::find($id);

        if (!$person) {
            self::badApiCall('Person not found', 404);
        }

        self::jsonResponse($person->toArray());
    }
}
```

### Example: `UserApiController` (Core)

Location: `src/Modules/Admin/Api/UserApiController.php`

```php
<?php

namespace CoreModules\Admin\Api;

use Alxarafe\Base\Controller\ApiController;
use CoreModules\Admin\Model\User;

class UserApiController extends ApiController
{
    public function get(int $id)
    {
        $user = User::find($id);
        if (!$user) {
            self::badApiCall('User not found', 404);
        }
        self::jsonResponse($user->toArray());
    }
}
```

## 2. Dispatching (Routing)

The Alxarafe `ApiDispatcher` automatically resolves routes based on the module structure and the controller method.

Route pattern:
`/api/{Module}/{Controller}/{Method}/{Parameter1}/{Parameter2}...`

### Call Examples
*   **Get Person ID 1**:
    `GET /api/Agenda/PersonApi/get/1`
    *   Module: `Agenda`
    *   Controller: `PersonApi` (looks for `PersonApiController.php`)
    *   Method: `get`
    *   Parameter: `1`

*   **Get User ID 5**:
    `GET /api/Admin/UserApi/get/5`

> **Note**: The dispatcher automatically instantiates the controller and calls the specified method, passing additional parameters as arguments.

## 3. Documentation with phpDocumentor

It is mandatory to document API classes and methods using standard PHPDoc blocks. This allows for automatic documentation generation and keeps the code intelligible.

### Common Tags
*   `@package`: Defines the package/module.
*   `@param`: Describes the method parameters.
*   `@return`: Describes the return value (or `never` if it terminates execution).
*   `@api`: Marks the element as part of the public API.

### Generating Documentation
To generate the web-based API documentation, `phpDocumentor` is used.

**Command (from Docker):**
```bash
docker exec alxarafe_php php phpdoc.phar -d skeleton/Modules/Agenda/Api -d src/Modules/Admin/Api -t doc/public/api --force
```

This will generate a static site in `doc/public/api/` with the full reference of classes, methods, and descriptions.

## 4. Manual API Testing

Since endpoints are accessible via HTTP, you can easily test them with tools like `curl` or Postman.

**Example with curl:**
```bash
curl -X GET http://localhost:8000/api/Agenda/PersonApi/get/1
```

Expected response (JSON):
```json
{
    "ok": true,
    "status": 200,
    "result": {
        "id": 1,
        "name": "Juan",
        "lastname": "Pérez",
        ...
    }
}
```
