# Motor de Plantillas Unificado (TemplateGenerator)

## Introducción

Alxarafe dispone de un **motor de generación de plantillas automatizado** que convierte
una definición de formulario (un array PHP llamado **ViewDescriptor**) en una plantilla
Blade lista para renderizar.

Cada controlador define toda la estructura visual de su formulario mediante un único
método PHP (`getViewDescriptor()`), sin necesidad de escribir plantillas Blade manualmente.

## Cómo funciona

```
Controller                           Templates
──────────                           ─────────
getViewDescriptor() {                container/panel.blade.php
  body: new TabGroup([               container/tab_group.blade.php
    new Tab(..., [                   container/tab.blade.php
      new Panel(..., [               container/row.blade.php
        new Text(...)                container/separator.blade.php
      ])                             container/html_content.blade.php
    ])                               form/input.blade.php
  ])                                 form/select.blade.php
}                                    ...

         ┌──────────────────────────────────────────┐
         │ TemplateGenerator (genera wrapper)        │
         │                                          │
         │  {!! $viewDescriptor['body']             │
         │       ->render(['record' => $record]) !!}│
         └──────────────────────────────────────────┘
```

Cada componente contenedor delega su renderizado a un template Blade propio en
`templates/container/`. La recursión es transparente: un Panel dentro de un Tab
llama a `panel.blade.php`, que a su vez llama a `renderChild()` para cada hijo.

### Sistema de resolución en 3 niveles

1. **Custom** (`templates/custom/{Módulo}/{Controlador}/edit.blade.php`): Si existe, se usa.
2. **Cache** (`var/cache/resources/{Módulo}/{Controlador}/edit.blade.php`): Si existe, se usa.
3. **Generar**: Si no hay caché, `TemplateGenerator::generate()` genera, cachea y usa.

> **Para personalizar**: copia de `var/cache/resources/` a `templates/custom/` y edita allí.

## Estructura del ViewDescriptor

La clave `body` acepta **un solo componente** (`AbstractContainer`) que actúa como raíz
del árbol de componentes. El desarrollador elige qué tipo de raíz usar: `TabGroup`, `Panel`,
`Row`, etc.

```php
use Alxarafe\Component\Container\{TabGroup, Tab, Panel, Row, Separator, HtmlContent};
use Alxarafe\Component\Fields\{Text, Select, Boolean, Hidden};

[
    'mode'     => 'edit',
    'method'   => 'POST',
    'action'   => '?module=Admin&controller=Config',
    'recordId' => 'current',
    'record'   => $datos,
    'buttons'  => [
        ['label' => 'Guardar', 'icon' => 'fas fa-save', 'type' => 'primary', 'action' => 'submit'],
    ],
    // body = un solo componente raíz
    'body' => new TabGroup([
        new Tab('general', 'General', 'fas fa-cog', [
            new Panel('Datos principales', [
                new Text('nombre', 'Nombre'),
                new Text('email', 'Email', ['type' => 'email']),
            ], ['col' => 'col-md-6']),
            new Panel('Configuración', [
                new Select('idioma', 'Idioma', ['es' => 'Español', 'en' => 'English']),
            ], ['col' => 'col-md-6']),
        ]),
        new Tab('advanced', 'Avanzado', 'fas fa-tools', [
            new Row([
                new Text('api_key', 'API Key', ['col' => 'col-md-8']),
                new Boolean('api_enabled', 'Habilitado', ['col' => 'col-md-4']),
            ]),
            new Separator('Opciones extra'),
            new Panel('Seguridad', [
                new Panel('Sub-panel anidado', [  // ¡Nesting infinito!
                    new Text('secret', 'Secret'),
                ], ['col' => 'col-12']),
            ], ['col' => 'col-12']),
        ]),
    ]),
]
```

### Reglas clave

- **`body` es un solo componente**: Si necesitas varios paneles sin tabs, envuélvelos en un `Panel` raíz sin label:
  ```php
  'body' => new Panel('', [$panel1, $panel2], ['col' => 'col-12'])
  ```
