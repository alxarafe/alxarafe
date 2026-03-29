# Component Filters – API Reference

`Namespace: Alxarafe\Component\Filter`

Filter components for list views. All filters extend `AbstractFilter`.

---

## `AbstractFilter`

**Namespace:** `Alxarafe\Component\AbstractFilter`  
**Source:** [AbstractFilter.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Component/AbstractFilter.php)

Base class for list view filters. Applies query conditions to the Eloquent query builder.

### Constructor

```php
public function __construct(string $field, string $label, array $options = [])
```

---

## `TextFilter`
Free-text search filter (LIKE query).
```php
new TextFilter('name', 'Search by Name')
```

## `SelectFilter`
Dropdown filter with predefined options.
```php
new SelectFilter('status', 'Status', ['options' => ['active' => 'Active', 'inactive' => 'Inactive']])
```

## `Select2Filter`
Enhanced select filter with AJAX search.
```php
new Select2Filter('category_id', 'Category', ['ajax_url' => '/api/categories'])
```

## `AutocompleteFilter`
Text input with autocomplete suggestions.
```php
new AutocompleteFilter('city', 'City', ['source_url' => '/api/cities'])
```

## `DateRangeFilter`
Date range picker filter (from/to).
```php
new DateRangeFilter('created_at', 'Created Between')
```

## `RelationFilter`
Filter by foreign key relationship.
```php
new RelationFilter('user_id', 'User', ['model' => User::class, 'display' => 'name'])
```
