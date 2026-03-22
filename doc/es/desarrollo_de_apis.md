# Desarrollo de APIs en Alxarafe

Alxarafe proporciona una infraestructura sólida para construir APIs RESTful utilizando atributos de PHP 8 para el enrutamiento y JSON Web Tokens (JWT) para una autenticación segura y sin estado (stateless).

## 1. Estructura del Controlador

Los controladores de API deben extender `Alxarafe\Base\Controller\ApiController` y se colocan típicamente en el directorio `Api/` de un módulo.

### Características Base
- **Sin estado**: No se utilizan sesiones. La autenticación se basa en tokens.
- **Respuestas JSON**: Salida unificada a través de `self::jsonResponse()`.
- **Manejo de errores**: Respuestas de error estandarizadas a través de `self::badApiCall()`.

---

## 2. Enrutamiento Declarativo

El enrutamiento se define directamente en los métodos utilizando el atributo `#[ApiRoute]`.

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
        return $post ?: self::badApiCall('Post no encontrado', 404);
    }
}
```

### Patrones de Ruta
- **Estándar**: `ruta/al/recurso`
- **Parámetros**: `recurso/{id}` (se mapean automáticamente a los argumentos del método).

---

## 3. Seguridad y Autenticación

Alxarafe implementa JWT (HS256) para la seguridad de la API.

### Obtener un Token
Un cliente debe autenticarse primero a través del endpoint de inicio de sesión del módulo `Admin`:
`POST /api/Admin/Login/doLogin`
Retorna: `{"status": "success", "data": {"token": "eyJhbG..."}}`

### Uso del Token
Incluye el token en todas las peticiones posteriores:
`Authorization: Bearer <token>`

### Forzar Permisos
Utiliza atributos para restringir el acceso a nivel de método:

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

## 4. Formato de Respuesta

Todas las respuestas de la API siguen una estructura consistente:

**Éxito (200 OK):**
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

## 5. Herramientas de Desarrollo

### Probar con cURL
```bash
curl -X GET http://localhost:8081/api/posts/1 \
     -H "Authorization: Bearer <tu_token>"
```

### Resolución de Problemas
El `ApiDispatcher` valida:
1. **Existencia de la Ruta**: Verifica si algún método de controlador coincide con la URI y el método HTTP.
2. **Validez del Token**: Comprueba la firma y la expiración utilizando `security.jwt_secret_key`.
3. **RBAC**: Verifica si el usuario asociado al token tiene los roles y permisos requeridos en la base de datos.
