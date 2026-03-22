# API Development in Alxarafe

Alxarafe provides a robust infrastructure for building RESTful APIs using PHP 8 Attributes for routing and JSON Web Tokens (JWT) for secure, stateless authentication.

## 1. Controller Structure

API controllers must extend `Alxarafe\Base\Controller\ApiController` and are typically placed in the `Api/` directory of a module.

### Base Features
- **Stateless**: No sessions are used. Authentication is token-based.
- **JSON responses**: Unified output via `self::jsonResponse()`.
- **Error handling**: Standardized error responses via `self::badApiCall()`.

---

## 2. Declarative Routing

Routing is defined directly on the methods using the `#[ApiRoute]` attribute.

```php
namespace Modules\Blog\Api;

use Alxarafe\Base\Controller\ApiController;
use Alxarafe\Attribute\ApiRoute;

class PostApiController extends ApiController
{
    #[ApiRoute(path: 'posts', method: 'GET')]
    public function list()
    {
        return Post::all();
    }

    #[ApiRoute(path: 'posts/{id}', method: 'GET')]
    public function get(int $id)
    {
        $post = Post::find($id);
        return $post ?: self::badApiCall('Post not found', 404);
    }
}
```

### Route Patterns
- **Standard**: `path/to/resource`
- **Parameters**: `resource/{id}` (automatically mapped to the method arguments).

---

## 3. Security & Authentication

Alxarafe implements JWT (HS256) for API security.

### Acquiring a Token
A client must first authenticate via the `Admin` module login endpoint:
`POST /api/Admin/Login/doLogin`
Returns: `{"status": "success", "data": {"token": "eyJhbG..."}}`

### Using the Token
Include the token in all subsequent requests:
`Authorization: Bearer <token>`

### Enforcing Permissions
Use attributes to restrict access at the method level:

```php
#[ApiRoute(path: 'posts', method: 'POST')]
#[RequireRole(role: 'Editor')]
#[RequirePermission(permission: 'Blog.Post.doCreate')]
public function create()
{
    // ...
}
```

---

## 4. Response Format

All API responses follow a consistent structure:

**Success (200 OK):**
```json
{
    "status": "success",
    "data": { ... }
}
```

**Error (4xx/5xx):**
```json
{
    "status": "error",
    "code": 403,
    "message": "Forbidden: Missing permission Blog.Post.doCreate"
}
```

---

## 5. Development Tools

### Testing with cURL
```bash
curl -X GET http://localhost:8081/api/posts/1 \
     -H "Authorization: Bearer <your_token>"
```

### Troubleshooting
The `ApiDispatcher` validates:
1. **Route Existence**: Checks if any controller method matches the URI and HTTP method.
2. **Token Validity**: Checks signature and expiration using `security.jwt_secret_key`.
3. **RBAC**: Checks if the user associated with the token has the required roles and permissions in the database.
