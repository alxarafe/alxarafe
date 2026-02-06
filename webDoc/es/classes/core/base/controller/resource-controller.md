# ResourceController

::: info
**Namespace:** `Alxarafe\Base\Controller`
**Extends:** `Controller`
:::

El `ResourceController` es un controlador unificado diseñado para simplificar la gestión de recursos (CRUD). Combina las vistas de listado y edición en una sola lógica, alternando el modo automáticamente según la presencia de un identificador de registro.

## Funcionalidades

- **Modo Dual:** Detecta automáticamente si debe mostrar un listado (`MODE_LIST`) o un formulario de edición (`MODE_EDIT`) basándose en los parámetros de la petición (`id` o `code`).
- **Auto-Scaffolding:** Capaz de generar columnas de listado y campos de edición automáticamente inspeccionando los metadatos del Modelo Eloquent asociado.
- **Soporte Multi-Pestaña:** Permite definir múltiples modelos relacionados (por ejemplo: Principal, Direcciones, Teléfonos) y genera pestañas de navegación automáticamente.
- **API AJAX Integrada:** Incluye métodos nativos para recuperar datos JSON (`fetchListData`, `fetchRecordData`) y guardar registros (`saveRecord`), facilitando la creación de interfaces SPA (Single Page Application).
- **Componentes UI:** Transforma tipos de datos SQL (date, boolean, varchar) en componentes visuales de Alxarafe (`Date`, `Boolean`, `Text`).

## Propiedades

| Propiedad | Tipo | Descripción |
| :--- | :--- | :--- |
| `$mode` | `string` | Modo actual del controlador (`list` o `edit`). |
| `$recordId` | `string\|null` | ID del registro actual en modo edición. |
| `$modelClass` | `string\|null` | Clase del modelo principal (si es un controlador simple). |
| `$structConfig` | `array` | Array de configuración que define pestañas, botones y campos para la vista. |

## Métodos Principales

- `getModelClass()`: Método abstracto que debe definir el modelo o modelos asociados. Puede devolver una clase (`Person::class`) o un array de pestañas (`['general' => Person::class, 'addr' => Address::class]`).
- `buildConfiguration()`: Construye la configuración de la interfaz. Si no se proporcionan definiciones manuales de campos, invoca a `convertModelFieldsToComponents()` para generarlos desde el modelo.
- `convertModelFieldsToComponents(array $modelFields)`: Convierte metadatos de campos de Eloquent en objetos componentes de UI.

## Ejemplo de Uso

```php
namespace Modules\Agenda\Controller;

use Alxarafe\Base\Controller\ResourceController;
use Modules\Agenda\Model\Person;

class PersonController extends ResourceController
{
    // Definición básica: el controlador auto-generará las columnas y campos
    public static function getModelClass(): string
    {
        return Person::class;
    }

    // Opcional: Personalizar filtros
    protected function getFilters(): array
    {
        return [
            new DateRangeFilter('created_at', 'Fecha Alta'),
        ];
    }
}
```
