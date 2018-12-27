Alxarafe. Development of PHP applications in a flash!

Alxarafe es un paquete, aún en desarrollo, que entre otras, ofrece las siguientes funcionalidades:
- Identificación de usuarios.
- Conexión con bases de datos PDO.
- Gestión de tablas.
- Ayudas a la depuración y el desarrollo de la aplicación (Log, barra de depuración, etc).
- Gestor de plantillas y skins usando Twig.

Su modularidad, le permite cambiar fácilmente las herramientas que utiliza para proporcionar
dichas funcionalidades.

Puede encontrar Alxarafe en los siguientes repositorios:
https://github.com/alxarafe/alxarafe
https://packagist.org/packages/alxarafe/alxarafe

¿Cómo integrar Alxarafe en mi aplicación?
-----------------------------------------

Para integrarlo en su aplicación necesitará instalar composer y ejecutar el siguiente comando:

composer require alxarafe/alxarafe

Luego, en el fichero de inicio de su aplicación deberá de incluir el siguiente código:

<?php
// We save the application's start folder
define('BASE_PATH', __DIR__);
// We start the composer packages
require_once BASE_PATH . '/vendor/autoload.php';
// We indicate that we are going to use the Dispatcher tool
use Alxarafe\Helpers\Dispatcher;
// And run it!
(new Dispatcher())->run();

Si desea personalizar las funcionalidades de inicio, podrá sobreescribir la clase Dispatcher,
o activarle algunos parámetros de configuración.

Funcionalidades básicas de Dispatcher
-------------------------------------

Al instanciar el Dispatcher (usando new Dispatcher()), se ejecuta el __construct que realiza
las siguientes tareas:

- Verifica la existencia del fichero de configuración de la base de datos, y si no existe,
nos muestra un formulario para su creación.
- Una vez que tenemos un fichero de base de datos, lo carga y establece la conexión con ella.
- Verifica si existe un usuario identificado, y si no, trata de identificarlo mediante un formulario.
- Determina por las variables GET si hay que cargar algún controlador y método y lo ejecuta.

Si desea personalizar alguna de estas funciones (por ejemplo, las carpetas de controladores, o el
nombre de las variables GET), puede usar las variables definidas para ello al instanciar la
clase Dispatcher, o bien, sobreescribirla y ejecutar en su lugar a su descendiente.

Si encuentra formas de mejorar el código, hágalo.
PULL REQUEST welcome!