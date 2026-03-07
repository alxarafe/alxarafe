# API Nativa de Alxarafe (Basada en Atributos de PHP 8)

El microframework Alxarafe incluye un sistema nativo de enrutamiento y control de acceso (RBAC/ABAC) para construir APIs RESTful rápidas y modernas sin depender de librerías externas de Reflection o Anotaciones por DocBlocks (ej. Restler). Todo el sistema se basa en los **Atributos nativos de PHP 8**.

## Arquitectura General

El sistema consta de tres pilares fundamentales:
1. **Los Atributos (Attributes)**: Decoradores que se asignan a clases y métodos para definir rutas HTTP y requisitos de seguridad.
2. **El Escáner (ApiRouter)**: Un servicio que escanea dinámicamente el proyecto (a través de `ReflectionClass`) buscando estos atributos, construyendo un mapa de rutas y cacheándolo para máximo rendimiento.
3. **El Despachador (ApiDispatcher)**: El motor de intercepción que recibe la petición HTTP (URL), verifica el Token JWT del usuario contra la base de datos de usuarios (y roles) e invoca la lógica de tu controlador.

---

## 1. Definición de Rutas (`#[ApiRoute]`)

Para exponer un método al exterior a través de la API de Alxarafe, basta con añadir el atributo `#[ApiRoute]` encima del método deseado.

**Parámetros:**
* `path`: La URL de la ruta (empieza por `/api/`).
* `method`: El verbo HTTP (GET, POST, PUT, DELETE...).

**Ejemplo de uso:**
```php
namespace CoreModules\Users\Api;

use Alxarafe\Base\Controller\ApiController;
use Alxarafe\Attribute\ApiRoute;

class UserController extends ApiController
{
    #[ApiRoute(path: '/api/users/list', method: 'GET')]
    public function listUsers(): array
    {
        return [
            'users' => [
                ['id' => 1, 'name' => 'Admin'],
                ['id' => 2, 'name' => 'Demo']
            ]
        ];
    }
}
```
*Nota: El ApiDispatcher tomará automáticamente el _array_ devuelto y responderá al cliente web con un JSON formateado estructurado: `{"status": "success", "data": {"users": [...]}}`.*

---

## 2. Control de Acceso basado en Roles (`#[RequireRole]`)

Para restringir quién puede ejecutar un endpoint en función de su Rol (Role-Based Access Control), utiliza el atributo `#[RequireRole]`. Puede aplicarse tanto a la **clase** entera (para afectar a todos sus métodos) como a un **método individual**.

**Ejemplo de uso:**
```php
use Alxarafe\Attribute\ApiRoute;
use Alxarafe\Attribute\RequireRole;

class InvoiceController extends ApiController
{
    // Solo los administradores o supervisores pueden eliminar la factura
    #[RequireRole(['admin', 'supervisor'])]
    #[ApiRoute(path: '/api/invoices/delete', method: 'DELETE')]
    public function deleteInvoice(): array
    {
        // Lógica de borrado seguro...
        return ['deleted' => true];
    }
}
```
*Si un usuario se autentica con un token JWT válido pero su Rol en BDD es `invitado`, el ApiDispatcher abortará la ejecución y devolverá automáticamente un error HTTP `403 Forbidden`.*

---

## 3. Seguridad Granular por Permisos (`#[RequirePermission]`)

En aplicaciones complejas, el acceso no solo se rige por Roles genéricos, sino por **permisos muy específicos** (por ejemplo: `core.users.edit`). Para esto se usa `#[RequirePermission]`. 
Igual que el rol, puede aplicarse a clases enteras o métodos individuales. Y es acumulable (puedes poner varios permisos simultáneos).

**Ejemplo de uso:**
```php
use Alxarafe\Attribute\ApiRoute;
use Alxarafe\Attribute\RequirePermission;

class ProductController extends ApiController
{
    #[RequirePermission('catalog.products.write')]
    #[RequirePermission('catalog.pricing.read')]
    #[ApiRoute(path: '/api/products/update', method: 'POST')]
    public function updatePrice(): array
    {
        return ['updated' => true];
    }
}
```
*El `ApiDispatcher` invocará internamente el verificador de permisos del modelo `User` en la BDD para validar que se posean TODAS las directivas de seguridad solicitadas.*

---

## 4. El Flujo de Autenticación (JWT Token)

Salvo que un endpoint no defina ni `#[RequireRole]` ni `#[RequirePermission]` (en cuyo caso la ruta se considera **PÚBLICA**), acceder a la API requiere obligatoriamente enviar un token **JWT (JSON Web Token)**.

El cliente debe enviar el token en las **Cabeceras HTTP (Headers)**, usando el esquema `Bearer`:
```http
Authorization: Bearer <tu.token.jwt.aqui>
```

**Generación de Tokens (El Endpoint `/api/login`)**
El punto de entrada clásico en Alxarafe es el `LoginController`. Recibe `username` y `password` y, si son correctos, devuelve un Payload cifrado con el `SecurityKey` local.

```php
    // En src/Modules/Admin/Api/LoginController.php
    #[ApiRoute(path: '/api/login', method: 'POST')]
    public function login(): array
    {
        $username = $_REQUEST['username'] ?? '';
        $password = $_REQUEST['password'] ?? '';
        $secret_key = Auth::getSecurityKey();
        
        // ... (Validación en Models\User) ...

        $payload = [
            'iat' => time(),
            'exp' => time() + 86400, // JWT expira en 24h
            'data' => [ 'user' => $username, 'role' => 'admin' ]
        ];

        return [
            'token' => JWT::encode($payload, $secret_key, 'HS256')
        ];
    }
```

---

## 5. El Auto-Descubrimiento y la Caché (`ApiRouter`)

El framework Alxarafe, cuando detecta una llamada que inicia por `/api/`, delega el control en el `ApiRouter`.
Si el framework está en modo Desarrollo, escanea en busca de los atributos de PHP las carpetas:
- `src/Modules/*/Api/*.php`
- `skeleton/Modules/*/Api/*.php`
- `app/Modules/*/Api/*.php`

Una vez parseadas todas las clases y sus metadatos (Roles, Rutas y Permisos), **se guardan en caché** (por defecto en el temporal local). Esto garantiza que, en Producción, las librerías de `Reflection` de PHP jamás se penalicen en tiempo y memoria frente a cada request entrante de la API.

---

## Retorno de Errores Estandarizados (`ApiException`)

Cuando detectas un error semántico o de validación dentro de un controlador y deseas abortar la petición emulando una API robusta, debes usar Exceptions en lugar del flujo tradicional.

```php
use Alxarafe\Service\ApiException;

public function getSecureData() {
    $id = $_REQUEST['id'] ?? null;
    
    if (!$id) {
        // Lanzar ApiException aborta inmediatamente la respuesta
        // y retorna un HTTP 400 Bad Request en JSON puro al cliente frontend.
        throw new ApiException("El parámetro ID es obligatorio", 400); 
    }
    
    return ['data' => 'secret'];
}
```
