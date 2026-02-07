# Alxarafe Microframework

**Alxarafe** is a modern PHP microframework (8.2+) designed for rapid development of web applications and RESTful APIs. It focuses on simplicity, modularity, and convention over configuration.

## Key Features

*   **Modular Architecture:** Code is organized into Modules (Core and User) that encapsulate business logic.
*   **API First:** Native support for REST APIs with integrated JWT authentication.
*   **Automatic Routing:** Intelligent routing system that maps URLs to Controllers based on naming conventions, without the need to define manual route files.
*   **Flexible Database:** Lightweight database abstraction layer with support for migrations and automatic seeders.
*   **Centralized Configuration:** A single `config.json` file manages the entire environment.
*   **Internationalization (i18n):** Native support for multiple languages.

## Installation

Alxarafe is distributed as a Composer library. To use it in your project:

1.  Add the dependency to your `composer.json`:

```bash
composer require alxarafe/alxarafe
```

2.  Ensure you have the directory structure expected by the framework (see Architecture section).

## System Requirements

*   PHP >= 8.2
*   Composer
*   PHP Extensions: `ext-pdo`, `ext-json`, `openssl`

## Alxarafe Project Structure

A typical project using Alxarafe follows this structure:

```text
my-project/
├── config.json          # Global configuration
├── public/              # Web server Document Root
│   ├── index.php        # Entry point
│   └── .htaccess        # Rewrite rules
├── src/
│   └── Modules/         # Your application Modules
│       └── MyModule/
│           ├── Controller/
│           ├── Model/
│           └── Api/
└── vendor/              # Dependencies (including Alxarafe)
```

## Getting Started

### 1. Configuration (`config.json`)
Create a `config.json` file in the root of your project. This file defines the database connection, routes, and security keys.

### 2. Create a Module
Create a folder in `src/Modules/` (e.g. `src/Modules/HelloWorld`).
Inside, create `Controller/HelloWorldController.php`.

### 3. Automatic Routes
Alxarafe will automatically detect your controller.
If your module is `HelloWorld` and your controller `GreetingController`, the route could be something like:
`/HelloWorld/Greeting`

## Development and Contribution

If you wish to contribute to the development of the framework or test changes locally without publishing to Packagist, check the [Contribution Guide](contribution_guide.md).

The repository includes a `skeleton` application ready to use as a development environment.

## Additional Documentation

*   [Architecture and Core Concepts](architecture.md)
*   [Publishing and Versioning Guide](publishing_guide.md)
*   [Contribution Guide](contribution_guide.md)
*   [Testing Guide](testing.md)
*   [Module Guide](MODULOS.md) (Pending)
*   [API Reference](API.md) (Pending)
