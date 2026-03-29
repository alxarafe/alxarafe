# Capa de Servicios – Referencia de API

`Namespace: Alxarafe\Service`

Servicios de aplicación: sistema de hooks/eventos, email, PDF, Markdown y despacho API.

---

## `HookService`

Sistema de eventos/hooks que permite a plugins y módulos interceptar y modificar el comportamiento del framework.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `register()` | `static register(string $hookName, callable $callback, int $priority = 10): void` | Registra callback para un hook. |
| `execute()` | `static execute(string $hookName, mixed ...$args): void` | Ejecuta callbacks de un hook (acciones void). |
| `filter()` | `static filter(string $hookName, mixed $value, mixed ...$args): mixed` | Pasa un valor por todos los filtros registrados. |
| `resolve()` | `static resolve(string $template, array $params): string` | Construye nombre de hook desde plantilla. |

## `HookPoints`

Constantes de puntos de hook estándar: `BEFORE_SAVE`, `AFTER_SAVE`, `BEFORE_DELETE`, `AFTER_DELETE`, `FORM_FIELDS_AFTER`.

## `EmailService`

Envío de email SMTP vía Symfony Mailer. Método: `send(string $to, string $subject, string $body, array $options): bool`.

## `PdfService`

Generación de PDF desde HTML usando DOMPDF. Métodos: `generateFromHtml()`, `downloadFromHtml()`.

## `MarkdownService`

Conversión de Markdown a HTML usando Parsedown. Método: `parse(string $markdown): string`.

## `MarkdownSyncService`

Sincronización de documentación entre versiones de idioma.

## Servicios API

- **`ApiDispatcher`**: Despacho de peticiones API, validación JWT, formateo de respuestas.
- **`ApiRouter`**: Construye tabla de rutas API desde atributos `#[ApiRoute]`.
- **`ApiException`**: Excepción personalizada para errores API.
