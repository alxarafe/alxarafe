# Capa de Herramientas – Referencia de API

`Namespace: Alxarafe\Tools`

Herramientas de infraestructura para despacho de peticiones, depuración, gestión de módulos y resolución de dependencias.

---

## `Dispatcher`

Punto de entrada principal del framework. Inicializa constantes, traducciones y enruta al despachador apropiado.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `run()` | `static run(array $alternative_routes = []): void` | Bootstrap y despacho. Detecta API vs Web. |

## `WebDispatcher`

Gestiona peticiones web: resolución de rutas, instanciación de controladores, tema/idioma, plantillas y errores.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `dispatch()` | `static dispatch(string $defaultModule, string $defaultController, string $defaultAction): bool` | Punto de entrada completo del ciclo de vida. |
| `run()` | `static run(string $module, string $controller, string $method): bool` | Despacho core. |

## `Debug`

Integra PHP DebugBar para desarrollo. Logging de mensajes y renderizado de header/footer.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `initialize()` | `static initialize(bool $reload = false): void` | Inicializa DebugBar si debug habilitado. |
| `message()` | `static message(string $msg): void` | Log de mensaje de debug. |

## `ModuleManager`

Escanea directorios de módulos, lee atributos `#[ModuleInfo]` y construye arrays de menú de navegación.

## `DependencyResolver`

Construye DAG de dependencias de módulos escaneando `use` y `#[RequireModule]`. Detecta dependencias circulares.
