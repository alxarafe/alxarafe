# Contribution and Development Guide

This guide details how to set up the **Alxarafe** development environment using Docker and PHP 8.5.1.

## Development Architecture (Monorepo)

To allow real-time testing of the framework, we use a "Skeleton" application located in the `skeleton/` folder. This app is linked to the framework's core (`src/`) via Composer's local path feature.

### Structure
* `src/`: Framework source code (core logic).
* `skeleton/`: Demo application for testing changes.
* `docker/`: Infrastructure and automation scripts.

## Initial Setup with Docker

1.  **Start the environment:**
    From the project root, run the startup script:
    ```bash
    ./docker/clean_start.sh
    ```

2.  **Install Framework & Skeleton dependencies:**
    Access the PHP 8.5 container:
    ```bash
    docker exec -it alxarafe_php bash
    ```
    Inside the container, navigate to the skeleton and install:
    ```bash
    cd skeleton
    composer install
    ```

3.  **Symlink Verification:**
    Check that `skeleton/vendor/alxarafe/alxarafe` points to your local `src/` directory.

## Testing the Framework

Instead of the built-in PHP server, we use the optimized Nginx container.

* **URL:** [http://localhost:8081](http://localhost:8081)
* **Database:** Access via `alxarafe_db:3399`

## Development Workflow

1.  **Modify Core:** Edit files in `src/` (e.g., `src/Core/Base/Controller.php`).
2.  **Instant Feedback:** Since `src/` is mounted as a Docker volume and symlinked via Composer, your changes are reflected immediately at `localhost:8081`.
3.  **Run Tests:**
    Execute tests from within the container to ensure PHP 8.5 compatibility:
    ```bash
    ./vendor/bin/phpunit
    ```

## Coding Standards
* **PHP Version:** >= 8.5.1.
* **Strict Typing:** All new files must include `declare(strict_types=1);`.
* **Documentation:** Update the [Docker README](../docker/README.md) if you modify the infrastructure.
