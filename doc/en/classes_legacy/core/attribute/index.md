# Attributes – API Reference

`Namespace: Alxarafe\Attribute`

Alxarafe uses PHP 8 Attributes to declaratively define routing, menu entries, permissions, and module metadata. Attributes are read at runtime via Reflection by the framework's service layer.

## Class Hierarchy

```text
#[ApiRoute]          — Defines API endpoints on controller methods
#[Menu]              — Registers menu items on classes or methods
#[ModuleInfo]        — Declares module display metadata on Module classes
#[RequireModule]     — Marks a field/class as needing a specific module
#[RequirePermission] — Requires a specific permission string
#[RequireRole]       — Requires one or more roles
```

---

## `#[ApiRoute]`

**Target:** `METHOD` (repeatable)  
**Namespace:** `Alxarafe\Attribute\ApiRoute`  
**Source:** [ApiRoute.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/ApiRoute.php)

Defines a REST API route on a controller method. Used by `ApiRouter` to build the API route table.

### Constructor Parameters

| Parameter | Type | Default | Description |
|---|---|---|---|
| `$path` | `string` | *(required)* | API route path (e.g. `'/api/users'`) |
| `$method` | `string` | `'GET'` | HTTP method: `GET`, `POST`, `PUT`, `DELETE`, `PATCH`, `OPTIONS` |

### Example

```php
use Alxarafe\Attribute\ApiRoute;

class UserApiController extends ApiController
{
    #[ApiRoute('/api/users', 'GET')]
    public function list(): array { /* ... */ }

    #[ApiRoute('/api/users', 'POST')]
    public function create(): array { /* ... */ }

    #[ApiRoute('/api/users/{id}', 'PUT')]
    public function update(int $id): array { /* ... */ }
}
```

---

## `#[Menu]`

**Target:** `CLASS | METHOD` (repeatable)  
**Namespace:** `Alxarafe\Attribute\Menu`  
**Source:** [Menu.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/Menu.php)

Registers a controller or method as a menu item. Read by `MenuManager::get()` to build navigation.

### Constructor Parameters

| Parameter | Type | Default | Description |
|---|---|---|---|
| `$menu` | `string` | *(required)* | Menu group identifier (e.g. `'main_menu'`, `'admin_sidebar'`, `'user_menu'`) |
| `$label` | `?string` | `null` | Display label (translation key or raw text) |
| `$icon` | `?string` | `null` | FontAwesome icon class (e.g. `'fas fa-users'`) |
| `$route` | `?string` | `null` | Named route (`Module.Controller.action`) |
| `$url` | `?string` | `null` | Explicit URL (overrides route) |
| `$parent` | `?string` | `null` | Parent menu item for nesting |
| `$order` | `int` | `99` | Sort order (lower = first) |
| `$permission` | `?string` | `null` | Required permission to show this item |
| `$visibility` | `string` | `'auth'` | Who sees this: `'auth'`, `'guest'`, `'public'` |
| `$badgeResolver` | `?string` | `null` | FQCN of badge count resolver callable |
| `$badgeClass` | `?string` | `null` | CSS class for badge styling |
| `$class` | `?string` | `null` | Additional CSS classes for the menu item |
| `$module` | `?string` | `null` | Source module name (auto-detected if null) |

### Example

```php
use Alxarafe\Attribute\Menu;

#[Menu(menu: 'main_menu', label: 'users', icon: 'fas fa-users', order: 10)]
#[Menu(menu: 'admin_sidebar', label: 'user_management', parent: 'admin', order: 5)]
class UserController extends ResourceController
{
    // ...
}
```

---

## `#[ModuleInfo]`

**Target:** `CLASS`  
**Namespace:** `Alxarafe\Attribute\ModuleInfo`  
**Source:** [ModuleInfo.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/ModuleInfo.php)

Declares cosmetic metadata for a module, placed on a `Module.php` class at the module root. Dependencies are auto-detected by `DependencyResolver`.

### Constructor Parameters

| Parameter | Type | Default | Description |
|---|---|---|---|
| `$name` | `string` | *(required)* | Human-readable module name |
| `$description` | `string` | `''` | Short description |
| `$icon` | `string` | `'fas fa-puzzle-piece'` | FontAwesome icon class |
| `$setupController` | `?string` | `null` | FQCN of the module configuration controller |
| `$core` | `bool` | `false` | If `true`, module is always enabled and cannot be toggled off |

### Example

```php
use Alxarafe\Attribute\ModuleInfo;

#[ModuleInfo(
    name: 'CRM',
    description: 'Customer Relationship Management',
    icon: 'fas fa-id-card',
    core: false
)]
class Module {}
```

---

## `#[RequireModule]`

**Target:** `CLASS | PROPERTY | PARAMETER`  
**Namespace:** `Alxarafe\Attribute\RequireModule`  
**Source:** [RequireModule.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/RequireModule.php)

Marks a field, class, or parameter as requiring a specific module to be enabled. Used by `ResourceTrait` to conditionally show/hide form fields.

### Constructor Parameters

| Parameter | Type | Default | Description |
|---|---|---|---|
| `$module` | `string` | *(required)* | Module name that must be enabled |

### Example

```php
use Alxarafe\Attribute\RequireModule;
use Alxarafe\Component\Fields\Decimal;

// Field only visible when 'Trading' module is active
#[RequireModule('Trading')]
$commissionField = new Decimal('commission', 'Commission %');
```

---

## `#[RequirePermission]`

**Target:** `CLASS | METHOD` (repeatable)  
**Namespace:** `Alxarafe\Attribute\RequirePermission`  
**Source:** [RequirePermission.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/RequirePermission.php)

Requires a specific permission string to access a controller or method. Checked by `PermissionSyncer`.

### Constructor Parameters

| Parameter | Type | Default | Description |
|---|---|---|---|
| `$permission` | `string` | *(required)* | Permission identifier (e.g. `'admin.users.delete'`) |

### Example

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

**Target:** `CLASS | METHOD`  
**Namespace:** `Alxarafe\Attribute\RequireRole`  
**Source:** [RequireRole.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Attribute/RequireRole.php)

Requires one or more roles to access a controller or method.

### Constructor Parameters

| Parameter | Type | Default | Description |
|---|---|---|---|
| `$roles` | `string\|array` | *(required)* | One or multiple role names. Stored internally as `string[]`. |

### Example

```php
use Alxarafe\Attribute\RequireRole;

#[RequireRole(['admin', 'manager'])]
class AdminDashboardController extends Controller
{
    // Only users with 'admin' or 'manager' roles can access
}
```
