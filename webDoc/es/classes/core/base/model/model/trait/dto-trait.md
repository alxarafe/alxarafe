# DtoTrait

::: info
**Namespace:** `Alxarafe\Base\Model\Trait`  
**Uso:** Inyectado en modelos o clases de datos para proporcionar acceso dinámico.  
**Estado:** 🛠️ Refactorizado a PHP 8.5.1
:::

El `DtoTrait` permite que los objetos se comporten como contenedores de datos inteligentes. Proporciona acceso mediante métodos mágicos, facilitando el uso de "getters" y "setters" sin necesidad de definirlos manualmente si se sigue una convención de nombres.

## Acceso Dinámico

El Trait intercepta el acceso a propiedades para buscar métodos que cumplan con las convenciones `snake_case` o `camelCase`.

### Ejemplo de Resolución de Nombres
Si intentas acceder a `$objeto->nombre_completo`:
1. El Trait buscará el método `get_nombre_completo()`.
2. Si no existe, buscará `getNombreCompleto()`.
3. Si no existe, intentará devolver la propiedad `$nombre_completo` directamente.

## Métodos de Utilidad

| Método | Descripción |
| :--- | :--- |
| `setData(stdClass $data)` | Hidrata el objeto actual con los datos de un objeto genérico. |
| `toArray()` | Convierte las propiedades visibles del objeto en un array asociativo. |

## Ejemplo de Implementación

```php
class UsuarioDTO
{
    use DtoTrait;

    private string $nombre = 'Rafael';

    public function getNombre(): string
    {
        return strtoupper($this->nombre);
    }
}

$user = new UsuarioDTO();
echo $user->nombre; // Salida: RAFAEL (vía el getter mágico)
```

## Cambios Técnicos (v8.5.1)

- Soporte Multi-formato: Se han resuelto los pendientes para soportar indistintamente set_property y setProperty.
- Desempaquetado de Argumentos: El método __call ahora utiliza el operador splat (...$arguments) para pasar parámetros de forma nativa.
- Optimización de toArray: Se ha sustituido la doble codificación JSON por get_object_vars() para un rendimiento significativamente mayor.
- Tipado Estricto: Implementación de tipos escalares en todos los métodos mágicos.
