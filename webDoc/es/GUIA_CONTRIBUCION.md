# Guía de Contribución y Desarrollo

Esta guía detalla cómo configurar un entorno de desarrollo local para trabajar en el framework **Alxarafe**

## Entorno de Desarrollo (Monorepo)

Para facilitar el desarrollo y las pruebas sin necesidad de publicar paquetes en Packagist, el repositorio incluye una aplicación de demostración en la carpeta `skeleton/`.

Esta aplicación está configurada para utilizar el código fuente del framework (`src/`) directamente desde el disco local, gracias a la funcionalidad de repositorios tipo `path` de Composer.

### Estructura

*   `src/`: Código fuente del framework (lo que estás editando).
*   `skeleton/`: Aplicación de demostración para probar tus cambios.
    *   `skeleton/Modules/`: Módulos de la aplicación de prueba.
    *   `skeleton/public/`: Punto de entrada web.

## Configuración Inicial

1.  Abre una terminal y dirígete a la carpeta `skeleton`:
    ```bash
    cd skeleton
    ```

2.  Instala las dependencias (esto enlazará el framework local):
    ```bash
    composer install
    ```

3.  Verifica que se ha creado el enlace simbólico. En `skeleton/vendor/alxarafe/alxarafe` deberías ver un enlace simbólico apuntando a la raíz del repositorio.

## Ejecución del Servidor de Pruebas

Para levantar la aplicación de demostración, puedes utilizar el servidor web integrado de PHP:

```bash
# Desde la carpeta skeleton/
php -S localhost:8080 -t public
```

Ahora abre tu navegador en [http://localhost:8080](http://localhost:8080).
Deberías ver la página de bienvenida del módulo `Demo` servida por **Alxarafe**.

## Flujo de Trabajo

1.  Realiza cambios en los archivos del framework en `src/` (ej. `src/Core/Base/Controller.php`).
2.  Refresca el navegador en `localhost:8080`.
3.  ¡Los cambios se reflejan instantáneamente! No es necesario hacer `composer update`.

### Añadir nuevos módulos de prueba

Si necesitas probar una funcionalidad específica, puedes añadir controladores y vistas en `skeleton/Modules/Demo/`.

## Próximos Pasos

*   [Containerización con Docker](../docker/README.md) (Pendiente)
