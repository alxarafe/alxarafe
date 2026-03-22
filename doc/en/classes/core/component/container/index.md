# Component Containers – API Reference

`Namespace: Alxarafe\Component\Container`

Container components for structuring form layouts: panels, tabs, rows, and separators.

---

## `AbstractContainer`

**Namespace:** `Alxarafe\Component\Container\AbstractContainer`  
**Source:** [AbstractContainer.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Component/Container/AbstractContainer.php)

Base class for all layout containers. Manages child components and supports recursive filtering.

### Key Methods

| Method | Signature | Description |
|---|---|---|
| `addChild()` | `addChild(AbstractField\|AbstractContainer $child): self` | Adds a child component. |
| `getChildren()` | `getChildren(): array` | Returns all children. |
| `filterChildren()` | `filterChildren(callable $predicate): void` | Recursively filter children by predicate. |

---

## `Panel`

Groups fields into a collapsible panel with optional title.

```php
use Alxarafe\Component\Container\Panel;

$panel = new Panel('contact_info', 'Contact Information');
$panel->addChild(new Text('email', 'Email'));
$panel->addChild(new Text('phone', 'Phone'));
```

---

## `Tab`

Represents a single tab within a `TabGroup`. Supports conditional visibility and badge counts.

### Constructor

```php
new Tab(string $key, string $label, string $icon = '', array $fields = [])
```

### Key Methods

| Method | Signature | Description |
|---|---|---|
| `getTabId()` | `getTabId(): string` | Returns `'tab_{key}'` |
| `setBadgeCount()` | `setBadgeCount(int $count): void` | Sets a numeric badge on the tab |
| `getBadgeCount()` | `getBadgeCount(): ?int` | Returns badge count |

### Example

```php
$tab = new Tab('addresses', 'Addresses', 'fas fa-map', [
    new Text('street', 'Street'),
    new Text('city', 'City'),
]);
$tab->setBadgeCount(3);
```

---

## `TabGroup`

Renders multiple `Tab` instances as a tabbed interface.

```php
$tabGroup = new TabGroup('details', [
    new Tab('general', 'General', '', $generalFields),
    new Tab('billing', 'Billing', 'fas fa-credit-card', $billingFields),
]);
```

---

## `Row`

Horizontal row container for side-by-side field placement.

```php
$row = new Row('name_row');
$row->addChild(new Text('first_name', 'First Name', ['col' => 'col-6']));
$row->addChild(new Text('last_name', 'Last Name', ['col' => 'col-6']));
```

---

## `Separator`

Visual separator (horizontal rule) between form sections.

```php
new Separator('section_break')
```

---

## `HtmlContent`

Injects arbitrary HTML content into the form layout.

```php
new HtmlContent('notice', '<div class="alert alert-info">Custom notice here</div>')
```
