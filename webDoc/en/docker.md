# Docker Usage Manual in Alxarafe

This document details how to use the Docker-based development environment for Alxarafe.

## 1. Prerequisites

*   **Docker** installed on the system.
*   **Docker Compose** (usually included in Docker Desktop or as a plugin on Linux).
*   Sufficient permissions to run Docker commands (or use of `sudo` if necessary).

## 2. Environment Configuration (`.env`)

The project includes a file named `.env.example` in the root, which is already preconfigured to work with the Alxarafe Docker environment.

To start, simply copy this file as `.env`:

```bash
cp .env.example .env
```

If necessary, you can adapt the key parameters within this file, such as:

*   **HTTP_PORT**: Port to access the web application (default `8081`).
*   **MARIADB_PORT**: Exposed database port (default `3399`).
*   **PHPMYADMIN_PORT**: Port for phpMyAdmin (default `9081`).
*   **MARIADB_ROOT_PASSWORD**: Password for the database root user.
*   **USER_ID / GROUP_ID**: Linux user identifiers to ensure file permissions in the container match the host.

## 3. Included Services

The environment spins up the following containers:

1.  **alxarafe_nginx**: Alpine web server configured to serve the project.
2.  **alxarafe_php**: PHP 8.3 interpreter with necessary extensions and Xdebug configured.
3.  **alxarafe_db**: MariaDB 10.11 database.
4.  **alxarafe_phpmyadmin**: Web interface to manage the database.
5.  **alxarafe_node**: Container for frontend dependency management (npm) and asset compilation.

## 4. Utility Scripts (`bin/`)

Several scripts have been included in the `bin/` folder to simplify container management. **These must be run from the project root.**

### `bin/docker_start.sh`
Starts all project containers in the background.

### `bin/run_migrations.sh`
Runs the database migrations and seeders inside the PHP container. It is necessary to run this the first time to create default tables and users.

### `bin/docker_stop.sh`
Safely stops all Alxarafe containers without deleting them.

### `bin/docker_stop_and_remove.sh`
Stops and removes the containers. Useful for applying structural changes in `docker-compose.yml`.

### `bin/docker_clean_start.sh`
Performs a deep clean and restart:
1.  Deletes `node_modules`, `vendor`, `composer.lock`, and `package-lock.json`.
2.  Stops and removes current containers.
3.  Runs `docker system prune` to free up space.
4.  Rebuilds and brings up containers from scratch.
5.  Automatically opens the application in the default browser.

## 5. Accessing Services

*   **Web Application**: [http://localhost:8081](http://localhost:8081) (or the port defined in `HTTP_PORT`).
*   **phpMyAdmin**: [http://localhost:9081](http://localhost:9081)
    *   **Server**: `alxarafe_db`
    *   **User/Pass**: Those defined in the `.env` file.

## 6. Useful Docker Commands

If you prefer to use standard commands:

*   **Start**: `docker compose up -d`
*   **View logs**: `docker compose logs -f`
*   **Enter PHP terminal**: `docker exec -it alxarafe_php sh`
*   **Check status**: `docker ps`
