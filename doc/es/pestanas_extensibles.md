# Sistema de Pestañas Extensible

## Concepto

El `ResourceTrait` de Alxarafe proporciona un sistema genérico que permite a cualquier controlador renderizar formularios de edición con pestañas (`Tab`) en lugar de paneles lado a lado. Los controladores hijos pueden extender las pestañas del padre añadiendo las suyas propias.

## Activación

Por defecto, los formularios de edición usan paneles (`$useTabs = false`). Para activar pestañas:

```php
class MiController extends ResourceController
{
    protected bool $useTabs = true;
    
    protected function getEditFields(): array
    {
        return [
            'general' => [
                new Text('nombre', 'Nombre'),
                new Text('email', 'Email'),
            ],
            'detalles' => [
                new Select('categoria', 'Categoría', [...]),
                new Boolean('activo', 'Activo'),
            ],
        ];
    }
}
```

Resultado: Se renderizan dos pestañas (`General` | `Detalles`) en lugar de dos paneles lado a lado.

## Extensión por Herencia

El punto de extensión principal es el método `getTabs()`. Un controlador hijo llama a `parent::getTabs()` y añade o inserta sus propias pestañas:

```php
class MiControladorExtendido extends MiController
{
    protected function getTabs(): array
    {
        $tabs = parent::getTabs();
        
        // Añadir al final
        $tabs[] = new Tab('extra', 'Mi Pestaña', '', [
            new Text('extra.campo1', 'Campo 1'),
        ]);
        
        return $tabs;
    }
}
```

## Insertando en una Posición Específica

Usa `insertTabAfter()` para colocar una pestaña tras una existente:

```php
protected function getTabs(): array
{
    $tabs = parent::getTabs();
    
    $nuevaTab = new Tab('auditoria', 'Auditoría', 'fas fa-history', [
        new Text('audit.last_modified', 'Última Modificación'),
    ]);
    
    // Insertar justo después de 'general'
    return $this->insertTabAfter($tabs, 'general', $nuevaTab);
}
```

Si la pestaña referenciada no existe, se añade al final como fallback.

## Extensión de Config con Secciones Personalizadas

Para que una aplicación añada secciones de configuración propias al `config.json`:

```php
// En el bootstrap de la app (routes.php o ServiceProvider)
Config::registerSection('blog', ['title', 'posts_per_page']);
Config::registerSection('social', []);  // [] = acepta cualquier clave
```

Luego en el controlador:

```php
class ConfigController extends \CoreModules\Admin\Controller\ConfigController
{
    protected function getTabs(): array
    {
        $tabs = parent::getTabs();
        $tabs[] = new Tab('blog', 'Ajustes Blog', '', [
            new Text('blog.title', 'Título del Blog'),
        ]);
        return $tabs;
    }
}
```

## Referencia API

| Elemento | Ubicación | Descripción |
|----------|-----------|-------------|
| `$useTabs` | `ResourceTrait` | `bool` — Activa renderizado por pestañas |
| `getTabs()` | `ResourceTrait` | Genera `Tab[]` desde `getEditFields()`. Extensible vía herencia |
| `insertTabAfter()` | `ResourceTrait` | Inserta una pestaña tras otra existente |
| `Config::registerSection()` | `Config` | Registra secciones de configuración extra |
| `Config::getConfigStructure()` | `Config` | Retorna estructura completa (core + extensiones) |
