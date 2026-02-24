# ViewController

::: info
**Namespace:** `Alxarafe\Base\Controller`  
**Extiende:** `GenericController`  
**Usa:** `ViewTrait`  
:::

El `ViewController` es la clase base para todos los controladores que requieren renderizar una interfaz visual. Integra la lógica de negocio con el sistema de plantillas del framework.

## Características

- **Gestión de Vistas:** Hereda métodos para asignar variables y cambiar plantillas mediante el `ViewTrait`.
- **Configuración Automática:** Carga el objeto `Config` y establece el idioma global en el constructor.
- **Depuración Integrada:** Incluye ganchos para renderizar cabeceras y pies de página con información de debug.

## Propiedades

| Propiedad | Tipo | Descripción |
| :--- | :--- | :--- |
| `$config` | `object` | Almacena la configuración cargada desde `Config::getConfig()`. |
| `$debug` | `bool` | Si es `true`, permite la salida de información de depuración. |

## Ejemplo de Uso

```php
namespace Alxarafe\Controller;

class Contacto extends ViewController
{
    public function doIndex(): bool
    {
        $this->addVariable('titulo', 'Contacta con nosotros');
        return true;
    }
}
```

## Cambios Técnicos (v8.5.1)

- Tipado de Propiedades: Se ha definido explícitamente el tipo de $config y $debug.
- Constructor: Ahora propaga correctamente $action y $data al constructor padre.
- Refactorización de Métodos: Los métodos de renderizado ahora utilizan expresiones ternarias para mayor brevedad.
