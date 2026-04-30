# DbTrait

::: info
**Namespace:** `Alxarafe\Base\Controller\Trait`  
**Uso:** Inyectado en controladores que requieren acceso a datos.  
**Estado:** 🛠️ Refactorizado a php 8.2
:::

El `DbTrait` proporciona una capa de abstracción para la gestión de conexiones a bases de datos dentro de los controladores. Implementa un patrón similar al *Singleton* para asegurar que no se creen múltiples conexiones innecesarias durante el ciclo de vida de la petición.



## Funcionalidad Principal

El Trait gestiona una única propiedad estática `$db` que contiene la instancia activa de la base de datos.

### Método `connectDb()`
Este método es el encargado de inicializar la conexión.
- Si ya existe una conexión activa, devuelve `true` inmediatamente.
- Si se proporciona una configuración válida, utiliza `Database::checkDatabaseConnection()` para validar los credenciales antes de instanciar el objeto.

## Propiedades Estáticas

| Propiedad | Tipo | Descripción |
| :--- | :--- | :--- |
| `$db` | `?Database` | Instancia global de la base de datos para el contexto del controlador. |

## Ejemplo de Uso en un Controlador

```php
namespace Alxarafe\Controller;

use Alxarafe\Base\Controller\GenericController;
use Alxarafe\Base\Controller\Trait\DbTrait;

class MiControlador extends GenericController
{
    use DbTrait;

    public function __construct($action = null)
    {
        parent::__construct($action);
        // Intentar conectar con la configuración por defecto
        static::connectDb($this->config->db);
    }
}
```

## Cambios Técnicos (v8.5.1)

- Tipado Estricto: Se ha añadido declare(strict_types=1) y tipado explícito en los parámetros del método.
- Validación de Instancia: Uso de instanceof para una verificación más robusta de la propiedad estática $db.
- Simplificación de Lógica: Se ha optimizado el flujo de comprobación de la configuración para evitar anidamientos innecesarios.
