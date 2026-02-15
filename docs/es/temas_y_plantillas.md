# Sistema de Temas y Plantillas en Alxarafe

Este documento detalla el funcionamiento del sistema de plantillas del framework Alxarafe, cómo se resuelven las rutas de los archivos Blade y cómo se puede personalizar la apariencia de la aplicación mediante temas y sobreescritura de plantillas.

## 1. Jerarquía de Carpetas y Resolución de Plantillas

Alxarafe utiliza un sistema de "fallback" (o cascada) para localizar los archivos de plantilla (`.blade.php`). Cuando el controlador solicita una vista, el sistema busca en las siguientes ubicaciones, **en este orden exacto**. El primer archivo encontrado es el que se utiliza.

### 1.1. Tema Personalizado (Aplicación y Paquete)

El sistema busca primero si existe una versión de la plantilla específica para el tema activo (`main.theme` en `config.json`).
Esto permite tener múltiples apariencias sin modificar el código base.

1.  **Tema en la Aplicación**: `[APP_ROOT]/templates/themes/[TEMA]/`
    *   *Uso*: Para definir o modificar un tema específico para esta instancia de la aplicación.
2.  **Tema en el Paquete**: `vendor/alxarafe/alxarafe/templates/themes/[TEMA]/`
    *   *Uso*: Temas predefinidos distribuidos con el framework (ej. `default`, `cyberpunk`).

### 1.2. Plantillas de Módulo

Si no se encuentra en el tema, el sistema busca dentro de las carpetas del módulo correspondiente.

3.  **Módulo en la Aplicación**: `[APP_ROOT]/Modules/[MODULO]/templates/`
    *   *Uso*: Sobreescribir las vistas de un módulo específico (ej. `Admin`, `User`) sin tocar el vendor.
4.  **Módulo en el Paquete**: `vendor/alxarafe/alxarafe/src/Modules/[MODULO]/templates/`
    *   *Uso*: Ubicación original de las vistas de los módulos del núcleo.

### 1.3. Plantillas Generales

Si la vista no es específica de un tema ni de un módulo, se busca en las carpetas de plantillas generales.

5.  **Plantillas Globales de la Aplicación**: `[APP_ROOT]/templates/`
    *   *Uso*: Aquí se definen los cambios globales que afectan a toda la aplicación (ej. cambiar el `layout/main.blade.php` para todos). **Esta es la carpeta recomendada para personalizaciones generales.**
6.  **Plantillas Globales del Paquete (Default)**: `vendor/alxarafe/alxarafe/templates/`
    *   *Uso*: **Estructura base del framework.** Contiene los layouts, componentes y parciales por defecto. Esta carpeta se actualiza con `composer update` y **NO debe ser modificada manualmente**, ya que los cambios se perderían.

---

## 2. Estructura de las Plantillas Por Defecto

El tema por defecto (`default`) y la estructura base en `vendor/alxarafe/alxarafe/templates/` definen la composición de la página.

### 2.1. Archivo Principal: `layout/main.blade.php`

Este es el esqueleto HTML principal de la aplicación. Define la estructura `<html>`, `<head>`, y `<body>`.
Carga los siguientes bloques principales:

*   **Header (`partial.head`)**: Metadatos, CSS y Scripts globales.
*   **Body (`partial.body_standard` o `partial.body_empty`)**: Contenedor visual.
*   **Footer (`partial.footer`)**: Pie de página y scripts de cierre.

### 2.2. Bloques de Contenido (`partial/body_standard.blade.php`)

Dentro del cuerpo estándar, la pantalla se divide en áreas funcionales. Aunque visualmente pueden variar (barra superior, lateral, off-canvas), conceptualmente se definen así:

#### **A. Menú Principal (`main_menu`)**
*   **Archivo por defecto**: `templates/partial/side_bar.blade.php` (y parte de `top_bar.blade.php`).
*   **Función**: Contiene la navegación principal de la aplicación (Módulos, Controladores).
*   **Personalización**: Para cambiar la navegación principal, sobreescriba `partial/side_bar.blade.php` en `[APP_ROOT]/templates/partial/`.

#### **B. Menú de Iconos y Utilidades (`icons_menu`)**
*   **Archivo por defecto**: `templates/partial/top_bar.blade.php` (Sección derecha).
*   **Función**: Herramientas de usuario, notificaciones, cambio de idioma, perfil de usuario y reloj.
*   **Personalización**: Para añadir iconos o widgets al encabezado, sobreescriba `partial/top_bar.blade.php`.

#### **C. Contenido Central (`content`)**
*   **Definición**: `@yield('content')`
*   **Función**: Aquí se inyecta la vista específica de cada controlador (ej. el formulario de login, la lista de usuarios, etc.).

### 2.3. Resumen de Carpetas Clave en `templates/`

| Carpeta | Descripción |
| :--- | :--- |
| `layout/` | Estructuras base de página (ej. `column`, `row`, `container`). |
| `partial/` | Fragmentos reutilizables (`header`, `footer`, `alerts`, `side_bar`, `top_bar`). |
| `component/` | Componentes de UI (ej. `card`, `modal`, `button`). |
| `form/` | Plantillas para renderizado automático de formularios. |
| `page/` | Páginas completas específicas (ej. `migration`, `error`). |
| `core/` | Vistas internas del sistema (ej. CRUD automático). |
| `themes/` | Carpetas para temas específicos (`default`, `cyberpunk`, etc.). |

---

## 3. Notas sobre Assets (CSS/JS)

El script `ComposerScripts` se encarga de publicar los archivos estáticos (imágenes, CSS, JS) desde el paquete hacia la carpeta pública.

*   **Origen**: `vendor/alxarafe/alxarafe/assets` y `vendor/alxarafe/alxarafe/templates/themes/[TEMA]/assets`
*   **Destino**: `public/alxarafe/assets` y `public/themes/[TEMA]/`

**Importante**: A diferencia de las plantillas `.blade.php` (que se leen dinámicamente según la jerarquía), los archivos CSS/JS **sí se copian** físicamente a `public`. Si necesita modificar el CSS base, debe hacerlo creando un nuevo tema o sobreescribiendo el archivo en su propia estructura de assets, no editando los archivos en `vendor`.
