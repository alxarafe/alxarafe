# Advanced Usage Guide

This guide covers advanced patterns and customization techniques for the Alxarafe microframework.

## Module Creation

Modules are the primary organizational unit in Alxarafe. A module is a directory within `Modules/` (application) or `src/Modules/` (framework core) following the PSR-4 namespace convention:

1. **Namespace**: `Modules\{ModuleName}\Controller`.
2. **Directory**: `Modules/{ModuleName}/Controller/`.
3. **Naming**: Files must be named `{Action}Controller.php`.

### Bare Minimum Module
To register a new module, you only need one controller with a `#[ModuleInfo]` attribute in any of its classes (usually the main controller).

```php
namespace Modules\Blog\Controller;

use Alxarafe\Base\Controller\Controller;
use Alxarafe\Attribute\ModuleInfo;

#[ModuleInfo(name: 'Blog', description: 'Simple blog module', icon: 'fas fa-blog')]
class PostController extends Controller {
    // ...
}
```

---

## Hook System

Alxarafe implements a powerful synchronous hook system (`HookService`) allowing you to intercept framework logic or create your own extension points.

### Registering a Hook
Hooks should be registered during the application bootstrap.

```php
use Alxarafe\Service\HookService;
use Alxarafe\Service\HookPoints;

HookService::register(
    HookService::resolve(HookPoints::AFTER_SAVE, ['entity' => 'Post']),
    function($post) {
        // Clear blog cache after saving a post
        Cache::forget('blog_posts');
    }
);
```

### Creating Custom Hooks
You can define your own hooks in your business logic:

```php
// Execute an action hook
HookService::execute('blog.before_publish', $post);

// Use a filter hook to modify a value
$content = HookService::filter('blog.content_filter', $content);
```

---

## Custom Fields & Components

The programmatic UI assembly can be extended by creating custom `AbstractField` or `AbstractContainer` subclasses.

### Creating a Custom Field
1. **Extend** `Alxarafe\Component\AbstractField`.
2. **Implement** `getType()`.
3. **Create** a matching Blade template in `templates/form/{component_name}.blade.php`.

```php
namespace Modules\MyModule\Component;

use Alxarafe\Component\AbstractField;

class ColorPicker extends AbstractField {
    protected string $component = 'colorpicker';
    
    public function getType(): string { return 'color'; }
}
```

---

## View Prioritization

When `ViewController::render($view)` is called, the framework searches for the template in the following order:

1. **Theme**: `APP_PATH/themes/{ActiveTheme}/templates/{view}.blade.php`
2. **Module (App)**: `APP_PATH/Modules/{CurrentModule}/Templates/{view}.blade.php`
3. **App Shared**: `APP_PATH/templates/{view}.blade.php`
4. **Module (Core)**: `ALX_PATH/src/Modules/{CurrentModule}/Templates/{view}.blade.php`
5. **Framework Core**: `ALX_PATH/templates/{view}.blade.php`

This hierarchy allows you to override core framework UI without modifying the `vendor/` or framework core files.

---

## JWT & API Security

Alxarafe uses JSON Web Tokens (JWT) for stateless API authentication.

### Token Lifecycle
1. **Login**: POST to `/api/admin/login` returns a JWT signed with the `security.jwt_secret_key` from `config.json`.
2. **Authorization**: Include the token in the request header: `Authorization: Bearer <token>`.
3. **Verification**: `ApiDispatcher` automatically validates the signature and expiration.

### Securing Endpoints
Use the `#[RequireRole]` or `#[RequirePermission]` attributes on your API controller methods.

```php
#[ApiRoute(path: 'posts', method: 'POST')]
#[RequirePermission(permission: 'Blog.Post.doCreate')]
public function createAction($data) {
    // ...
}
```

---

## Internationalization (i18n)

Translations are handled by `Alxarafe\Lib\Trans` and stored in YAML files.

### Directory Structure
- `Modules/Blog/Lang/en.yaml`
- `Modules/Blog/Lang/es.yaml`

### Usage in Code
```php
Trans::_('key', ['param' => 'value']);
```

### Usage in Blade
```blade
{{ $me->trans('key') }}
```

### Hierarchy Fallback
The translator resolves keys in the following order:
1. Destination locale (e.g., `es_ES`).
2. Parent locale (e.g., `es`).
3. Fallback locale (e.g., `en`).
