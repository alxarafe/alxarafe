# ViewTrait

::: info
**Namespace:** `Alxarafe\Base\Controller\Trait`  
**Usage:** Injected into controllers that need to render HTML.  
**Status:** 🛠️ Refactored to PHP 8.5.1
:::

The `ViewTrait` is responsible for managing communication between controller logic and the presentation layer (views). It facilitates data injection and template selection.

## Main Functionality

### Data Management (`viewData`)
The trait maintains an internal variable container. These variables are automatically extracted when rendering the view, allowing them to be available as local variables in PHP template files.

### Main Methods

| Method | Description |
| :--- | :--- |
| `setDefaultTemplate()` | Initializes the template engine with a specific design. |
| `addVariable()` | Adds a key/value pair usage in the view. |
| `addVariables()` | Merges a complete array of data into the view container. |
| `render()` | Executes template processing and returns the resulting HTML. |

## Usage Example

```php
class ArticleController extends ViewController
{
    public function doShow(): bool
    {
        // Add a single variable
        $this->addVariable('title', 'My first article');
        
        // Add multiple variables
        $this->addVariables([
            'author' => 'Rafael San José',
            'date' => date('Y-m-d')
        ]);

        return true;
    }
}
```

## Technical Changes (v8.5.1)

- Strict Typing: Implemented `declare(strict_types=1)` and `void` and `string` return types.
- Typed Properties: The `$template` property is now typed as `?Template` to avoid errors accessing nulls.
- Name Cleanup: Renamed internal data property to `$viewData` (previously could be ambiguous) for semantic clarity.
- Lazy Initialization: The `render()` method ensures the Template object exists before attempting to process the view.
