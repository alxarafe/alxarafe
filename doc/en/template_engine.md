# Unified Template Engine (TemplateGenerator)

## Introduction

Alxarafe has an **automated template generation engine** that converts
a form definition (a PHP array called **ViewDescriptor**) into a ready-to-render Blade template.

Each controller defines the entire visual structure of its form using a single
PHP method (`getViewDescriptor()`), without the need to write Blade templates manually.

## How it works

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
          │ TemplateGenerator (generates wrapper)    │
          │                                          │
          │  {!! $viewDescriptor['body']             │
          │       ->render(['record' => $record]) !!}│
          └──────────────────────────────────────────┘
```

Each container component delegates its rendering to its own Blade template in
`templates/container/`. Recursion is transparent: a Panel within a Tab
calls `panel.blade.php`, which in turn calls `renderChild()` for each child.

### 3-Level Resolution System

1. **Custom** (`templates/custom/{Module}/{Controller}/edit.blade.php`): If it exists, it is used.
2. **Cache** (`var/cache/resources/{Module}/{Controller}/edit.blade.php`): If it exists, it is used.
3. **Generate**: If there is no cache, `TemplateGenerator::generate()` generates, caches, and uses it.

> **To customize**: Copy from `var/cache/resources/` to `templates/custom/` and edit there.

## ViewDescriptor Structure

The `body` key accepts **a single component** (`AbstractContainer`) that acts as the root
of the component tree. The developer chooses which type of root to use: `TabGroup`, `Panel`,
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
        ['label' => 'Save', 'icon' => 'fas fa-save', 'type' => 'primary', 'action' => 'submit'],
    ],
    // body = a single root component
    'body' => new TabGroup([
        new Tab('general', 'General', 'fas fa-cog', [
            new Panel('Main Data', [
                new Text('name', 'Name'),
                new Text('email', 'Email', ['type' => 'email']),
            ], ['col' => 'col-md-6']),
            new Panel('Configuration', [
                new Select('language', 'Language', ['es' => 'Spanish', 'en' => 'English']),
            ], ['col' => 'col-md-6']),
        ]),
        new Tab('advanced', 'Advanced', 'fas fa-tools', [
            new Row([
                new Text('api_key', 'API Key', ['col' => 'col-md-8']),
                new Boolean('api_enabled', 'Enabled', ['col' => 'col-md-4']),
            ]),
            new Separator('Extra Options'),
            new Panel('Security', [
                new Panel('Nested sub-panel', [  // Infinite nesting!
                    new Text('secret', 'Secret'),
                ], ['col' => 'col-12']),
            ], ['col' => 'col-12']),
        ]),
    ]),
]
```

### Key Rules

- **`body` is a single component**: If you need multiple panels without tabs, wrap them in a root `Panel` without a label:
  ```php
  'body' => new Panel('', [$panel1, $panel2], ['col' => 'col-12'])
  ```
- **Panels**: Rendered as Bootstrap cards (`card`) with a header.
- **Row**: Groups fields into a row **without card styling** (layout only).
- **Separator**: Visual `<hr>` divider, optionally with a centered label.
- **Hidden**: Invisible `<input type="hidden">` field with no visual presence.
- **Dot-notation keys**: `'main.theme'` is resolved by navigating the record structure.
- **Field actions**: `$field->addAction(icon, onclick, title)` adds side buttons.

## Container Components

| Class | Template | Description |
|-------|----------|-------------|
| `TabGroup` | `container/tab_group` | Bootstrap tabs. If it has only 1 tab, navigation is omitted. |
| `Tab` | `container/tab` | Individual tab within a `TabGroup`. |
| `Panel` | `container/panel` | Bootstrap card with a header. Supports nesting. |
| `Row` | `container/row` | Bootstrap row **without a card**. Layout only. |
| `Separator` | `container/separator` | `<hr>` divider, optionally with a label. |
| `HtmlContent` | `container/html_content` | Block of raw HTML (Markdown, etc.). |

All extend `AbstractContainer` → `AbstractField`. Infinite recursive nesting.

## Field Components

| Class | Template | Description |
|-------|----------|-------------|
| `Text` | `form/input` | Text input |
| `Select` | `form/select` | Select dropdown |
| `Select2` | `form/select` | Select with search |
| `Boolean` | `form/boolean` | Toggle/checkbox |
| `Integer` | `form/integer` | Integer numeric |
| `Decimal` | `form/decimal` | Decimal numeric |
| `Date` | `form/date` | Date picker |
| `DateTime` | `form/datetime` | Date and time |
| `Time` | `form/time` | Time picker |
| `Textarea` | `form/textarea` | Text area |
| `Image` | `form/image` | Image |
| `Icon` | `form/icon` | Icon selector |
| `StaticText` | `form/static_text` | Non-editable text |
| `Hidden` | `form/hidden` | Hidden field |

## Usage: Implementing a Form

```php
use Alxarafe\Base\Controller\ResourceController;
use Alxarafe\Component\Container\Panel;
use Alxarafe\Component\Fields\{Text, Select};

class MyController extends ResourceController
{
    #[\Override]
    public function getViewDescriptor(): array
    {
        return [
            'mode'     => $this->mode ?? 'edit',
            'method'   => 'POST',
            'action'   => '?module=MyModule&controller=MyController',
            'recordId' => $this->recordId,
            'record'   => $this->datos,
            'buttons'  => [
                ['label' => 'Save', 'icon' => 'fas fa-save', 'type' => 'primary', 'action' => 'submit'],
            ],
            'body' => new Panel('', [
                new Panel('Data', [
                    new Text('name', 'Name'),
                    new Text('email', 'Email', ['type' => 'email']),
                ], ['col' => 'col-md-6']),
                new Panel('Config', [
                    new Select('language', 'Language', ['es' => 'Spanish', 'en' => 'English']),
                ], ['col' => 'col-md-6']),
            ], ['col' => 'col-12']),
        ];
    }
}
```

No need to create any Blade templates. The engine automatically generates and caches them.

## Key Files

| File | Description |
|------|-------------|
| `src/Core/Base/Frontend/TemplateGenerator.php` | Generates the Blade wrapper (form, buttons) |
| `src/Core/Base/Controller/Trait/ResourceTrait.php` | `getViewDescriptor()` and `renderView()` |
| `src/Core/Component/AbstractField.php` | Base for all fields |
| `src/Core/Component/Container/AbstractContainer.php` | Base for containers with `render()` and `renderChild()` |
| `templates/container/` | Blade templates for each container |
| `templates/form/` | Blade templates for each field |

## Example: TestController

The `TestController` in the FrameworkTest module uses 3 tabs (Components, Nested Panels,
Markdown) and demonstrates: panel nesting, Row without a card, Separator with label, Hidden,
HtmlContent with Markdown, and all field types with Actions.

See: `skeleton/Modules/FrameworkTest/Controller/TestController.php`
