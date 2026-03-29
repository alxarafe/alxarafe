# GenericPublicController

::: info
**Namespace:** `Alxarafe\Base\Controller`  
**Extends:** `ViewController`  
**Uses:** `DbTrait`  
:::

The `GenericPublicController` is an abstract class designed to manage public pages that need database access and view rendering, but **do not require user authentication**.

## Functionality

This class combines the power of views and the database in a single point:

1.  **View Inheritance:** By extending `ViewController`, it inherits all template logic and language configuration.
2.  **Data Connection:** through the use of `DbTrait`, the controller automatically establishes a database connection at the time of its creation via the `static::connectDb()` method.

## When to use it

It is the ideal starting point for:
- Home pages.
- Login or Registration screens.
- Public product catalogs.
- "Contact" or "About" pages.

## Implementation Example

```php
namespace Alxarafe\Controller;

use Alxarafe\Base\Controller\GenericPublicController;

class Welcome extends GenericPublicController
{
    public function doIndex(): bool
    {
        // The database is already connected here
        $this->addVariable('message', 'Welcome to our public web');
        return true;
    }
}
```

## Technical Changes (v8.5.1)

- Constructor Synchronization: Now accepts `$action` and `$data` parameters to maintain consistency with the controller hierarchy.
- Strict Typing: Incorporated `declare(strict_types=1)` to ensure data integrity throughout the inheritance chain.
- Copyright Format: Updated to the 2026 legal standard.
