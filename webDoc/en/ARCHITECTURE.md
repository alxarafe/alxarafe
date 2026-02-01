# Alxarafe Architecture

Alxarafe follows a modular MVC (Model-View-Controller) pattern, but with a strong emphasis on "Convention over Configuration" to minimize boilerplate code.

## 1. Request Lifecycle

The framework does not enforce a single `index.php`, but the recommended flow is:

1.  **Entry Point:** The web server directs the request to an entry script (usually `index.php`).
2.  **Dispatch:** The script invokes `Alxarafe\Tools\Dispatcher\WebDispatcher` (or `ApiDispatcher`).
3.  **Routing:** The Dispatcher consults `Routes::getAllRoutes()` to find the appropriate controller class based on the parameters (Module, Controller).
4.  **Execution:**
    *   The Controller is instantiated.
    *   The requested method is searched for. If it does not exist, it falls back to `index`.
    *   If the controller extends `GenericController`, the `index` (or other method) invokes the action logic (`doAction`).
5.  **Rendering:** Upon execution completion (controller object destruction), the `ViewTrait` automatically renders the associated Blade template.

## 2. Routing System

Alxarafe **does not use route files**. Routes are generated dynamically by scanning code directories.

*   Class: `Alxarafe\Lib\Routes`
*   Mechanism: Scans `src/Modules/` and `vendor/alxarafe/alxarafe/src/Modules/`.
*   Recognized Patterns:
    *   `*Controller.php` -> Web Routes.
    *   `*Api.php` -> API Routes.
    *   `*Migration.php` -> Migrations.

For example, if `src/Modules/Blog/Controller/PostController.php` exists, a route is automatically generated (depending on how your `index.php` handles parameters, e.g., `?module=Blog&controller=Post`).

## 3. Controllers

Controllers inherit from `Alxarafe\Base\Controller\Controller` (for protected routes) or `GenericController`.

### `doAction` Pattern
Although the Dispatcher calls the public method (e.g., `save()`), `GenericController` implements a pattern where the actual logic resides in methods with the `do` prefix (e.g., `doSave()`).

This allows:
1.  Intercepting the call in `beforeAction()` and `afterAction()`.
2.  Handling the default `index` action, which reads the `action` request parameter (`$_REQUEST['action']`) and redirects to the corresponding `doAction`.

**Example:**
A call to `PostController->index()` with `?action=create` will internally execute `doCreate()`.

## 4. Views

The view system uses **Blade** (Laravel's template engine).

*   **Automatic Rendering:** It is not necessary to call `view()` or `render()`. The `Alxarafe\Base\Controller\Trait\ViewTrait` handles rendering the template in the controller's `__destruct()` method.
*   **Naming Convention:** By default, a `PostController` controller will look for a template in `page/post.blade.php`.
*   **Location:** Templates are searched for in priority order:
    1.  `src/Modules/{Module}/Templates/` (in your project).
    2.  `vendor/.../src/Modules/{Module}/Templates/` (in the core).

## 5. REST API

For APIs, `ApiDispatcher` is used, and controllers inherit from `Alxarafe\Base\Controller\ApiController`.
*   **Authentication:** Native JWT support.
*   **Response:** Helper methods `jsonResponse()` and `badApiCall()` to standardize JSON outputs.

## 6. Database

*   **Configuration:** Defined in `config.json`.
*   **Abstraction:** `Alxarafe\Base\Database` (based on PDO/Illuminate Database) is used.
*   **Traits:** `DbTrait` facilitates connection and common operations in controllers.
*   **Models:** It is recommended to use Eloquent (Illuminate) or the Alxarafe base model.
