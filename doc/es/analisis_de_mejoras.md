# Análisis de Puntos Débiles y Plan de Mejora

Este documento resume el análisis técnico del estado actual de **Alxarafe Microframework**. Su objetivo es identificar barreras para la adopción y proponer una hoja de ruta para su modernización.

## 1. Puntos Débiles (Diagnosticados)

### 🔴 Rutas "Mágicas" y Opacas
*   **Problema:** El framework utiliza escaneo recursivo de directorios (`glob()`) para generar rutas basadas en la existencia de archivos.
*   **Impacto:**
    *   **Rendimiento:** El I/O de disco para escanear carpetas en cada petición es costoso.
    *   **Rigidez:** Las URLs están atadas a la estructura de archivos. No se pueden personalizar (ej. `/login` debe ser `/Admin/Auth/login`).
    *   **Depuración:** Es difícil rastrear qué controlador atiende una URL específica.

### 🔴 Renderizado Implícito (Destructor)
*   **Problema:** `ViewTrait` utiliza el método mágico `__destruct()` para renderizar la vista al final de la ejecución del script.
*   **Impacto:**
    *   **Flujo Impredecible:** Si ocurre una excepción o se llama a `die()`, la vista puede romperse o no renderizarse.
    *   **Testing:** Es extremadamente difícil realizar pruebas unitarias de controladores que emiten salida (echo) al destruirse el objeto.

### 🔴 Acoplamiento Fuerte y Falta de DI
*   **Problema:** Uso extensivo de clases estáticas (`Config::getConfig()`, `Auth::user`) y instanciación directa (`new Class`).
*   **Impacto:**
    *   **Testabilidad:** Impide el uso de Mocks/Stubs para testing.
    *   **Extensibilidad:** Dificulta reemplazar componentes core (ej. cambiar el sistema de Auth) sin reescribir el framework.

### 🔴 Módulo Admin Monolítico
*   **Problema:** El módulo de administración (`src/Modules/Admin`) está incluido en el paquete base.
*   **Impacto:**
    *   **Bloat (Hinchazón):** Proyectos que solo requieren una API o una web simple deben cargar con toda la lógica y vistas del panel de administración.

---

## 2. Propuesta de Modernización (Hoja de Ruta)

### Fase 1: Modernización del Routing (Prioridad Alta)
Abandonar el escaneo de carpetas en favor de **Atributos de PHP 8**.

*   **Acción:** Implementar un `Router` que lea atributos en los controladores.
*   **Ejemplo:**
    ```php
    #[Route('/blog/post/{id}', method: 'GET')]
    public function show(int $id) { ... }
    ```
*   **Beneficio:** URLs limpias, explícitas y mejor rendimiento (se pueden cachear).

### Fase 2: Ciclo de Vida Explícito (Request -> Response)
Cambiar el patrón de "Echo en Destructor" por un retorno de respuesta.

*   **Acción:** Los controladores deben retornar un objeto `Response` (o `View`).
*   **Ejemplo:**
    ```php
    public function index() {
        return view('blog.index', ['data' => $data]);
    }
    ```
*   **Beneficio:** Control total sobre el flujo, facilidad para middlewares y testing.

### Fase 3: Desacoplamiento Modular
Extraer el módulo de administración a un paquete separado.

*   **Acción:** Mover `src/Modules/Admin` a un repositorio propio (`alxarafe/admin-panel`).
*   **Beneficio:** Alxarafe se convierte en un microframework puro, ligero y multipropósito.

### Fase 4: Kernel de Aplicación (Arranque Unificado)
Unificar el punto de entrada.
*   **Acción:** Crear una clase `App` o `Kernel` que inicialice el framework, en lugar de depender de la configuración dispersa en `index.php`.
*   **Beneficio:** Arranque estandarizado y facilidad de instalación.

---

## 3. Sugerencias de Mejora (Marzo 2026)

### ✅ Implementado: Atributo `#[ExtraFieldsModel]`
*   **Acción:** Se ha creado una forma explícita de vincular modelos de extrafields a través del atributo `#[ExtraFieldsModel]`.
*   **Beneficio:** Elimina la dependencia de nombres de clase rígidos y permite prefijos y etiquetas personalizados por modelo.

### 🚀 Futuras Mejoras Propuestas

#### 1. Migración de Webpack a Vite
*   **Acción:** Reemplazar el stack de construcción de assets (JS/SCSS) de Webpack por Vite.
*   **Beneficio:** Unificación con el sistema de documentación (VitePress), tiempos de compilación casi instantáneos y mejor experiencia de desarrollo (HMR).

#### 2. Modularización de `ResourceTrait`
*   **Acción:** Dividir el trait monolítico `ResourceTrait.php` (actualmente >1800 líneas) en componentes especializados (`HasListLogic`, `HasEditLogic`, `HasMetadata`).
*   **Beneficio:** Código más limpio, fácil de mantener y permite composición de controladores más flexible para el desarrollador.

#### 3. Tipado Estricto y Propiedades Readonly (PHP 8.2+)
*   **Acción:** Adoptar plenamente las características de PHP 8.2 en el Core, incluyendo propiedades `readonly` para configuraciones de arranque y tipos de retorno estrictos en todos los hooks de ciclo de vida.
*   **Beneficio:** Mayor robustez del código, detección temprana de errores y mejor soporte para IDEs.
