# Atributos – Referencia de API

`Namespace: Alxarafe\Attribute`

Alxarafe usa Atributos PHP 8 para definir declarativamente rutas, entradas de menú, permisos y metadatos de módulos. Los atributos se leen en tiempo de ejecución vía Reflection por la capa de servicios del framework.

## Jerarquía de Clases

```text
#[ApiRoute]          — Define endpoints API en métodos de controlador
#[Menu]              — Registra elementos de menú en clases o métodos
#[ModuleInfo]        — Declara metadatos de visualización en clases Module
#[RequireModule]     — Marca un campo/clase como dependiente de un módulo
#[RequirePermission] — Requiere un permiso específico
#[RequireRole]       — Requiere uno o más roles
```

---

## `#[ApiRoute]`

**Destino:** `METHOD` (repetible)  
**Namespace:** `Alxarafe\Attribute\ApiRoute`  
**Fuente:** [ApiRoute.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/ApiRoute.php)

Define una ruta API REST en un método de controlador. Usado por `ApiRouter` para construir la tabla de rutas API.

### Parámetros del Constructor

| Parámetro | Tipo | Defecto | Descripción |
|---|---|---|---|
| `$path` | `string` | *(requerido)* | Ruta API (ej. `'/api/users'`) |
| `$method` | `string` | `'GET'` | Método HTTP: `GET`, `POST`, `PUT`, `DELETE`, `PATCH`, `OPTIONS` |

### Ejemplo

```php
use Alxarafe\Attribute\ApiRoute;

class UserApiController extends ApiController
{
    #[ApiRoute('/api/users', 'GET')]
    public function list(): array { /* ... */ }

    #[ApiRoute('/api/users', 'POST')]
    public function create(): array { /* ... */ }
}
```

---

## `#[Menu]`

**Destino:** `CLASS | METHOD` (repetible)  
**Namespace:** `Alxarafe\Attribute\Menu`  
**Fuente:** [Menu.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/Menu.php)

Registra un controlador o método como elemento de menú. Leído por `MenuManager::get()` para construir la navegación.

### Parámetros del Constructor

| Parámetro | Tipo | Defecto | Descripción |
|---|---|---|---|
| `$menu` | `string` | *(requerido)* | Identificador del grupo de menú (ej. `'main_menu'`, `'admin_sidebar'`) |
| `$label` | `?string` | `null` | Etiqueta (clave de traducción o texto) |
| `$icon` | `?string` | `null` | Clase FontAwesome (ej. `'fas fa-users'`) |
| `$route` | `?string` | `null` | Ruta nombrada (`Module.Controller.action`) |
| `$url` | `?string` | `null` | URL explícita (sobrescribe route) |
| `$parent` | `?string` | `null` | Elemento padre para anidación |
| `$order` | `int` | `99` | Orden (menor = primero) |
| `$permission` | `?string` | `null` | Permiso requerido para mostrar |
| `$visibility` | `string` | `'auth'` | Quién lo ve: `'auth'`, `'guest'`, `'public'` |
| `$badgeResolver` | `?string` | `null` | FQCN del resolver de conteo de badge |
| `$badgeClass` | `?string` | `null` | Clase CSS para el estilo del badge |
| `$class` | `?string` | `null` | Clases CSS adicionales |
| `$module` | `?string` | `null` | Nombre del módulo fuente (auto-detectado si null) |

### Ejemplo

```php
use Alxarafe\Attribute\Menu;

#[Menu(menu: 'main_menu', label: 'users', icon: 'fas fa-users', order: 10)]
class UserController extends ResourceController
{
    // ...
}
```

---

## `#[ModuleInfo]`

**Destino:** `CLASS`  
**Namespace:** `Alxarafe\Attribute\ModuleInfo`  
**Fuente:** [ModuleInfo.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/ModuleInfo.php)

Declara metadatos visuales para un módulo. Se coloca en la clase `Module.php` en la raíz del directorio del módulo.

### Parámetros del Constructor

| Parámetro | Tipo | Defecto | Descripción |
|---|---|---|---|
| `$name` | `string` | *(requerido)* | Nombre legible del módulo |
| `$description` | `string` | `''` | Descripción corta |
| `$icon` | `string` | `'fas fa-puzzle-piece'` | Clase de icono FontAwesome |
| `$setupController` | `?string` | `null` | FQCN del controlador de configuración |
| `$core` | `bool` | `false` | Si `true`, el módulo está siempre habilitado |

### Ejemplo

```php
use Alxarafe\Attribute\ModuleInfo;

#[ModuleInfo(name: 'CRM', description: 'Gestión de Relaciones con Clientes', icon: 'fas fa-id-card')]
class Module {}
```

---

## `#[RequireModule]`

**Destino:** `CLASS | PROPERTY | PARAMETER`  
**Namespace:** `Alxarafe\Attribute\RequireModule`  
**Fuente:** [RequireModule.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/RequireModule.php)

Marca un campo, clase o parámetro como dependiente de un módulo específico habilitado.

### Parámetros del Constructor

| Parámetro | Tipo | Defecto | Descripción |
|---|---|---|---|
| `$module` | `string` | *(requerido)* | Nombre del módulo que debe estar habilitado |

### Ejemplo

```php
use Alxarafe\Attribute\RequireModule;
use Alxarafe\Component\Fields\Decimal;

// Campo solo visible cuando el módulo 'Trading' está activo
#[RequireModule('Trading')]
$campoComision = new Decimal('commission', 'Comisión %');
```

---

## `#[RequirePermission]`

**Destino:** `CLASS | METHOD` (repetible)  
**Namespace:** `Alxarafe\Attribute\RequirePermission`  
**Fuente:** [RequirePermission.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/RequirePermission.php)

Requiere un permiso específico para acceder a un controlador o método.

### Parámetros del Constructor

| Parámetro | Tipo | Defecto | Descripción |
|---|---|---|---|
| `$permission` | `string` | *(requerido)* | Identificador de permiso (ej. `'admin.users.delete'`) |

### Ejemplo

```php
use Alxarafe\Attribute\RequirePermission;

class UserController extends ResourceController
{
    #[RequirePermission('admin.users.delete')]
    public function doDelete(): bool { /* ... */ }
}
```

---

## `#[RequireRole]`

**Destino:** `CLASS | METHOD`  
**Namespace:** `Alxarafe\Attribute\RequireRole`  
**Fuente:** [RequireRole.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/RequireRole.php)

Requiere uno o más roles para acceder a un controlador o método.

### Parámetros del Constructor

| Parámetro | Tipo | Defecto | Descripción |
|---|---|---|---|
| `$roles` | `string\|array` | *(requerido)* | Uno o múltiples nombres de rol. Almacenado internamente como `string[]`. |

### Ejemplo

```php
use Alxarafe\Attribute\RequireRole;

#[RequireRole(['admin', 'manager'])]
class AdminDashboardController extends Controller
{
    // Solo usuarios con roles 'admin' o 'manager' pueden acceder
}
```
