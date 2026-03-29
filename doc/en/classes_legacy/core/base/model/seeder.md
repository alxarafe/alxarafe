# Seeder (Data Population)

::: info
**Namespace:** `Alxarafe\Base`  
**Usage:** Base class for master data and initial configuration.  
**Status:** 🛠️ Refactored to PHP 8.5.1
:::

The `Seeder` class allows automating the insertion of initial records into the database (such as a list of countries, document types, or admin users). It works closely with **Eloquent Models**.

## Execution Logic

The class constructor implements native protection to avoid duplicates:
1. **Optional Truncate:** If instantiated with `true`, empties the table completely before starting.
2. **Count Verification:** The `run()` method only executes if the table is currently empty.

## Methods to Implement

When creating a new seeder, it is mandatory to define two methods:

| Method | Return | Description |
| :--- | :--- | :--- |
| `model()` | `class-string` | Must return the model class name (e.g., `User::class`). |
| `run()` | `void` | Contains record creation logic (e.g., `$model::create([...])`). |

## Implementation Example

```php
namespace Alxarafe\Seeder;

use Alxarafe\Base\Seeder;
use Alxarafe\Model\Country;

class CountrySeeder extends Seeder
{
    protected static function model(): string
    {
        return Country::class;
    }

    protected function run(string $model): void
    {
        $model::create(['name' => 'Spain', 'iso' => 'ES']);
        $model::create(['name' => 'Portugal', 'iso' => 'PT']);
    }
}
```

## Technical Changes (v8.5.1)

- Strict Class Typing: Uses type `class-string<Model>` to ensure the seeder only operates with classes inheriting from our base Model.
- Scalar Typing: Added `bool` to constructor parameter and `void` as return of `run()`.
- Data Protection: Reinforced save logic to avoid accidental collisions during the automatic migration process.
