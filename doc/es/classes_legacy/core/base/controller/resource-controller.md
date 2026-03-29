# ResourceController

::: info
**Namespace:** `Alxarafe\Base\Controller`
**Extends:** `Controller`
:::

El `ResourceController` es un controlador unificado diseñado para simplificar la gestión de recursos (CRUD). Combina las vistas de listado y edición en una sola lógica, alternando el modo automáticamente según la presencia de un identificador de registro.

## Funcionalidades

- **Modo Dual:** Detecta automáticamente si debe mostrar un listado (`MODE_LIST`) o un formulario de edición (`MODE_EDIT`) basándose en los parámetros de la petición (`id` o `code`).
- **Auto-Scaffolding Inteligente:** Capaz de generar columnas de listado y campos de edición automáticamente inspeccionando los metadatos del Modelo Eloquent asociado. Inyecta automáticamente restricciones de base de datos (`maxlength`, `min/max` para numéricos) en los componentes visuales.
- **Soporte Multi-Pestaña (Edición):** Permite organizar los campos de edición en múltiples pestañas (por ejemplo: Principal, Direcciones, Observaciones) mediante una estructura de array en `getEditFields()`.
- **Sincronización de Relaciones 1:N:** Gestiona automáticamente la creación, actualización y *borrado* de registros relacionados (ej: Direcciones de una Persona) basándose en los datos enviados desde el frontend.
- **API AJAX Integrada:** Incluye métodos nativos para recuperar datos JSON (`fetchListData`, `fetchRecordData`) y guardar registros (`saveRecord`), facilitando la creación de interfaces SPA.
- **UX Avanzada:**
  - **Soft Delete Visual:** En listas de relaciones, el borrado es visual (tachado) hasta que se guarda, permitiendo deshacer cambios.
  - **Detección de Cambios:** Avisa al usuario si intenta salir sin guardar.
  - **Botón Recargar:** Permite descartar cambios no guardados y recargar los datos del servidor.

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
- `getEditFields()`: Define los campos del formulario de edición. Soporta retorno de array plano (pestaña única) o estructura multi-pestaña.

## Personalización de Edición (Multi-Pestaña)

Para organizar los campos en pestañas, `getEditFields()` debe devolver un array asociativo:

```php
protected function getEditFields(): array
{
    return [
        'general' => [
            'label' => 'Datos Generales',
            'fields' => [
                new Text('name', 'Nombre'),
                new Boolean('active', 'Activo'),
            ]
        ],
        'addresses' => [
            'label' => 'Direcciones',
            'fields' => [
                new RelationList('addresses', 'Direcciones', [...])
            ]
        ]
    ];
}
```

## Ejemplo de Uso Básico

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
