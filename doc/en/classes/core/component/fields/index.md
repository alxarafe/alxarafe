# Component Fields – API Reference

`Namespace: Alxarafe\Component\Fields`

Field components for programmatic form generation. All fields extend `AbstractField` and implement `JsonSerializable`.

## `AbstractField` (abstract)

**Namespace:** `Alxarafe\Component\AbstractField`  
**Source:** [AbstractField.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Component/AbstractField.php)

Base class for all form field components. Provides JSON serialization, Blade rendering, action buttons, and module-dependent visibility.

### Constructor

```php
public function __construct(string $field, string $label, array $options = [])
```

### Common Options

| Option | Type | Description |
|---|---|---|
| `required` | `bool` | Mark field as required |
| `readonly` | `bool` | Mark field as read-only |
| `disabled` | `bool` | Disable field interaction |
| `col` | `string` | Bootstrap column class (default: `'col-12'`) |
| `maxlength` | `int` | Max character length (auto-enriched from DB schema) |
| `min` / `max` | `int` | Numeric constraints |
| `default_value` | `mixed` | Default value |
| `module` | `string` | Required module for visibility (`isVisible()`) |
| `placeholder` | `string` | Input placeholder text |

### Key Methods

| Method | Signature | Description |
|---|---|---|
| `getType()` | `abstract getType(): string` | Returns field type identifier |
| `getField()` | `getField(): string` | Returns field name |
| `getLabel()` | `getLabel(): string` | Returns display label |
| `getComponent()` | `getComponent(): string` | Returns Blade component name |
| `getOptions()` | `getOptions(): array` | Returns options array |
| `mergeOptions()` | `mergeOptions(array $newOptions): void` | Merges additional options |
| `isVisible()` | `isVisible(): bool` | Checks module-dependent visibility |
| `addAction()` | `addAction(string $icon, string $onclick, ...): self` | Adds an action button to the field |
| `render()` | `render(array $extraData = []): string` | Renders field to HTML via Blade |
| `jsonSerialize()` | `jsonSerialize(): array` | Serializes for JSON/Blade consumption |

---

## Concrete Field Types

### `Text`
Standard single-line text input.
```php
new Text('name', 'Full Name', ['required' => true, 'maxlength' => 100])
```

### `Textarea`
Multi-line text area.
```php
new Textarea('description', 'Description', ['rows' => 5])
```

### `Integer`
Numeric input for integer values.
```php
new Integer('quantity', 'Quantity', ['min' => 0, 'max' => 9999])
```

### `Decimal`
Numeric input for decimal values.
```php
new Decimal('price', 'Price', ['min' => 0, 'step' => '0.01'])
```

### `Boolean`
Checkbox/toggle for boolean values.
```php
new Boolean('is_active', 'Active')
```

### `Date`
Date picker input.
```php
new Date('birth_date', 'Birth Date')
```

### `DateTime`
Date and time picker input.
```php
new DateTime('created_at', 'Created At', ['readonly' => true])
```

### `Time`
Time picker input.
```php
new Time('start_time', 'Start Time')
```

### `Select`
Dropdown select with static options.
```php
new Select('status', 'Status', [
    'options' => ['values' => ['draft' => 'Draft', 'published' => 'Published']]
])
```

### `Select2`
Enhanced select with search, AJAX loading, and multi-select support.
```php
new Select2('category_id', 'Category', [
    'options' => ['ajax_url' => '/api/categories', 'multiple' => false]
])
```

### `RelationList`
Displays a related records list (one-to-many relationship).
```php
new RelationList('orders', 'Orders', [
    'options' => ['model' => Order::class, 'columns' => ['id', 'total', 'date']]
])
```

### `Hidden`
Hidden input field.
```php
new Hidden('token', 'Token')
```

### `StaticText`
Non-editable display text.
```php
new StaticText('info', 'Information', ['options' => ['text' => 'Read-only value']])
```

### `Icon`
Icon selector/display field.
```php
new Icon('icon', 'Icon', ['options' => ['preview' => true]])
```

### `Image`
Image upload/display field.
```php
new Image('avatar', 'Avatar', ['options' => ['max_size' => 2048]])
```

---

## Example: Form with Actions

```php
$nameField = new Text('name', 'Customer Name', ['required' => true]);
$nameField->addAction(
    'fas fa-search',
    "window.open('https://google.com/search?q=' + this.closest('.input-group').querySelector('input').value)",
    'Search on Google'
);

$fields = [
    $nameField,
    new Select('country', 'Country', ['options' => ['values' => $countries]]),
    new Decimal('balance', 'Balance', ['readonly' => true, 'col' => 'col-6']),
    new Boolean('vip', 'VIP Customer'),
];
```
