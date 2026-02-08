# Guía de Testing en Alxarafe

## Introducción

Las pruebas automatizadas son un pilar fundamental en el desarrollo con Alxarafe. No solo garantizan que el código funcione como se espera, sino que actúan como red de seguridad permitiendo refactorizaciones agresivas y documentación viva del comportamiento del sistema.

Alxarafe incluye una configuración robusta de **PHPUnit** integrada con Docker, diseñada para facilitar tanto pruebas unitarias (modelos, lógica pura) como pruebas de características (controladores, API).

---

## Entorno de Pruebas

### Infraestructura

El entorno de pruebas está contenerizado y se apoya en los siguientes pilares:

1.  **Contenedor Docker (`alxarafe_php`)**: Todos los tests se ejecutan dentro del contenedor PHP para garantizar consistencia con el entorno de producción (mismas extensiones, versión de PHP 8.5+).
2.  **Base de Datos Aislada (`alxarafe_test`)**:
    *   Al iniciar los tests, el sistema conecta automáticamente a una base de datos dedicada llamada `alxarafe_test`.
    *   Esta base de datos se crea y migra automáticamente si no existe.
    *   **Importante:** Nunca se ejecutan tests contra la base de datos de desarrollo o producción.
3.  **Transacciones de Base de Datos**:
    *   Cada test se envuelve automáticamente en una **transacción de base de datos** (`beginTransaction` en `setUp`).
    *   Al finalizar el test, la transacción se revierte (`rollBack` en `tearDown`).
    *   Esto garantiza que **ningún dato persista** después de la ejecución de un test, manteniendo el entorno limpio para el siguiente.

### Bootstrapping

El archivo `Tests/bootstrap.php` (y su clase `Tests\Bootstrapper`) se encarga de:
*   Definir la constante `ALX_TESTING`.
*   Cargar las configuraciones del entorno.
*   Inicializar la conexión a la base de datos de pruebas.
*   Ejecutar las migraciones necesarias.

---

## Estructura de Directorios

El proyecto distingue entre tests del "núcleo" (framework) y tests de la "aplicación" (skeleton).

*   **`Tests/`**: Contiene la infraestructura base de testing y los tests unitarios del propio framework Alxarafe (`src/Core`).
    *   `Tests/TestCase.php`: Clase base de la que deben heredar todos los tests.
    *   `Tests/Unit/`: Tests unitarios del núcleo.
    *   `Tests/Feature/`: Tests de integración del núcleo.
*   **`skeleton/Tests/`**: Contiene los tests específicos de la aplicación de ejemplo o proyecto final.
    *   `skeleton/Tests/Unit/`: Tests de tus Modelos y Clases.
    *   `skeleton/Tests/Feature/`: Tests de tus Controladores y APIs.

---

## Creación de Tests

Todos los tests deben heredar de `Tests\TestCase`. Esta clase base proporciona las utilidades de transacción y aserciones personalizadas.

### 1. Tests de Modelos (Unit)

Los tests unitarios de modelos verifican que la lógica de negocio y la persistencia funcionen correctamente.

**Ejemplo: `skeleton/Tests/Unit/PersonTest.php`**

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Agenda\Model\Person;

