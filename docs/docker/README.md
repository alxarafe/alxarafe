# Entorno Docker para Alxarafe

Alxarafe incluye una configuración Docker completa para desarrollo local.

## Prerrequisitos
*   Docker
*   Docker Compose

## Inicio Rápido

1.  Ejecuta desde la raíz del proyecto:
    ```bash
    docker-compose up -d --build
    ```

2.  Accede a la aplicación:
    *   **App Demo:** http://localhost:8081
    *   **PhpMyAdmin:** http://localhost:8082
    *   **Base de Datos:** Puerto 3388 (usuario: `root`, pass: `root`)

## Estructura

*   **Nginx:** Sirve la aplicación desde `skeleton/public`.
*   **PHP-FPM:** Ejecuta el código montando el volumen local (`.`).
*   **MariaDB:** Base de datos persistente.

## Comandos Útiles

*   **Entrar al contenedor PHP:**
    ```bash
    docker-compose exec php bash
    ```
    Desde aquí puedes ejecutar comandos de Composer o PHP CLI.
