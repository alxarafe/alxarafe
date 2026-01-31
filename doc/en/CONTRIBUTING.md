# Contribution and Development Guide

This guide details how to set up a local development environment for working on the **Alxarafe** framework.

## Development Environment (Monorepo)

To facilitate development and testing without publishing packages to Packagist, the repository includes a demo application in the `skeleton/` folder.

This application is configured to use the framework source code (`src/`) directly from the local disk, thanks to Composer's `path` repository feature.

### Structure

*   `src/`: Framework source code (what you are editing).
*   `skeleton/`: Demo application for testing your changes.
    *   `skeleton/Modules/`: Test application modules.
    *   `skeleton/public/`: Web entry point.

## Initial Setup

1.  Open a terminal and navigate to the `skeleton` folder:
    ```bash
    cd skeleton
    ```

2.  Install dependencies (this will link the local framework):
    ```bash
    composer install
    ```

3.  Verify that the symbolic link has been created. In `skeleton/vendor/alxarafe/alxarafe` you should see a symlink pointing to the repository root.

## Running the Test Server

To start the demo application, you can use PHP's built-in web server:

```bash
# From the skeleton/ folder
php -S localhost:8080 -t public
```

Now open your browser at [http://localhost:8080](http://localhost:8080).
You should see the welcome page of the `Demo` module served by **Alxarafe**.

## Workflow

1.  Make changes to framework source files in `src/` (e.g. `src/Core/Base/Controller.php`).
2.  Refresh the browser on `localhost:8080`.
3.  Changes are reflected instantly! No `composer update` needed.

### Adding New Test Modules

If you need to test specific functionality, you can add controllers and views in `skeleton/Modules/Demo/`.

## Next Steps

*   [Docker Containerization](../docker/README.md) (Pending)
