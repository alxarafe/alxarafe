# GenericPublicController

::: info
**Namespace:** `Alxarafe\Base\Controller`  
**Extiende:** `ViewController`  
**Usa:** `DbTrait`  
:::

El `GenericPublicController` es una clase abstracta diseñada para gestionar páginas públicas que necesitan acceso a la base de datos y renderizado de vistas, pero que **no requieren autenticación** de usuario.

## Funcionamiento

Esta clase combina la potencia de las vistas y la base de datos en un solo punto:

1.  **Herencia de Vistas:** Al extender de `ViewController`, hereda toda la lógica de plantillas y configuración de idioma.
2.  **Conexión a Datos:** Mediante el uso de `DbTrait`, el controlador establece automáticamente una conexión con la base de datos en el momento de su creación mediante el método `static::connectDb()`.

## Cuándo usarlo

Es el punto de partida ideal para:
- Páginas de inicio (Home).
- Pantallas de Login o Registro.
- Catálogos públicos de productos.
- Páginas de "Contacto" o "Acerca de".

## Ejemplo de Implementación

```php
namespace Alxarafe\Controller;

use Alxarafe\Base\Controller\GenericPublicController;

class Welcome extends GenericPublicController
{
    public function doIndex(): bool
    {
        // La base de datos ya está conectada aquí
        $this->addVariable('mensaje', 'Bienvenido a nuestra web pública');
        return true;
    }
}
```

## Cambios Técnicos (v8.5.1)

- Sincronización de Constructor: Ahora acepta los parámetros $action y $data para mantener la coherencia con la jerarquía de controladores.
- Tipado Estricto: Se ha incorporado declare(strict_types=1) para asegurar la integridad de los datos en toda la cadena de herencia.
- Formato de Copyright: Actualizado al estándar legal de 2026.
