# Controller (Base Autenticada)

::: info
**Namespace:** `Alxarafe\Base\Controller`  
**Extiende:** `ViewController`  
**Usa:** `DbTrait`  
:::

La clase `Controller` es el controlador base para todas las secciones privadas de la aplicación. A diferencia del controlador público, este impone restricciones estrictas de acceso y conectividad.

## Requisitos de Ejecución

Al instanciar cualquier clase que herede de `Controller`, se ejecutan automáticamente las siguientes validaciones en el constructor:

1.  **Exclusión de Configuración:** Si el controlador actual es `ConfigController`, se saltan las validaciones para permitir la configuración inicial del sistema.
2.  **Validación de Base de Datos:** Comprueba que la configuración de la base de datos existe y que la conexión es exitosa. Si falla, redirige al usuario al panel de configuración.
3.  **Control de Autenticación:** Verifica si el usuario ha iniciado sesión. Si no es así (y no estamos ya en la página de login), redirige automáticamente al `AuthController`.

## Propiedades

| Propiedad | Tipo | Descripción |
| :--- | :--- | :--- |
| `$username` | `?string` | Almacena el nombre del usuario autenticado (extraído de `Auth::$user`). |

## Ejemplo de Uso

```php
namespace Alxarafe\Controller;

use Alxarafe\Base\Controller\Controller;

class Dashboard extends Controller
{
    public function doIndex(): bool
    {
        // Si llegamos aquí, el usuario está logueado y la DB conectada.
        $this->addVariable('user', $this->username);
        return true;
    }
}
```

## Cambios Técnicos (v8.5.1)

- Seguridad de Tipos: Se ha tipado $username como nullable string y se ha activado el modo estricto.
- Operador Nullsafe: Uso de Auth::$user?->name para evitar errores si el objeto de usuario no está plenamente cargado.
- Legibilidad: Se ha estructurado el flujo de validación en el constructor para hacerlo más lineal y fácil de depurar.
