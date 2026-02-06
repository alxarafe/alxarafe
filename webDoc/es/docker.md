# Manual de Uso de Docker en Alxarafe

Este documento detalla cómo utilizar el entorno de desarrollo basado en Docker para Alxarafe.

## 1. Requisitos Previos

*   **Docker** instalado en el sistema.
*   **Docker Compose** (normalmente incluido en Docker Desktop o como plugin en Linux).
*   Permisos suficientes para ejecutar comandos de Docker (o uso de `sudo` si es necesario).

## 2. Configuración del Entorno (`.env`)

El proyecto incluye un archivo llamado `.env.example` en la raíz, el cual ya está preconfigurado para funcionar con el entorno Docker de Alxarafe.

Para comenzar, simplemente copia este archivo como `.env`:

```bash
cp .env.example .env
```

Si es necesario, puedes adaptar los parámetros clave dentro de este archivo, tales como:

*   **HTTP_PORT**: Puerto para acceder a la aplicación web (por defecto `8081`).
*   **MARIADB_PORT**: Puerto expuesto de la base de datos (por defecto `3399`).
*   **PHPMYADMIN_PORT**: Puerto para phpMyAdmin (por defecto `9081`).
*   **MARIADB_ROOT_PASSWORD**: Contraseña del usuario root de la base de datos.
*   **USER_ID / GROUP_ID**: Identificadores de usuario de Linux para asegurar que los permisos de archivos en el contenedor coincidan con el host.

## 3. Servicios Incluidos

El entorno levanta los siguientes contenedores:

1.  **alxarafe_nginx**: Servidor web Alpine configurado para servir el proyecto.
2.  **alxarafe_php**: Intérprete PHP 8.3 con las extensiones necesarias y Xdebug configurado.
3.  **alxarafe_db**: Base de datos MariaDB 10.11.
4.  **alxarafe_phpmyadmin**: Interfaz web para gestionar la base de datos.
5.  **alxarafe_node**: Contenedor para la gestión de dependencias frontend (npm) y compilación de activos.

## 4. Scripts de Utilidad (`bin/`)

Se han incluido varios scripts en la carpeta `bin/` para simplificar la gestión de los contenedores. **Deben ejecutarse desde la raíz del proyecto.**

### `bin/docker_start.sh`
Inicia todos los contenedores del proyecto en segundo plano.

### `bin/run_migrations.sh`
Ejecuta las migraciones y seeders de la base de datos dentro del contenedor PHP. Es necesario ejecutarlo la primera vez para crear las tablas y usuarios por defecto.

### `bin/docker_stop.sh`
Detiene de forma segura todos los contenedores de Alxarafe sin borrarlos.

### `bin/docker_stop_and_remove.sh`
Detiene y elimina los contenedores. Útil para aplicar cambios estructurales en el `docker-compose.yml`.

### `bin/docker_clean_start.sh`
Realiza una limpieza profunda y reinicio:
1.  Borra `node_modules`, `vendor`, `composer.lock` y `package-lock.json`.
2.  Detiene y elimina los contenedores actuales.
3.  Ejecuta un `docker system prune` para liberar espacio.
4.  Reconstruye y levanta los contenedores desde cero.
5.  Abre automáticamente la aplicación en el navegador predeterminado.

## 5. Acceso a los Servicios

*   **Aplicación Web**: [http://localhost:8081](http://localhost:8081) (o el puerto definido en `HTTP_PORT`).
*   **phpMyAdmin**: [http://localhost:9081](http://localhost:9081)
    *   **Servidor**: `alxarafe_db`
    *   **Usuario/Pass**: Los definidos en el archivo `.env`.

## 6. Comandos Útiles de Docker

Si prefieres usar los comandos estándar:

*   **Levantar**: `docker compose up -d`
*   **Ver logs**: `docker compose logs -f`
*   **Entrar al terminal PHP**: `docker exec -it alxarafe_php sh`
*   **Ver estado**: `docker ps`
