# Model (Data Layer)

::: info
**Namespace:** `Alxarafe\Base\Model`  
**Extends:** `Illuminate\Database\Eloquent\Model`  
**Status:** 🛠️ Refactored to PHP 8.5.1
:::

The base `Model` class integrates the **Eloquent** ORM (from Laravel) into the Alxarafe ecosystem, adding useful schema introspection features for dynamic interface generation.

## Extra Functionalities

In addition to all Eloquent capabilities (Query Builder, relations, etc.), this class adds:

### Schema Introspection
Using the `getFields()` method, the model queries the database engine directly (`SHOW COLUMNS`) to obtain real-time metadata. This allows knowing:
- If a field is mandatory (*required*).
- The most suitable HTML input type (*genericType*).
- Maximum lengths and default values.

### Type Mapping
The `mapToGenericType()` method translates complex SQL types (like `varchar`, `tinyint`, or `text`) into simplified frontend types (`text`, `number`, `boolean`, `textarea`).

## Main Methods

| Method | Description |
| :--- | :--- |
| `existsInSchema()` | Verifies if the physical table exists in the current database. |
| `primaryColumn()` | Returns the name of the column acting as the primary key. |
| `getFields()` | Returns an associative array with each column's configuration. |

## Usage Example

```php
namespace Alxarafe\Model;

use Alxarafe\Base\Model\Model;

class User extends Model
{
    protected $table = 'users';
}

// Get metadata to build a dynamic form
$fields = User::getFields();
```

## Technical Changes (v8.5.1)

- Match Expression: Replaced the `if` chain in `mapToGenericType` with a PHP 8.x `match` expression, much cleaner and more efficient.
- Return Typing: Added `declare(strict_types=1)` and strict types in all methods.
- Semantic Renaming: Eloquent's `exists()` method can conflict with table existence logic, so it has been renamed to `existsInSchema()` for greater clarity.
- Safe Casting: Ensures casting to `string` of properties returned by `DB::select` to avoid typing errors.
