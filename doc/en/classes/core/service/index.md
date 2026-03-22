# Service Layer – API Reference

`Namespace: Alxarafe\Service`

Application services providing hook/event system, email, PDF, Markdown, and API dispatch capabilities.

---

## `HookService`

**Source:** [HookService.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Service/HookService.php)

Event/hook system allowing plugins and modules to intercept and modify framework behavior without modifying core code.

### Methods

| Method | Signature | Description |
|---|---|---|
| `register()` | `static register(string $hookName, callable $callback, int $priority = 10): void` | Register a callback for a hook point. |
| `execute()` | `static execute(string $hookName, mixed ...$args): void` | Fire all callbacks for a hook (void actions). |
| `filter()` | `static filter(string $hookName, mixed $value, mixed ...$args): mixed` | Pass a value through all registered filters. Returns modified value. |
| `resolve()` | `static resolve(string $template, array $params = []): string` | Builds a hook name from a template (e.g. `HookPoints::BEFORE_SAVE` + `['entity' => 'Post']` → `'before_save.Post'`). |

### Example

```php
use Alxarafe\Service\HookService;
use Alxarafe\Service\HookPoints;

// Register a hook
HookService::register('after_save.Order', function ($order) {
    // Send notification email when an order is saved
    EmailService::send($order->customer_email, 'Order Confirmed', '...');
});

// Execute hook (called by ResourceTrait)
HookService::execute('after_save.Order', $order);
```

---

## `HookPoints`

**Source:** [HookPoints.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Service/HookPoints.php)

Constants defining standard hook point templates used across the framework.

### Constants

| Constant | Template | Description |
|---|---|---|
| `BEFORE_SAVE` | `'before_save.{entity}'` | Before a record is saved |
| `AFTER_SAVE` | `'after_save.{entity}'` | After a record is saved |
| `BEFORE_DELETE` | `'before_delete.{entity}'` | Before a record is deleted |
| `AFTER_DELETE` | `'after_delete.{entity}'` | After a record is deleted |
| `FORM_FIELDS_AFTER` | `'form_fields_after.{entity}'` | Filter: modify form fields before rendering |

---

## `EmailService`

**Source:** [EmailService.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Service/EmailService.php)

SMTP email sending via Symfony Mailer. Configuration loaded from `config.json` email section.

### Methods

| Method | Signature | Description |
|---|---|---|
| `send()` | `static send(string $to, string $subject, string $body, array $options = []): bool` | Send an email. Options: `from`, `cc`, `bcc`, `attachments`, `html`. |

---

## `PdfService`

**Source:** [PdfService.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Service/PdfService.php)

HTML to PDF generation using DOMPDF.

### Methods

| Method | Signature | Description |
|---|---|---|
| `generateFromHtml()` | `static generateFromHtml(string $html, array $options = []): string` | Returns PDF binary from HTML. Options: `paper_size`, `orientation`. |
| `downloadFromHtml()` | `static downloadFromHtml(string $html, string $filename, array $options = []): void` | Sends PDF download response. |

---

## `MarkdownService`

**Source:** [MarkdownService.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Service/MarkdownService.php)

Markdown to HTML conversion using Parsedown.

### Methods

| Method | Signature | Description |
|---|---|---|
| `parse()` | `static parse(string $markdown): string` | Converts Markdown text to HTML. |

---

## `MarkdownSyncService`

**Source:** [MarkdownSyncService.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Service/MarkdownSyncService.php)

Documentation synchronization service for maintaining parity between language versions.

---

## API Services

### `ApiDispatcher` (Service)

**Namespace:** `Alxarafe\Service\ApiDispatcher`  
**Source:** [ApiDispatcher.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Service/ApiDispatcher.php)

Handles API request dispatching, JWT token validation, and response formatting.

### `ApiRouter`

**Namespace:** `Alxarafe\Service\ApiRouter`  
**Source:** [ApiRouter.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Service/ApiRouter.php)

Builds the API route table from `#[ApiRoute]` attributes via Reflection.

### `ApiException`

**Namespace:** `Alxarafe\Service\ApiException`  
**Source:** [ApiException.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Service/ApiException.php)

Custom exception for API errors with HTTP status code support.
