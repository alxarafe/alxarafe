# Arquitectura de Alxarafe

Alxarafe sigue un patrón MVC (Modelo-Vista-Controlador) modular, pero con un fuerte enfoque en la "Convención sobre Configuración" para minimizar el código repetitivo (boilerplate).

## 1. Ciclo de Vida de una Petición

El framework no impone un `index.php` único, pero el flujo recomendado es:

1.  **Entrada:** El servidor web dirige la petición a un script de entrada (normalmente `index.php`).
2.  **Despacho:** El script invoca a `Alxarafe\Tools\Dispatcher\WebDispatcher` (o `ApiDispatcher`).
3.  **Enrutamiento:** El Dispatcher consulta `Routes::getAllRoutes()` para encontrar la clase controlador adecuada basándose en los parámetros (Módulo, Controlador).
4.  **Ejecución:**
    *   Se instancia el Controlador.
    *   Se busca el método solicitado. Si no existe, se hace fallback a `index`.
    *   Si el controlador extiende `GenericController`, el método `index` (u otro) invoca la lógica de acción (`doAction`).
5.  **Renderizado:** Al finalizar la ejecución (destrucción del objeto controlador), el `ViewTrait` renderiza automáticamente la plantilla Blade asociada.

## 2. Sistema de Rutas (Routing)

Alxarafe **no utiliza archivos de rutas**. Las rutas se generan dinámicamente escaneando los directorios de código.

*   Clase: `Alxarafe\Lib\Routes`
*   Mecanismo: Busca en `src/Modules/` y `vendor/alxarafe/alxarafe/src/Modules/`.
*   Patrones reconocidos:
    *   `*Controller.php` -> Rutas Web.
    *   `*Api.php` -> Rutas API.
    *   `*Migration.php` -> Migraciones.

Por ejemplo, si existe `src/Modules/Blog/Controller/PostController.php`, automáticamente se genera una ruta accesible (dependiendo de cómo tu `index.php` maneje los parámetros, ej: `?module=Blog&controller=Post`).

## 3. Controladores (Controllers)

Los controladores heredan de `Alxarafe\Base\Controller\Controller` (para rutas protegidas) o `GenericController`.

### Patrón `doAction`
Aunque el Dispatcher llama al método público (ej. `save()`), `GenericController` implementa un patrón donde la lógica real reside en métodos con prefijo `do` (ej. `doSave()`).

Esto permite:
1.  Interceptar la llamada en `beforeAction()` y `afterAction()`.
2.  Manejar la acción por defecto `index` que lee el parámetro `action` de la petición (`$_REQUEST['action']`) y redirige al `doAction` correspondiente.

**Ejemplo:**
Una llamada a `PostController->index()` con `?action=crear` ejecutará internamente `doCrear()`.

## 4. Vistas (Views)

El sistema de vistas utiliza **Blade** (el motor de plantillas de Laravel).

*   **Renderizado Automático:** No es necesario llamar a `view()` o `render()`. El `Alxarafe\Base\Controller\Trait\ViewTrait` se encarga de renderizar la plantilla en el método `__destruct()` del controlador.
*   **Convención de Nombres:** Por defecto, un controlador `PostController` buscará una plantilla en `page/post.blade.php`.
*   **Ubicación:** Las plantillas se buscan en orden de prioridad:
    1.  `src/Modules/{Modulo}/Templates/` (en tu proyecto).
    2.  `vendor/.../src/Modules/{Modulo}/Templates/` (en el core).

## 5. API REST

Para APIs, se utiliza `ApiDispatcher` y los controladores heredan de `Alxarafe\Base\Controller\ApiController`.
*   **Autenticación:** Soporte nativo para JWT.
*   **Respuesta:** Métodos helper `jsonResponse()` y `badApiCall()` para estandarizar salidas JSON.

## 6. Base de Datos

*   **Configuración:** Se define en `config.json`.
*   **Abstracción:** Se utiliza `Alxarafe\Base\Database` (basado en PDO/Illuminate Database).
*   **Traits:** `DbTrait` facilita la conexión y operaciones comunes en controladores.
*   **Modelos:** Se recomienda usar Eloquent (Illuminate) o el modelo base de Alxarafe.
