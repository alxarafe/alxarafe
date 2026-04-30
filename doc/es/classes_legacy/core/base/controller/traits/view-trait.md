# ViewTrait

::: info
**Namespace:** `Alxarafe\Base\Controller\Trait`  
**Uso:** Inyectado en controladores que necesitan renderizar HTML.  
**Estado:** 🛠️ Refactorizado a php 8.2
:::

El `ViewTrait` es el encargado de gestionar la comunicación entre la lógica del controlador y la capa de presentación (vistas). Facilita la inyección de datos y la selección de plantillas.



## Funcionalidad Principal

### Gestión de Datos (`viewData`)
El trait mantiene un contenedor interno de variables. Estas variables se extraen automáticamente al renderizar la vista, permitiendo que estén disponibles como variables locales en los archivos PHP de las plantillas.

### Métodos Principales

| Método | Descripción |
| :--- | :--- |
| `setDefaultTemplate()` | Inicializa el motor de plantillas con un diseño específico. |
| `addVariable()` | Añade un par clave/valor para ser usado en la vista. |
| `addVariables()` | Fusiona un array completo de datos en el contenedor de la vista. |
| `render()` | Ejecuta el procesamiento de la plantilla y devuelve el HTML resultante. |

## Ejemplo de Uso

```php
class ArticuloController extends ViewController
{
    public function doShow(): bool
    {
        // Añadir una variable individual
        $this->addVariable('titulo', 'Mi primer artículo');
        
        // Añadir múltiples variables
        $this->addVariables([
            'autor' => 'Rafael San José',
            'fecha' => date('Y-m-d')
        ]);

        return true;
    }
}
```

## Cambios Técnicos (v8.5.1)

- Tipado Estricto: Se ha implementado declare(strict_types=1) y tipado de retorno void y string.
- Propiedades Tipadas: La propiedad $template ahora está tipada como ?Template para evitar errores de acceso a nulos.
- Limpieza de Nombres: Se ha renombrado la propiedad interna de datos a $viewData (anteriormente podía ser ambigua) para mayor claridad semántica.
- Inicialización Lazy: El método render() asegura que el objeto Template exista antes de intentar procesar la vista.