class PersonTest extends TestCase
{
    /**
     * Verifica que se puede crear una persona y se guarda en BD.
     */
    public function testItCanCreateAPerson()
    {
        // 1. Ejecución
        $person = Person::create([
            'name' => 'John',
            'lastname' => 'Doe',
            'birth_date' => '1990-01-01',
            'active' => true
        ]);

        // 2. Aserciones
        $this->assertNotNull($person->id, 'El ID no debería ser nulo tras crear');
        $this->assertEquals('John', $person->name);
        $this->assertTrue($person->active);

        // 3. Verificación en Base de Datos
        // (Nota: Esto verifica dentro de la transacción actual)
        $this->assertDatabaseHas('people', [
            'id' => $person->id,
            'name' => 'John'
        ]);
    }
}
```

### 2. Tests de API y Controladores (Feature)

Para detalles sobre la implementación y documentación de APIs, consulta la [Guía de Desarrollo de APIs](desarrollo_de_apis.md).

Probar controladores en Alxarafe tiene particularidades debido a que el framework maneja respuestas HTTP y redirecciones.

#### Manejo de Respuestas (`HttpResponseException`)
En el entorno de test (`ALX_TESTING`), funciones como `httpRedirect` o `jsonResponse` **no terminan la ejecución** (`die()`). En su lugar, lanzan una excepción `Alxarafe\Base\Testing\HttpResponseException`.
Esto permite capturar la respuesta y hacer aserciones sobre ella.

#### Simulación de Autenticación
Para probar controladores protegidos sin pasar por el proceso de login completo, puedes definir `ALX_TEST_USER` antes de instanciar el controlador.

**Ejemplo: `skeleton/Tests/Feature/PersonControllerTest.php`**

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Modules\Agenda\Controller\PersonController;
use Alxarafe\Base\Testing\HttpResponseException;

class PersonControllerTest extends TestCase
{
    /**
     * Prueba de fallo esperado: Validación.
     */
    public function testItReturnsValidationErrorOnEmptySave()
    {
        // 1. Preparar Entorno
        $_POST = ['action' => 'save', 'data' => []]; // Datos vacíos para provocar error
        
        // Simular usuario autenticado (si es necesario)
        if (!defined('ALX_TEST_USER')) define('ALX_TEST_USER', 'Tester');

        $controller = new PersonController();

        try {
            // 2. Ejecutar Método Protegido via Reflection
            // (Necesario porque saveRecord es protected en ResourceController)
            $reflection = new \ReflectionClass($controller);
            
            // Inicializar configuración interna del controlador
            $configMethod = $reflection->getMethod('buildConfiguration');
            $configMethod->setAccessible(true);
            $configMethod->invoke($controller);

            // Invocar guardar
            $method = $reflection->getMethod('saveRecord');
            $method->setAccessible(true);
            $method->invoke($controller);

            // Si no lanza excepción, el test falla
            $this->fail("Se esperaba HttpResponseException debido a validación");
        } catch (HttpResponseException $e) {
            // 3. Verificar Respuesta de Error
            $response = $e->getResponse();
            $this->assertArrayHasKey('error', $response);
            $this->assertEquals('No data provided', $response['error']);
        }
    }

    /**
     * Prueba de éxito: Guardado correcto.
     */
    public function testItCanSaveAPersonViaController()
    {
        // 1. Datos válidos
        $_POST = ['data' => [
            'name' => 'Jane',
            'lastname' => 'Smith',
            'active' => 1,
            'birth_date' => '1995-05-05'
        ]];

        $controller = new PersonController();
        $controller->recordId = 'new'; // Simular creación

        try {
            // ... (Reflection setup similar al anterior) ...
            $reflection = new \ReflectionClass($controller);
            $configMethod = $reflection->getMethod('buildConfiguration');
            $configMethod->setAccessible(true);
            $configMethod->invoke($controller);

            $method = $reflection->getMethod('saveRecord');
            $method->setAccessible(true);
            $method->invoke($controller);

            $this->fail("Se esperaba respuesta JSON de éxito");
        } catch (HttpResponseException $e) {
            // 2. Verificar Respuesta de Éxito
            $response = $e->getResponse();
            
            $this->assertArrayHasKey('status', $response);
            $this->assertEquals('success', $response['status']);
            $this->assertArrayHasKey('id', $response);

            // 3. Verificar Persistencia en BD
            $this->assertDatabaseHas('people', [
                'id' => $response['id'],
                'name' => 'Jane'
            ]);
        }
    }
}
```

---

## Ejecución de Tests

Los tests deben ejecutarse **siempre** desde el contenedor Docker para asegurar que el entorno (PHP, extensiones, base de datos) sea el correcto.

### Comandos Principales

Ejecutar todos los tests (Unit y Feature):
```bash
docker exec alxarafe_php ./vendor/bin/phpunit
```

Ejecutar solo una suite específica:
```bash
docker exec alxarafe_php ./vendor/bin/phpunit --testsuite Unit
docker exec alxarafe_php ./vendor/bin/phpunit --testsuite Feature
```

Ejecutar un archivo de test específico:
```bash
docker exec alxarafe_php ./vendor/bin/phpunit skeleton/Tests/Unit/PersonTest.php
```

### Verificación de Estilo (PSR-12)

Es crítico mantener el estilo de código en los tests. Alxarafe impone **PSR-12**.
El nombre de los métodos de test debe ser `camelCase` (ej. `testItDoSomething`), **no** `snake_case`.

Para verificar el estilo:
```bash
docker exec alxarafe_php ./vendor/bin/phpcs --standard=PSR12 Tests/ skeleton/Tests/
```

Si hay errores corregibles automáticamente:
```bash
docker exec alxarafe_php ./vendor/bin/phpcbf --standard=PSR12 Tests/ skeleton/Tests/
```
