# Sistema de Temas y Sobrescritura de Plantillas

Alxarafe utiliza un sistema de temas basado en la **sobrescritura en cascada** (Fallback System) de plantillas Blade. Este modelo permite una personalización granular de la interfaz sin necesidad de duplicar todo el código base.

## Filosofía de Diseño

El objetivo principal es la **flexibilidad total con mínima duplicidad**.

*   **Plantilla Base (Default)**: Ubicada en `templates/` (raíz de plantillas). Contiene la estructura completa y funcional de la aplicación por defecto. No pertenece a ningún "tema" específico, es el núcleo visual del framework.
*   **Temas (Themes)**: Ubicados en `templates/themes/{nombre_tema}/`. Son conjuntos de archivos que **sobrescriben** selectivamente a los de la plantilla base.
*   **Herencia Implícita**: Si un tema no contiene un archivo específico (ej: `partial/sidebar.blade.php`), el sistema cargará automáticamente el archivo equivalente de la plantilla base.

## Estructura de Directorios

```
templates/
├── common/                 # Componentes y parciales base reutilizables
│   ├── layout/
│   │   └── main.blade.php  # Layout principal por defecto
│   ├── partial/
│   │   ├── head.blade.php
│   │   └── sidebar.blade.php
│   └── component/
│       └── card.blade.php
│
└── themes/
    ├── cyberpunk/          # Tema personalizado "Cyberpunk"
    │   ├── partial/
    │   │   └── sidebar.blade.php  <-- Sobrescribe SÓLO el sidebar base
    │   └── component/
    │       └── card.blade.php     <-- Sobrescribe SÓLO el componente card
    │
    └── mi_tema_minimo/     # Tema con cambios mínimos
        └── partial/
            └── head.blade.php     <-- Solo cambia el head (ej: CSS)
```

## Mecanismo de Resolución (WebDispatcher)

El framework resuelve la ruta de las plantillas en el siguiente orden de prioridad (de mayor a menor):

1.  **Tema Activo**: `templates/themes/{tema_activo}/{ruta_archivo}`
2.  **Módulo (App)**: `src/Modules/{Modulo}/templates/{ruta_archivo}` (si aplica)
3.  **Base (Default)**: `templates/{ruta_archivo}`

### Ejemplo de Flujo

Si el sistema solicita renderizar `partial.sidebar` y el tema activo es `cyberpunk`:

1.  Busca: `templates/themes/cyberpunk/partial/sidebar.blade.php`
    *   ✅ **Existe**: Se renderiza este archivo.
    *   ❌ **No existe**: Pasa al siguiente nivel.

2.  Busca: `templates/common/partial/sidebar.blade.php` (Ruta base mapeada)
    *   ✅ **Existe**: Se renderiza el archivo base.

Esto permite crear temas que consisten únicamente en un archivo CSS personalizado (inyectado vía `partial/head.blade.php`) o temas que cambian radicalmente la estructura HTML.

## Personalización de JavaScript/TypeScript

El código TypeScript (`src/Frontend/ts`) generalmente permanece agnóstico al tema, ya que maneja la lógica de negocio y comportamiento (AJAX, manejadores de eventos).

Sin embargo, si un tema requiere comportamiento JS específico (ej: animaciones, widgets exclusivos):
1.  Se debe crear un archivo JS/TS separado para el tema.
2.  Inyectarlo en la plantilla `partial/head.blade.php` o `partial/footer.blade.php` sobrescrita del tema.
3.  Evitar modificar el núcleo `resource.ts` para cambios puramente visuales.

## Ventajas

1.  **Mantenibilidad**: Las actualizaciones en la plantilla base se propagan automáticamente a todos los temas, excepto en los archivos que estos hayan sobrescrito explícitamente.
2.  **Ligereza**: Un tema nuevo puede ser tan simple como una sola carpeta con un solo archivo modificado.
3.  **Organización**: Clara separación entre "lo que es el sistema" es "lo que es cosmético".
