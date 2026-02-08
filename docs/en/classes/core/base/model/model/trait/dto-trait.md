# DtoTrait

::: info
**Namespace:** `Alxarafe\Base\Model\Trait`  
**Usage:** Injected into models or data classes to provide dynamic access.  
**Status:** 🛠️ Refactored to PHP 8.5.1
:::

The `DtoTrait` allows objects to behave as intelligent data containers. It provides access via magic methods, facilitating the use of "getters" and "setters" without needing to manually define them if following a naming convention.

## Dynamic Access

The Trait intercepts property access to search for methods meeting `snake_case` or `camelCase` conventions.

### Name Resolution Example
If you try to access `$object->full_name`:
1. The Trait will search for method `get_full_name()`.
2. If distinct, it will search for `getFullName()`.
3. If not existing, it will attempt to return property `$full_name` directly.

## Utility Methods

| Method | Description |
| :--- | :--- |
| `setData(stdClass $data)` | Hydrates the current object with data from a generic object. |
| `toArray()` | Converts visible object properties into an associative array. |

## Implementation Example

```php
class UserDTO
{
    use DtoTrait;

    private string $name = 'Rafael';

    public function getName(): string
    {
        return strtoupper($this->name);
    }
}

$user = new UserDTO();
echo $user->name; // Output: RAFAEL (via magic getter)
```

## Technical Changes (v8.5.1)

- Multi-format Support: Resolved pending items to support `set_property` and `setProperty` interchangeably.
- Argument Unpacking: The `__call` method now uses the splat operator (`...$arguments`) to pass parameters natively.
- `toArray` Optimization: Replaced double JSON encoding with `get_object_vars()` for significantly higher performance.
- Strict Typing: Implementation of scalar types in all magic methods.
