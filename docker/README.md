# Información básica sobre Docker

## Creación de los contenedores

En la carpeta bin existen 3 scripts para la eliminación, creación y arranque de los contenedores necesarios.

Una vez creados, igual es necesario ejecutar el composer.

### Acceso al contenedor

Ejecutando el siguiente comando, se accede al contenedor en el que se encuentra el código.

<code>docker exec -it xnet_php bash</code>

Desde ahí se puede ejecutar.

<code>composer install</code>

<code>npm install && gulp build</code>

## Ejecución de mysql

### Para ejecutar mysql con el usuario dbuser (contraseña dbuser)

mysql -h xnet_db -P 3306 -u dbuser -p

### Cambiar la base de datos

Se puede eliminar la base de datos existente:

<code>drop database xnet;</code>

<code>create database xnet;</code>

<code>use xnet;</code>

La base de datos a importar se copia a la carpeta tmp y así queda disponible en el contenedor. Si por ejemplo es xnet_db.sql

<code>source tmp/xnet_db.sql;</code>
