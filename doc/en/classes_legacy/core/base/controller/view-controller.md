# ViewController

::: info
**Namespace:** `Alxarafe\Base\Controller`  
**Extends:** `GenericController`  
**Uses:** `ViewTrait`  
:::

The `ViewController` is the base class for all controllers that require rendering a visual interface. It integrates business logic with the framework's template system.

## Features

- **View Management:** Inherits methods to assign variables and change templates via `ViewTrait`.
- **Automatic Configuration:** Loads the `Config` object and sets the global language in the constructor.
- **Integrated Debugging:** Includes hooks to render headers and footers with debug information.

## Properties

| Property | Type | Description |
| :--- | :--- | :--- |
| `$config` | `object` | Stores configuration loaded from `Config::getConfig()`. |
| `$debug` | `bool` | If `true`, allows output of debug information. |

## Usage Example

```php
namespace Alxarafe\Controller;

class Contact extends ViewController
{
    public function doIndex(): bool
    {
        $this->addVariable('title', 'Contact us');
        return true;
    }
}
```

## Technical Changes (v8.5.1)

- Property Typing: Explicitly defined the type of `$config` and `$debug`.
- Constructor: Now correctly propagates `$action` and `$data` to the parent constructor.
- Method Refactoring: Rendering methods now use ternary expressions for brevity.
