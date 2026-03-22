# Capa Lib – Referencia de API

`Namespace: Alxarafe\Lib`

Bibliotecas utilitarias: autenticación, traducciones, mensajería, enrutamiento y helpers HTTP.

---

## `Auth` (abstract)

Autenticación basada en cookies con soporte JWT.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `isLogged()` | `static isLogged(): bool` | Verifica autenticación vía token de cookie. |
| `login()` | `static login(string $username, string $password): bool` | Autentica con usuario y contraseña. |
| `logout()` | `static logout(): void` | Limpia cookies de autenticación. |
| `getSecurityKey()` | `static getSecurityKey(): ?string` | Devuelve clave secreta JWT. |

---

## `Trans` (abstract)

Capa de internacionalización envolviendo Symfony Translator con carga de archivos YAML. Soporta 18 idiomas y fallback jerárquico.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `_()` | `static _(string $message, array $parameters = [], ?string $locale = null): string` | Traduce una clave. Parámetros usan sintaxis `%name%`. |
| `setLang()` | `static setLang($lang): void` | Establece idioma activo y carga YAML. |
| `getLocale()` | `static getLocale(): string` | Devuelve código de locale actual. |
| `getAvailableLanguages()` | `static getAvailableLanguages(): array` | Devuelve `[código => nombre]`. |
| `getMissingStrings()` | `static getMissingStrings(): array` | Claves sin traducción (depuración). |

---

## `Messages` (abstract)

Sistema de mensajes flash. Acumulados durante la petición y renderizados vía `afterAction()`.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `addMessage()` | `static addMessage($message): void` | Mensaje de éxito (alerta verde). |
| `addAdvice()` | `static addAdvice($message): void` | Advertencia (alerta amarilla). |
| `addError()` | `static addError($message): void` | Error (alerta roja). |
| `getMessages()` | `static getMessages(): array` | Devuelve y limpia todos los mensajes. |

---

## `Functions` (abstract)

Utilidades HTTP, helpers de URL, operaciones de archivos y descubrimiento de temas.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `getUrl()` | `static getUrl(): string` | Auto-detecta URL base de la aplicación. |
| `httpRedirect()` | `static httpRedirect(string $url): void` | Envía redirección HTTP. |
| `htmlAttributes()` | `static htmlAttributes(array $attributes): string` | Convierte array a atributos HTML. |
| `getThemes()` | `static getThemes(): array` | Descubre temas instalados. |
| `recursiveRemove()` | `static recursiveRemove(string $dir, bool $removeRoot): int` | Elimina directorio recursivamente. |

---

## `Routes` (abstract)

Auto-descubre controladores, modelos, migraciones y seeders escaneando directorios de módulos.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `getAllRoutes()` | `static getAllRoutes(): array` | Mapa de rutas cacheado: `Controller`, `Api`, `Model`, `Migrations`, `Seeders`. |
| `addRoutes()` | `static addRoutes(array $routes): void` | Añade rutas de búsqueda personalizadas. |
| `invalidateCache()` | `static invalidateCache(): void` | Limpia caché de rutas. |

---

## `Router` (abstract)

Matching y generación de URLs amigables.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `match()` | `static match(string $uri): ?array` | Hace matching de URI contra rutas registradas. |
| `generate()` | `static generate(string $module, string $controller, string $action, array $params): ?string` | Genera URL amigable. |
