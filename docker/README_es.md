# Información básica sobre Docker

## Creación de los contenedores

En la carpeta bin existen 3 scripts para la eliminación, creación y arranque de los contenedores necesarios.

Una vez creados, igual es necesario ejecutar el composer.

### Acceso al contenedor

Ejecutando el siguiente comando, se accede al contenedor en el que se encuentra el código.

<code>docker exec -it alxarafe_php bash</code>

Desde ahí se puede ejecutar.

<code>composer install</code>

<code>npm install && gulp build</code>

## Ejecución de mysql

### Para ejecutar mysql con el usuario dbuser (contraseña dbuser)

mysql -h alxarafe_db -P 3306 -u dbuser -p

### Cambiar la base de datos

Se puede eliminar la base de datos existente:

<code>drop database alxarafe;</code>

<code>create database alxarafe;</code>

<code>use alxarafe;</code>

La base de datos a importar se copia a la carpeta tmp y así queda disponible en el contenedor. Si por ejemplo es alxarafe_db.sql

<code>source tmp/alxarafe_db.sql;</code>

---
*Versión en inglés disponible en [README.md](./README.md)*
