# ApiController

::: info
**Namespace:** `Alxarafe\Base\Controller`  
**Usa:** `DbTrait`  
**Autenticación:** JWT (JSON Web Tokens)  
**Estado:** 🛠️ Refactorizado a PHP 8.5.1
:::

El `ApiController` es el controlador base para construir servicios API REST dentro del framework. A diferencia de los controladores basados en vistas, este está optimizado para la comunicación mediante objetos JSON y utiliza un flujo de ejecución que termina en la salida del buffer.

## Características Principales

### 1. Autenticación mediante Tokens
El controlador busca automáticamente un parámetro `token` en la petición (`$_REQUEST`). Si existe, utiliza la librería **Firebase JWT** para:
- Decodificar el token usando la clave de seguridad del sistema definida en `Auth`.
- Identificar al usuario y cargarlo en la propiedad estática `static::$user`.

### 2. Respuestas Estandarizadas
La clase proporciona métodos finales para asegurar que todas las salidas de la API mantengan la misma estructura consistente:
- `jsonResponse()`: Para peticiones exitosas (HTTP 200 por defecto).
- `badApiCall()`: Para errores de cliente o servidor (HTTP 400 o 401 por defecto).



## Propiedades Estáticas

| Propiedad | Tipo | Descripción |
| :--- | :--- | :--- |
| `$user` | `?User` | Objeto del usuario identificado tras validar el token JWT. |

## Ejemplo de Uso

```php
namespace Alxarafe\Controller\Api;

class PerfilController extends ApiController
{
    public function getInfo()
    {
        if (static::$user) {
            static::jsonResponse(['email' => static::$user->email]);
        }
        
        static::badApiCall('Usuario no identificado', 404);
    }
}
```

## Cambios Técnicos (v8.5.1)

- Tipo de Retorno never: Los métodos de respuesta ahora usan el tipo never, indicando que la ejecución del script finaliza en ese punto.
- Control de Depuración: Se ha refinado el método appendDebugInfo para incluir trazas de retroceso solo si la seguridad está en modo debug.
- Refactorización Interna: Se ha centralizado el envío de cabeceras en el método privado sendJsonResponse para evitar duplicidad de código.
- JSON_THROW_ON_ERROR: Se asegura que el codificador JSON lance excepciones en caso de fallo de serialización.
