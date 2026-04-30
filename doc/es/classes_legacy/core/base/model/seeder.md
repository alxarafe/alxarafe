# Seeder (Población de Datos)

::: info
**Namespace:** `Alxarafe\Base`  
**Uso:** Clase base para datos maestros y de configuración inicial.  
**Estado:** 🛠️ Refactorizado a php 8.2
:::

La clase `Seeder` permite automatizar la inserción de registros iniciales en la base de datos (como una lista de países, tipos de documentos o usuarios administradores). Trabaja en estrecha colaboración con los **Modelos de Eloquent**.

## Lógica de Ejecución

El constructor de la clase implementa una protección nativa para evitar duplicados:
1. **Truncado opcional:** Si se instancia con `true`, vacía la tabla por completo antes de empezar.
2. **Verificación de conteo:** El método `run()` solo se ejecuta si la tabla está actualmente vacía.

## Métodos a Implementar

Al crear un seeder nuevo, es obligatorio definir dos métodos:

| Método | Retorno | Descripción |
| :--- | :--- | :--- |
| `model()` | `class-string` | Debe devolver el nombre de la clase del modelo (ej: `Usuario::class`). |
| `run()` | `void` | Contiene la lógica de creación de registros (ej: `$model::create([...])`). |

## Ejemplo de Implementación

```php
namespace Alxarafe\Seeder;

use Alxarafe\Base\Seeder;
use Alxarafe\Model\Pais;

class PaisSeeder extends Seeder
{
    protected static function model(): string
    {
        return Pais::class;
    }

    protected function run(string $model): void
    {
        $model::create(['nombre' => 'España', 'iso' => 'ES']);
        $model::create(['nombre' => 'Portugal', 'iso' => 'PT']);
    }
}
```

## Cambios Técnicos (v8.5.1)

- Tipado de Clase Estricto: Se utiliza el tipo `class-string<Model>` para garantizar que el seeder solo opere con clases que hereden de nuestro Modelo base.
- Tipado Escalar: Se ha añadido bool al parámetro del constructor y void como retorno de run().
- Protección de Datos: Se ha reforzado la lógica de guardado para evitar colisiones accidentales durante el proceso de migración automática.
