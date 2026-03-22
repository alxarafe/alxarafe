# Guía de Uso Avanzado

Esta guía cubre patrones avanzados y técnicas de personalización para el microframework Alxarafe.

## Creación de Módulos

Los módulos son la unidad organizativa principal en Alxarafe. Un módulo es un directorio dentro de `Modules/` (aplicación) o `src/Modules/` (núcleo del framework) siguiendo la convención de namespace PSR-4:

1. **Namespace**: `Modules\{ModuleName}\Controller`.
2. **Directorio**: `Modules/{ModuleName}/Controller/`.
3. **Nomenclatura**: Los archivos deben llamarse `{Accion}Controller.php`.

### Módulo Mínimo
Para registrar un nuevo módulo, solo necesitas un controlador con el atributo `#[ModuleInfo]` en cualquiera de sus clases (generalmente el controlador principal).

```php
namespace Modules\Blog\Controller;

use Alxarafe\Base\Controller\Controller;
use Alxarafe\Attribute\ModuleInfo;

#[ModuleInfo(name: 'Blog', description: 'Módulo de blog simple', icon: 'fas fa-blog')]
class PostController extends Controller {
    // ...
}
```

---

## Sistema de Hooks (Ganchos)

Alxarafe implementa un potente sistema de hooks síncronos (`HookService`) que te permite interceptar la lógica del framework o crear tus propios puntos de extensión.

### Registro de un Hook
Los hooks deben registrarse durante el bootstrap de la aplicación.

```php
use Alxarafe\Service\HookService;
use Alxarafe\Service\HookPoints;

HookService::register(
    HookService::resolve(HookPoints::AFTER_SAVE, ['entity' => 'Post']),
    function($post) {
        // Limpiar caché del blog después de guardar una entrada
        Cache::forget('blog_posts');
    }
);
```

### Creación de Hooks Personalizados
Puedes definir tus propios hooks en tu lógica de negocio:

```php
// Ejecutar un hook de acción
HookService::execute('blog.before_publish', $post);

// Utilizar un hook de filtro para modificar un valor
$content = HookService::filter('blog.content_filter', $content);
```

---

## Campos y Componentes Personalizados

La interfaz de usuario programática se puede extender creando subclases personalizadas de `AbstractField` o `AbstractContainer`.

### Creación de un Campo Personalizado
1. **Extender** `Alxarafe\Component\AbstractField`.
2. **Implementar** `getType()`.
3. **Crear** una plantilla Blade correspondiente en `templates/form/{nombre_componente}.blade.php`.

```php
namespace Modules\MiModulo\Component;

use Alxarafe\Component\AbstractField;

class ColorPicker extends AbstractField {
    protected string $component = 'colorpicker';
    
    public function getType(): string { return 'color'; }
}
```

---

## Prioridad de Vistas

Cuando se llama a `ViewController::render($view)`, el framework busca la plantilla en el siguiente orden:

1. **Tema**: `APP_PATH/themes/{TemaActivo}/templates/{view}.blade.php`
2. **Módulo (App)**: `APP_PATH/Modules/{ModuloActual}/Templates/{view}.blade.php`
3. **App Compartido**: `APP_PATH/templates/{view}.blade.php`
4. **Módulo (Core)**: `ALX_PATH/src/Modules/{ModuloActual}/Templates/{view}.blade.php`
5. **Núcleo Framework**: `ALX_PATH/templates/{view}.blade.php`

Esta jerarquía te permite sobrescribir la interfaz del núcleo del framework sin modificar la carpeta `vendor/` ni los archivos base del framework.

---

## Seguridad API y JWT

Alxarafe utiliza JSON Web Tokens (JWT) para la autenticación de APIs sin estado (stateless).

### Ciclo de Vida del Token
1. **Login**: Una petición POST a `/api/admin/login` devuelve un JWT firmado con la clave `security.jwt_secret_key` de `config.json`.
2. **Autorización**: Incluye el token en la cabecera de la petición: `Authorization: Bearer <token>`.
3. **Verificación**: `ApiDispatcher` valida automáticamente la firma y la fecha de expiración.

### Protección de Endpoints
Utiliza los atributos `#[RequireRole]` o `#[RequirePermission]` en tus métodos de controlador de API.

```php
#[ApiRoute(path: 'posts', method: 'POST')]
#[RequirePermission(permission: 'Blog.Post.doCreate')]
public function createAction($data) {
    // ...
}
```

---

## Internacionalización (i18n)

Las traducciones son manejadas por `Alxarafe\Lib\Trans` y almacenadas en archivos YAML.

### Estructura de Directorios
- `Modules/Blog/Lang/en.yaml`
- `Modules/Blog/Lang/es.yaml`

### Uso en Código
```php
Trans::_('key', ['param' => 'value']);
```

### Uso en Blade
```blade
{{ $me->trans('key') }}
```

### Fallback de Jerarquía
El traductor resuelve las claves en este orden:
1. Localización destino (ej. `es_ES`).
2. Localización padre (ej. `es`).
3. Localización por defecto (ej. `en`).
