# Model (Capa de Datos)

::: info
**Namespace:** `Alxarafe\Base\Model`  
**Extiende:** `Illuminate\Database\Eloquent\Model`  
**Estado:** 🛠️ Refactorizado a php 8.2
:::

La clase `Model` base integra el ORM **Eloquent** (de Laravel) en el ecosistema Alxarafe, añadiendo funcionalidades de introspección de esquema útiles para la generación dinámica de interfaces.

## Funcionalidades Extra

Además de todas las capacidades de Eloquent (Query Builder, relaciones, etc.), esta clase añade:

### Introspección de Esquema
Mediante el método `getFields()`, el modelo consulta directamente al motor de base de datos (`SHOW COLUMNS`) para obtener metadatos en tiempo real. Esto permite conocer:
- Si un campo es obligatorio (*required*).
- El tipo de input HTML más adecuado (*genericType*).
- Longitudes máximas y valores por defecto.

### Mapeo de Tipos
El método `mapToGenericType()` traduce tipos complejos de SQL (como `varchar`, `tinyint` o `text`) a tipos simplificados para el frontend (`text`, `number`, `boolean`, `textarea`).

## Métodos Principales

| Método | Descripción |
| :--- | :--- |
| `existsInSchema()` | Verifica si la tabla física existe en la base de datos actual. |
| `primaryColumn()` | Retorna el nombre de la columna que actúa como clave primaria. |
| `getFields()` | Devuelve un array asociativo con la configuración de cada columna. |

## Ejemplo de Uso

```php
namespace Alxarafe\Model;

use Alxarafe\Base\Model\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
}

// Obtener metadatos para construir un formulario dinámico
$campos = Usuario::getFields();
```

## Cambios Técnicos (v8.5.1)

- Match Expression: Se ha sustituido la cadena de if en mapToGenericType por una expresión match de PHP 8.x, mucho más limpia y eficiente.
- Tipado de Retorno: Añadido declare(strict_types=1) y tipos estrictos en todos los métodos.
- Renombrado semántico: El método exists() de Eloquent puede entrar en conflicto con la lógica de existencia de tabla, por lo que se ha renombrado a existsInSchema() para mayor claridad.
- Casteo Seguro: Se asegura el casteo a string de las propiedades devueltas por DB::select para evitar errores de tipado.
