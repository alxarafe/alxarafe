# Extensible Tab System

## Concept

Alxarafe's `ResourceTrait` provides a generic system allowing any controller to render edit forms with tabs (`Tab`) instead of side-by-side panels. Child controllers can extend the parent's tabs by adding their own.

## Activation

By default, edit forms use panels (`$useTabs = false`). To activate tabs:

```php
class MyController extends ResourceController
{
    protected bool $useTabs = true;
    
    protected function getEditFields(): array
    {
        return [
            'general' => [
                new Text('name', 'Name'),
                new Text('email', 'Email'),
            ],
            'details' => [
                new Select('category', 'Category', [...]),
                new Boolean('active', 'Active'),
            ],
        ];
    }
}
```

Result: Two tabs (`General` | `Details`) render instead of two side-by-side panels.

## Extension via Inheritance

The main extension point is the `getTabs()` method. A child controller calls `parent::getTabs()` and adds or inserts its own tabs:

```php
class MyExtendedController extends MyController
{
    protected function getTabs(): array
    {
        $tabs = parent::getTabs();
        
        // Append at end
        $tabs[] = new Tab('extra', 'My Tab', '', [
            new Text('extra.field1', 'Field 1'),
        ]);
        
        return $tabs;
    }
}
```

## Inserting at a Specific Position

Use `insertTabAfter()` to place a tab after an existing one:

```php
protected function getTabs(): array
{
    $tabs = parent::getTabs();
    
    $newTab = new Tab('audit', 'Audit', 'fas fa-history', [
        new Text('audit.last_modified', 'Last Modified'),
    ]);
    
    // Insert right after 'general'
    return $this->insertTabAfter($tabs, 'general', $newTab);
}
```

If the referenced tab doesn't exist, it appends at the end as a fallback.

## Extending Config with Custom Sections

For an application to add its own configuration sections to `config.json`:

```php
// In the app bootstrap (routes.php or ServiceProvider)
Config::registerSection('blog', ['title', 'posts_per_page']);
Config::registerSection('social', []);  // [] = accept any key
```

Then in the controller:

```php
class ConfigController extends \CoreModules\Admin\Controller\ConfigController
{
    protected function getTabs(): array
    {
        $tabs = parent::getTabs();
        $tabs[] = new Tab('blog', 'Blog Settings', '', [
            new Text('blog.title', 'Blog Title'),
        ]);
        return $tabs;
    }
}
```

## API Reference

| Element | Location | Description |
|---------|----------|-------------|
| `$useTabs` | `ResourceTrait` | `bool` — Enables tab-based rendering |
| `getTabs()` | `ResourceTrait` | Generates `Tab[]` from `getEditFields()`. Extensible via inheritance |
| `insertTabAfter()` | `ResourceTrait` | Inserts a tab after an existing one |
| `Config::registerSection()` | `Config` | Registers extra configuration sections |
| `Config::getConfigStructure()` | `Config` | Returns full structure (core + extensions) |
