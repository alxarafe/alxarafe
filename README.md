[![Scrutinizer logo](https://scrutinizer-ci.com/images/logo.png)](https://scrutinizer-ci.com/g/rsanjoseo/alxarafe/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rsanjoseo/alxarafe/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/rsanjoseo/alxarafe/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/rsanjoseo/alxarafe/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/rsanjoseo/alxarafe/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/alxarafe/alxarafe/badges/build.png?b=master)](https://scrutinizer-ci.com/g/rsanjoseo/alxarafe/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/alxarafe/alxarafe/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

# alxarafe

Alxarafe, se lee Aljarafe, es un proyecto de software libre que proporciona el soporte básico 
para mantener aplicaciones de base de datos, con un alto grado de automatización. Alxarafe
sigue el patrón de diseño MVC.

El principal objetivo es hacer que la aplicación sea robusta y sencilla de mantener, con una 
baja curva de aprendizaje.

Muchas de sus funcionalidades se podrán extender y ser utilizadas por aplicaciones más 
complejas y especialmente obsoletas en su diseño.

## Estructura de Alxarafe

La estructura de la aplicación es la siguiente:

- La carpeta **html** contiene las plantillas, inicialmente usando el motor *Twig*, aunque se podría cambiar por otro como *Blade con bastante facilidad. 
- La carpeta **Modules** contiene los módulos que amplían las funcionalidades de la aplicación. Cada módulo tendrá como mínimo las siguientes carpetas, aunque se pueden crear otras, como por ejemplo las existentes en en núcleo (como Helpers o Extensions). Las mismas carpetas existen en **src** para los archivos de los controladores, modelos y vistas del núcleo:
  - La carpeta **Controllers** contiene los controladores del módulo.
  - La carpeta **Languages** contiene archivos yaml con las traducciones a distintos idiomas. Se proporciona inglés (en) y español (es), pero se pueden añadir nuevos idiomas (por ejemplo fr para francés) o personalizar los existentes (por ejemplo es_ES para español de España).
  - La carpeta **Models** contiene los modelos (básicamente tablas y sus relaciones).
    - La carpeta **Structure** contiene la definición de las tablas en formato YAML.
    - La carpeta **Seed** contiene archivos csv con los datos iniciales de las tablas.
  - La carpeta **Views** contiene código personalizado para su ejecución desde las vistas. *Está por ver si esto es necesario, o si utilizar directamente código del controlador*.
- La carpeta **src** contiene en núcleo de *Alxarafe*:
  - La carpeta **Core** contiene el código principal del núcleo:
    - La carpeta **Base** contiene las clases abstractas de las que extienden los controladores, modelos y vistas de los distintos módulos.
    - La carpeta **Helpers** contiene clases de apoyo al núcleo. Son clases de uso directo con funcionalidades específicas.
    - La carpeta **Singletons** contiene clases, generalmente abstractas, que se instancian una única vez. *Inicialmente extendían una clase **Singleton** que se instanciaban una vez, y las siguientes veces que se instanciaba, retornaba la misma instancia, de ahí su nombre*.
    - La carpeta **Utils** contiene librerías de uso general.
  - La carpeta **Database** contiene código para la manipulación de la base de datos:
    - La carpeta **Engines** contiene código para personalizar cada uno de los motores de bases de datos soportados. Inicialmente, se proporciona la clase PdoMySql, para MySql. Para crear nuevos motores, basta con crear nueva clases como PdoMariaDB, PdoPosgreSql o PdoFirebird, por ejemplo.
    - La carpeta **SqlHelpers** contiene código para personalizar aspectos específicos del tratamiento SQL del motor. Deberían de existir los mismos que existan en *Engines*, pero cambiando Pdo por Sql. Se proporciona **SqlMySql**.
  - La carpeta **Extensions** contiene código que extiende nuevas funcionalidades de uso general, al núcleo.