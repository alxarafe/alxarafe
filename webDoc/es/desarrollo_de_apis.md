# Desarrollo de APIs en Alxarafe

Alxarafe facilita la creación de APIs RESTful mediante controladores dedicados y un despachador inteligente. Este documento explica cómo implementar, documentar y probar endpoints de API.

## 1. Estructura de un Controlador de API

Los controladores de API deben:
1.  Estar ubicados en la carpeta `Api/` de tu módulo (ej. `Modules/Mimodulo/Api/`).
2.  Extender de `Alxarafe\Base\Controller\ApiController`.
3.  Tener el sufijo `ApiController` (recomendado para diferenciar de controladores web, aunque el despachador lo gestiona).

### Ejemplo: `PersonApiController` (Skeleton)

Ubicación: `skeleton/Modules/Agenda/Api/PersonApiController.php`

```php
<?php

namespace Modules\Agenda\Api;

use Alxarafe\Base\Controller\ApiController;
use Modules\Agenda\Model\Person;

/**
 * Class PersonApiController.
 *
 * API Endpoint for managing Person resources.
 *
 * @package Modules\Agenda\Api
 */
class PersonApiController extends ApiController
{
    /**
     * Retrieve a Person by ID.
     *
     * @param int $id The unique identifier of the person.
     * @return never Outputs JSON response and terminates execution.
     */
    public function get(int $id)
    {
        $person = Person::find($id);

        if (!$person) {
            self::badApiCall('Person not found', 404);
        }

        self::jsonResponse($person->toArray());
    }
}
```

### Ejemplo: `UserApiController` (Core)

Ubicación: `src/Modules/Admin/Api/UserApiController.php`

```php
<?php

namespace CoreModules\Admin\Api;

use Alxarafe\Base\Controller\ApiController;
use CoreModules\Admin\Model\User;

class UserApiController extends ApiController
{
    public function get(int $id)
    {
        $user = User::find($id);
        if (!$user) {
            self::badApiCall('User not found', 404);
        }
        self::jsonResponse($user->toArray());
    }
}
```

## 2. Enrutamiento (Dispatching)

El `ApiDispatcher` de Alxarafe resuelve automáticamente las rutas basándose en la estructura del módulo y el método del controlador.

Patrón de ruta:
`/api/{Modulo}/{Controlador}/{Metodo}/{Parametro1}/{Parametro2}...`

### Ejemplos de Llamada
*   **Obtener Persona ID 1**:
    `GET /api/Agenda/PersonApi/get/1`
    *   Módulo: `Agenda`
    *   Controlador: `PersonApi` (busca `PersonApiController.php`)
    *   Método: `get`
    *   Parámetro: `1`

*   **Obtener Usuario ID 5**:
    `GET /api/Admin/UserApi/get/5`

> **Nota**: El despachador automáticamente instancia el controlador y llama al método indicado, pasando los parámetros adicionales como argumentos.

## 3. Documentación con phpDocumentor

Es obligatorio documentar las clases y métodos de la API utilizando bloques PHPDoc estándar. Esto permite generar documentación automática y mantener el código inteligible.

### Etiquetas Comunes
*   `@package`: Define el paquete/módulo.
*   `@param`: Describe los parámetros del método.
*   `@return`: Describe el valor de retorno (o `never` si termina la ejecución).
*   `@api`: Marca el elemento como parte de la API pública.

### Generación de Documentación
Para generar la documentación HTML de la API, se utiliza `phpDocumentor`.

**Comando (desde Docker):**
```bash
docker exec alxarafe_php php phpdoc.phar -d skeleton/Modules/Agenda/Api -d src/Modules/Admin/Api -t webDoc/api --force
```

Esto generará un sitio estático en `webDoc/api/` con la referencia completa de clases, métodos y descripciones.

## 4. Testing Manual de la API

Dado que los endpoints son accesibles vía HTTP, puedes probarlos fácilmente con herramientas como `curl` o Postman.

**Ejemplo con curl:**
```bash
curl -X GET http://localhost:8000/api/Agenda/PersonApi/get/1
```

Respuesta esperada (JSON):
```json
{
    "ok": true,
    "status": 200,
    "result": {
        "id": 1,
        "name": "Juan",
        "lastname": "Pérez",
        ...
    }
}
```
