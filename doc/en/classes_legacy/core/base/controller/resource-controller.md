# ResourceController

::: info
**Namespace:** `Alxarafe\Base\Controller`
**Extends:** `Controller`
:::

The `ResourceController` is a unified controller designed to simplify resource management (CRUD). It combines list and edit views into a single logic flow, automatically toggling modes based on the presence of a record identifier.

## Features

- **Dual Mode:** Automatically detects whether to display a list (`MODE_LIST`) or an edit form (`MODE_EDIT`) based on request parameters (`id` or `code`).
- **Auto-Scaffolding:** Capable of automatically generating list columns and edit fields by inspecting the associated Eloquent Model metadata.
- **Multi-Tab Support:** Allows defining multiple related models (e.g., Main, Addresses, Phones) and automatically generates navigation tabs.
- **Integrated AJAX API:** Includes native methods to retrieve JSON data (`fetchListData`, `fetchRecordData`) and save records (`saveRecord`), facilitating SPA (Single Page Application) interface creation.
- **UI Components:** Transforms SQL data types (date, boolean, varchar) into Alxarafe visual components (`Date`, `Boolean`, `Text`).

## Properties

| Property | Type | Description |
| :--- | :--- | :--- |
| `$mode` | `string` | Current controller mode (`list` or `edit`). |
| `$recordId` | `string\|null` | ID of the current record in edit mode. |
| `$modelClass` | `string\|null` | Primary model class (for simple controllers). |
| `$structConfig` | `array` | Configuration array defining tabs, buttons, and fields for the view. |

## Main Methods

- `getModelClass()`: Abstract method determining the associated model(s). Returns a class string (`Person::class`) or an array of tabs (`['general' => Person::class, 'addr' => Address::class]`).
- `buildConfiguration()`: Builds the interface configuration. If manual field definitions are missing, it invokes `convertModelFieldsToComponents()` to generate them from the model.
- `convertModelFieldsToComponents(array $modelFields)`: Converts Eloquent field metadata into UI component objects.

## Usage Example

```php
namespace Modules\Agenda\Controller;

use Alxarafe\Base\Controller\ResourceController;
use Modules\Agenda\Model\Person;

class PersonController extends ResourceController
{
    // Basic definition: controller will auto-scaffold columns and fields
    public static function getModelClass(): string
    {
        return Person::class;
    }

    // Optional: Customize filters
    protected function getFilters(): array
    {
        return [
            new DateRangeFilter('created_at', 'Date Created'),
        ];
    }
}
```
