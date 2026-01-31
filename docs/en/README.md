# Alxarafe Microframework

**Alxarafe** is a modern PHP microframework (8.2+) designed for rapid web application and RESTful API development. It focuses on simplicity, modularity, and convention over configuration.

## Key Features

*   **Modular Architecture:** Code is organized into Modules (Core and User) encapsulating business logic.
*   **API First:** Native support for REST APIs with integrated JWT authentication.
*   **Automatic Routing:** Intelligent routing system maps URLs to Controllers based on naming conventions, eliminating the need for manual route files.
*   **Flexible Database:** Lightweight database abstraction layer with support for automatic migrations and seeders.
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
│   └── Modules/         # Application Modules
│       └── MyModule/
│           ├── Controller/
│           ├── Model/
│           ├── Api/
└── vendor/              # Dependencies (including Alxarafe)
```

## Getting Started

### 1. Configuration (`config.json`)
Create a `config.json` file in your project root. This file defines database connection, routes, and security keys.

### 2. Create a Module
Create a folder in `src/Modules/` (e.g., `src/Modules/HelloWorld`).
Inside, create `Controller/HelloWorldController.php`.

### 3. Automatic Routes
Alxarafe will automatically detect your controller.
If your module is `HelloWorld` and your controller is `GreetingController`, the route could be something like:
`/HelloWorld/Greeting

## Development and Contribution

If you want to contribute to the framework development or test changes locally without publishing to Packagist, refer to the [Contribution Guide](CONTRIBUTING.md).

The repository includes a ready-to-use `skeleton` application as a development environment.`

## Additional Documentation

*   [Architecture and Core Concepts](ARCHITECTURE.md)
*   [Module Guide](MODULES.md) (Pending)
*   [API Reference](API.md) (Pending)
