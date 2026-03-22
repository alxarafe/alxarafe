# Alxarafe Microframework – Technical Reference

**Alxarafe** is a PHP 8.2+ microframework engineered for rapid development of modular web applications and RESTful APIs. It provides a thin, opinionated layer over industry-standard components (Illuminate ORM, Blade templating, Symfony Translation) while strictly following the **Convention over Configuration** philosophy.

## Design Principles

| Principle | Description |
|---|---|
| **Convention over Configuration** | Controllers, models, migrations and templates are discovered automatically by scanning PSR-4 namespaces. No route files to maintain. |
| **Modular by Default** | Every feature ships as a Module (`CoreModules\` or `Modules\`), each containing its own Controllers, Models, Migrations, Seeders, and Templates. |
| **Leverage, Don't Reinvent** | Database layer = Illuminate/Eloquent. Templates = Blade. Translations = Symfony/Translation. Authentication = JWT (Firebase PHP-JWT). |
| **Attribute-Driven Metadata** | PHP 8 Attributes (`#[Menu]`, `#[ApiRoute]`, `#[RequireRole]`, `#[ModuleInfo]`) declaratively define routing, permissions, and module metadata. |
| **Component Architecture** | UI forms are assembled programmatically from Field, Container, and Filter components — not hard-coded HTML. |

## System Requirements

- PHP ≥ 8.2
- Composer
- Required extensions: `ext-pdo`, `ext-json`, `ext-openssl`
- Database: MySQL 5.7+ / MariaDB 10.3+ or PostgreSQL 12+

## Quick Start

### New Project (Recommended)

```bash
composer create-project alxarafe/alxarafe-template my-app
cd my-app
cp .env.example .env
# Edit .env with your database credentials
php bin/run_migrations.sh
```

### Add to Existing Project

```bash
composer require alxarafe/alxarafe
```

Then create the expected directory structure (see [Architecture](architecture.md)).

### Docker Development

```bash
cp .env.example .env
./bin/docker_start.sh
./bin/run_migrations.sh
# Access at http://localhost:8081
```

## Project Structure

```text
my-project/
├── config/
│   └── config.json          # Global configuration (DB, security, language)
├── public/                  # Web server Document Root
│   ├── index.php            # Entry point → Dispatcher::run()
│   └── .htaccess            # URL rewrite rules
├── Modules/                 # Application modules (Modules\ namespace)
│   └── MyModule/
│       ├── Controller/      # *Controller.php → Web routes
│       ├── Model/           # Eloquent models
│       ├── Api/             # *Controller.php → API routes
│       ├── Migrations/      # Database migrations
│       ├── Seeders/         # Data seeders
│       └── Templates/       # Blade views
├── templates/               # Shared Blade templates & layouts
├── themes/                  # Theme overrides
└── vendor/                  # Dependencies (includes alxarafe/alxarafe)
    └── alxarafe/alxarafe/
        └── src/
            ├── Core/        # Framework kernel (Alxarafe\ namespace)
            └── Modules/     # Core modules (CoreModules\ namespace)
```

## Documentation Index

### Fundamentals

| Document | Description |
|---|---|
| [Architecture & Directory Structure](architecture.md) | PSR-4 namespaces, directory responsibilities, dependency graph |
| [Request Lifecycle](lifecycle.md) | Complete flow from `index.php` to HTTP response |

### API Reference

| Document | Description |
|---|---|
| [Attributes](classes/core/attribute/index.md) | `#[ApiRoute]`, `#[Menu]`, `#[ModuleInfo]`, `#[RequireModule]`, `#[RequirePermission]`, `#[RequireRole]` |
| [Controllers](classes/core/base/controller/index.md) | `GenericController` → `ViewController` → `Controller` → `ResourceController` hierarchy |
| [Models & Traits](classes/core/base/model/index.md) | `Model`, `DtoTrait`, `HasAuditLog` |
| [Config & Database](classes/core/base/index.md) | `Config`, `Database`, `Seeder`, `Template`, `BladeContainer` |
| [Component Fields](classes/core/component/fields/index.md) | 15 field types for form generation |
| [Component Containers](classes/core/component/container/index.md) | `Panel`, `Tab`, `TabGroup`, `Row`, `Separator`, `HtmlContent` |
| [Component Filters](classes/core/component/filter/index.md) | `TextFilter`, `SelectFilter`, `DateRangeFilter`, etc. |
| [Component Workflow](classes/core/component/workflow/index.md) | `StatusWorkflow`, `StatusTransition` |
| [Lib Layer](classes/core/lib/index.md) | `Auth`, `Functions`, `Messages`, `Router`, `Routes`, `Trans` |
| [Service Layer](classes/core/service/index.md) | `HookService`, `EmailService`, `PdfService`, API services, Markdown |
| [Tools Layer](classes/core/tools/index.md) | `Dispatcher`, `Debug`, `ModuleManager`, `DependencyResolver` |

### Guides

| Document | Description |
|---|---|
| [Admin Module Reference](admin_module.md) | Bundled Admin module: auth, users, roles, permissions, config, migrations |
| [Advanced Usage](advanced_usage.md) | Creating modules, hooks, custom fields, themes, JWT, i18n |
| [Template Engine](template_engine.md) | Blade integration and template discovery |
| [Template Schema](template_schema.md) | Component-based view structure |
| [Extensible Tabs](extensible_tabs.md) | Conditional and dynamic tab system |
| [Theme Architecture](frontend/theme_architecture.md) | Asset pipeline and theme overrides |
| [Theme System](frontend/theme_system.md) | Theme installation and customization |
| [Menu Manager](menu_manager.md) | Attribute-driven menu system |
| [ResourceController Lifecycle](resource_controller_lifecycle.md) | CRUD lifecycle in detail |
| [API Development](api_development.md) | REST APIs with JWT authentication |
| [Testing Guide](testing.md) | PHPUnit, PHPStan, Psalm configuration |
| [Docker Setup](docker.md) | Docker development environment |
| [Publishing Guide](publishing_guide.md) | Versioning and Packagist publishing |
| [Contribution Guide](contribution_guide.md) | How to contribute |

## License

Alxarafe is released under the **GNU General Public License v3.0+** (GPL-3.0-or-later).
