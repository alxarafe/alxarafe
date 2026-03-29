# Lib Layer – API Reference

`Namespace: Alxarafe\Lib`

Utility libraries providing cross-cutting concerns: authentication, translations, messaging, routing, and HTTP helpers.

---

## `Auth` (abstract)

**Source:** [Auth.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Lib/Auth.php)

Cookie-based authentication with JWT support. Manages user sessions via secure HTTP-only cookies.

### Properties

| Property | Type | Description |
|---|---|---|
| `$user` | `?Modules\Admin\Model\User` | Currently authenticated user (static) |

### Methods

| Method | Signature | Description |
|---|---|---|
| `isLogged()` | `static isLogged(): bool` | Checks if user is authenticated via cookie token. |
| `login()` | `static login(string $username, string $password): bool` | Authenticates with username and password. Sets cookie on success. |
| `logout()` | `static logout(): void` | Clears authentication cookies and resets `$user`. |
| `setLoginCookie()` | `static setLoginCookie($userId): void` | Creates auth cookies for a specific user ID. |
| `getSecurityKey()` | `static getSecurityKey(): ?string` | Returns JWT secret key from config (auto-generates if missing). |

### Example

```php
use Alxarafe\Lib\Auth;

if (Auth::isLogged()) {
    echo "Hello, " . Auth::$user->name;
} else {
    Auth::login('admin', 'password123');
}
```

---

## `Trans` (abstract)

**Source:** [Trans.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Lib/Trans.php)

Internationalization layer wrapping Symfony Translator with YAML file loading. Supports 18 languages and hierarchical fallback (e.g., `es_AR` → `es` → `en`).

### Constants

| Constant | Value | Description |
|---|---|---|
| `FALLBACK_LANG` | `'en'` | Default language |

### Methods

| Method | Signature | Description |
|---|---|---|
| `_()` | `static _(string $message, array $parameters = [], ?string $locale = null): string` | Translate a key. Parameters use `%name%` syntax. |
| `trans()` | `static trans($message, array $parameters = [], $locale = null): string` | Alias for `_()`. |
| `initialize()` | `static initialize(): bool` | Initializes the Symfony Translator singleton. |
| `setLang()` | `static setLang($lang): void` | Sets active language and loads YAML files from all modules. |
| `getLocale()` | `static getLocale(): string` | Returns current locale code. |
| `wasSet()` | `static wasSet(): bool` | Returns true if `setLang()` has been called. |
| `getAvailableLanguages()` | `static getAvailableLanguages(): array` | Returns `[code => name]` from DB or YAML scan. |
| `getAvailableLanguagesWithFlags()` | `static getAvailableLanguagesWithFlags(): array` | Returns `[code => ['name', 'flag']]` for UI rendering. |
| `getMissingStrings()` | `static getMissingStrings(): array` | Returns untranslated keys (debug use). |
| `getAll()` | `static getAll(): array` | Returns all loaded translations. |

### Translation File Loading Order

1. Core framework: `ALX_PATH/src/Lang/{lang}.yaml`
2. Application: `APP_PATH/Lang/{lang}.yaml`
3. Each module: `Modules/{Module}/Lang/{lang}.yaml`
4. Active module override (from `$_GET['module']`)

### Example

```php
use Alxarafe\Lib\Trans;

Trans::setLang('es');
echo Trans::_('welcome_message', ['name' => 'Juan']);
// Output: "Bienvenido, Juan" (from es.yaml)
```

---

## `Messages` (abstract)

**Source:** [Messages.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Lib/Messages.php)

Flash message system. Messages are accumulated during the request and rendered once via `ViewController::afterAction()`.

### Methods

| Method | Signature | Description |
|---|---|---|
| `addMessage()` | `static addMessage($message): void` | Add success message (green alert). |
| `addAdvice()` | `static addAdvice($message): void` | Add warning message (yellow alert). |
| `addError()` | `static addError($message): void` | Add error message (red alert). |
| `getMessages()` | `static getMessages(): array` | Returns and clears all messages as `[['type' => 'success|warning|danger', 'text' => '...']]`. |

---

## `Functions` (abstract)

**Source:** [Functions.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Lib/Functions.php)

HTTP utilities, URL helpers, file operations, and theme discovery.

### Methods

| Method | Signature | Description |
|---|---|---|
| `getUrl()` | `static getUrl(): string` | Auto-detects the application base URL (protocol, host, path). |
| `getIfIsset()` | `static getIfIsset($postVar, $defaultValue): mixed` | Returns POST value or default. |
| `defineIfNotDefined()` | `static defineIfNotDefined(string $name, $value): void` | Defines a constant only if not already defined. |
| `htmlAttributes()` | `static htmlAttributes(array $attributes): string` | Converts `['key' => 'value']` to HTML attribute string. |
| `getThemes()` | `static getThemes(): array` | Discovers installed themes from filesystem. |
| `httpRedirect()` | `static httpRedirect(string $url): void` | Sends HTTP redirect (throws exception in test mode). |
| `exec()` | `static exec(string $command): void` | Executes shell command with error handling. |
| `recursiveRemove()` | `static recursiveRemove(string $dir, bool $removeRoot = false): int` | Recursively deletes directory contents. Returns count. |

---

## `Routes` (abstract)

**Source:** [Routes.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Lib/Routes.php)

Auto-discovers controllers, models, migrations, and seeders by scanning module directories.

### Methods

| Method | Signature | Description |
|---|---|---|
| `getAllRoutes()` | `static getAllRoutes(): array` | Returns cached route map: `['Controller' => [...], 'Api' => [...], 'Model' => [...], 'Migrations' => [...], 'Seeders' => [...]]`. |
| `addRoutes()` | `static addRoutes(array $routes): void` | Adds custom search paths (clears cache). |
| `invalidateCache()` | `static invalidateCache(): void` | Clears the route cache. Call after module activation changes. |

### Search Paths

| Namespace | Path |
|---|---|
| `Modules\` | `APP_PATH/Modules/` |
| `Modules\` | `ALX_PATH/src/Modules/` |

---

## `Router` (abstract)

**Source:** [Router.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Lib/Router.php)

Friendly URL matching and generation. Provides named routes as an alternative to query string parameters.

### Methods

| Method | Signature | Description |
|---|---|---|
| `match()` | `static match(string $uri): ?array` | Matches request URI to a registered route. Returns `['module', 'controller', 'action', 'params', 'name']` or null. |
| `generate()` | `static generate(string $module, string $controller, string $action, array $params = []): ?string` | Generates a friendly URL for a given route. |
