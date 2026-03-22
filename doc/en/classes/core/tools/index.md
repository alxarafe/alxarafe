# Tools Layer – API Reference

`Namespace: Alxarafe\Tools`

Infrastructure tools for request dispatching, debugging, module management, and dependency resolution.

---

## `Dispatcher`

**Namespace:** `Alxarafe\Tools\Dispatcher`  
**Source:** [Dispatcher.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Tools/Dispatcher.php)

Main entry point for the framework. Initializes constants, translation system, and routes to the appropriate dispatcher.

### Constants

| Constant | Value | Description |
|---|---|---|
| `MODULE` | `'module'` | GET parameter name for module |
| `CONTROLLER` | `'controller'` | GET parameter name for controller |

### Methods

| Method | Signature | Description |
|---|---|---|
| `run()` | `static run(array $alternative_routes = []): void` | Bootstrap and dispatch. Detects API vs Web request and delegates. |

---

## `WebDispatcher`

**Namespace:** `Alxarafe\Tools\Dispatcher\WebDispatcher`  
**Extends:** `Dispatcher`  
**Source:** [WebDispatcher.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Tools/Dispatcher/WebDispatcher.php)

Handles web requests: route resolution, controller instantiation, theme/language resolution, template path setup, and error handling.

### Methods

| Method | Signature | Description |
|---|---|---|
| `dispatch()` | `static dispatch(string $defaultModule, string $defaultController, string $defaultAction): bool` | Full lifecycle entry point with path setup, route loading, and error handling. |
| `run()` | `static run(string $module, string $controller, string $method): bool` | Core dispatch: resolve controller from routes, instantiate, configure templates, call method. |

### Error Handling

1. **First failure** → Redirect to `ErrorController`
2. **Loop guard** → If already in error state, render raw HTML directly
3. **Emergency** → Minimal styled error page with 500 status

---

## `ApiDispatcher` (Tools)

**Namespace:** `Alxarafe\Tools\Dispatcher\ApiDispatcher`  
**Source:** [ApiDispatcher.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Tools/Dispatcher/ApiDispatcher.php)

Handles API requests: parses the URL path, matches to API controllers, validates JWT, and returns JSON.

---

## `Debug`

**Namespace:** `Alxarafe\Tools\Debug`  
**Source:** [Debug.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Tools/Debug.php)

Integrates PHP DebugBar for development. Provides message logging and header/footer rendering.

### Methods

| Method | Signature | Description |
|---|---|---|
| `initialize()` | `static initialize(bool $reload = false): void` | Initializes DebugBar if debug mode is enabled in config. |
| `message()` | `static message(string $msg): void` | Logs a debug message to DebugBar (no-op if debug disabled). |
| `getDebugBar()` | `static getDebugBar(): ?DebugBar` | Returns the DebugBar instance or null. |
| `getRenderHeader()` | `static getRenderHeader(): string` | Returns DebugBar CSS/JS includes. |
| `getRenderFooter()` | `static getRenderFooter(): string` | Returns DebugBar JS initialization. |

---

## `ModuleManager`

**Namespace:** `Alxarafe\Tools\ModuleManager`  
**Source:** [ModuleManager.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Tools/ModuleManager.php)

Scans module directories, reads `#[ModuleInfo]` attributes, and builds the navigation menu arrays.

### Methods

| Method | Signature | Description |
|---|---|---|
| `getArrayMenu()` | `static getArrayMenu(): array` | Returns top-level menu items from all modules. |
| `getArraySidebarMenu()` | `static getArraySidebarMenu(): array` | Returns sidebar menu items from all modules. |

---

## `DependencyResolver`

**Namespace:** `Alxarafe\Tools\DependencyResolver`  
**Source:** [DependencyResolver.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Tools/DependencyResolver.php)

Builds a directed acyclic graph (DAG) of module dependencies by scanning `use` statements and `#[RequireModule]` attributes. Used to determine activation order and detect circular dependencies.

---

## DebugBar Collectors

### `PhpCollector`

**Namespace:** `Alxarafe\Tools\DebugBarCollector\PhpCollector`  
**Source:** [PhpCollector.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Tools/DebugBarCollector/PhpCollector.php)

Custom DebugBar collector for PHP environment information.

### `TranslatorCollector`

**Namespace:** `Alxarafe\Tools\DebugBarCollector\TranslatorCollector`  
**Source:** [TranslatorCollector.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Tools/DebugBarCollector/TranslatorCollector.php)

Shows missing translation keys and loaded translation files in the DebugBar.