- **Paneles**: Se renderizan como tarjetas Bootstrap (`card`) con header.
- **Row**: Agrupa campos en fila **sin card** (solo layout).
- **Separator**: Divisor visual `<hr>`, opcionalmente con etiqueta centrada.
- **Hidden**: Campo oculto `<input type="hidden">` sin presencia visual.
- **Claves con punto**: `'main.theme'` se resuelve navegando la estructura del record.
- **Actions en campos**: `$field->addAction(icon, onclick, title)` añade botones laterales.

## Componentes contenedores

| Clase | Template | Descripción |
|-------|----------|-------------|
| `TabGroup` | `container/tab_group` | Pestañas Bootstrap. Si solo tiene 1 tab, omite navegación. |
| `Tab` | `container/tab` | Pestaña individual dentro de un `TabGroup`. |
| `Panel` | `container/panel` | Tarjeta Bootstrap con header. Soporta nesting. |
| `Row` | `container/row` | Fila Bootstrap **sin card**. Solo layout. |
| `Separator` | `container/separator` | Divisor `<hr>`, opcionalmente con etiqueta. |
| `HtmlContent` | `container/html_content` | Bloque de HTML crudo (Markdown, etc.). |

Todos extienden `AbstractContainer` → `AbstractField`. Nesting recursivo infinito.

## Componentes de campo

| Clase | Template | Descripción |
|-------|----------|-------------|
| `Text` | `form/input` | Input de texto |
| `Select` | `form/select` | Select dropdown |
| `Select2` | `form/select` | Select con búsqueda |
| `Boolean` | `form/boolean` | Toggle/checkbox |
| `Integer` | `form/integer` | Numérico entero |
| `Decimal` | `form/decimal` | Numérico decimal |
| `Date` | `form/date` | Selector de fecha |
| `DateTime` | `form/datetime` | Fecha y hora |
| `Time` | `form/time` | Selector de hora |
| `Textarea` | `form/textarea` | Área de texto |
| `Image` | `form/image` | Imagen |
| `Icon` | `form/icon` | Selector de icono |
| `StaticText` | `form/static_text` | Texto no editable |
| `Hidden` | `form/hidden` | Campo oculto |

## Uso: Implementar un formulario

```php
use Alxarafe\Base\Controller\ResourceController;
use Alxarafe\Component\Container\Panel;
use Alxarafe\Component\Fields\{Text, Select};

class MiController extends ResourceController
{
    #[\Override]
    public function getViewDescriptor(): array
    {
        return [
            'mode'     => $this->mode ?? 'edit',
            'method'   => 'POST',
            'action'   => '?module=MiModulo&controller=MiController',
            'recordId' => $this->recordId,
            'record'   => $this->datos,
            'buttons'  => [
                ['label' => 'Guardar', 'icon' => 'fas fa-save', 'type' => 'primary', 'action' => 'submit'],
            ],
            'body' => new Panel('', [
                new Panel('Datos', [
                    new Text('nombre', 'Nombre'),
                    new Text('email', 'Email', ['type' => 'email']),
                ], ['col' => 'col-md-6']),
                new Panel('Config', [
                    new Select('idioma', 'Idioma', ['es' => 'Español', 'en' => 'English']),
                ], ['col' => 'col-md-6']),
            ], ['col' => 'col-12']),
        ];
    }
}
```

No necesitas crear ninguna plantilla Blade. El motor genera y cachea automáticamente.

## Archivos clave

| Archivo | Descripción |
|---------|-------------|
| `src/Core/Base/Frontend/TemplateGenerator.php` | Genera el wrapper Blade (form, buttons) |
| `src/Core/Base/Controller/Trait/ResourceTrait.php` | `getViewDescriptor()` y `renderView()` |
| `src/Core/Component/AbstractField.php` | Base de todos los campos |
| `src/Core/Component/Container/AbstractContainer.php` | Base de contenedores con `render()` y `renderChild()` |
| `templates/container/` | Templates Blade de cada contenedor |
| `templates/form/` | Templates Blade de cada campo |

## Ejemplo: TestController

El `TestController` del módulo FrameworkTest usa 3 pestañas (Componentes, Paneles Anidados,
Markdown) y demuestra: nesting de paneles, Row sin card, Separator con etiqueta, Hidden,
HtmlContent con Markdown, y todos los tipos de campo con Actions.

Ver: `skeleton/Modules/FrameworkTest/Controller/TestController.php`
