# Temas Disponibles en Alxarafe

## Visión General

Alxarafe incluye un sistema de temas que permite personalizar la apariencia visual completa de la aplicación. Los temas se seleccionan mediante el selector de paleta (icono 🎨) en el menú de usuario.

## Filosofía de Diseño

La mayoría de los temas son un **simple cambio de CSS** o algún componente con comportamiento diferente (por ejemplo, cambiar un checkbox por un selector si/no). El framework es simple por defecto, pero **muy flexible**.

Para demostrar esa flexibilidad estructural, **Cyberpunk** actúa como "la oveja negra": reubica el menú de usuario al margen derecho (en lugar de arriba), usa iconos más grandes y tiene un layout completamente propio. Todo esto mediante componentes personalizados y un layout override, sin modificar el framework base.

> **Principio**: El menú lateral se muestra cuando hay opciones de menú disponibles y se oculta cuando no las hay. No se distingue entre público y privado a nivel de layout.

## Mecanismo de Carga

El tema activo se determina con la siguiente prioridad:

1. **Cookie `alx_theme`** → establecida al cambiar tema desde el selector
2. **Preferencia de usuario** → campo `theme` del registro de usuario (si está identificado)
3. **Configuración** → `config.json` → `main.theme`
4. **Fallback** → `default`

Cuando un usuario identificado cambia de tema, se persiste automáticamente en su registro de usuario.

El CSS del tema se carga desde `/themes/{nombre}/css/default.css` y las plantillas Blade se resuelven por cascada: primero las del tema, luego las del módulo, luego las generales.

## Temas Incluidos

### 1. **Default** (Sistema)
- **Estilo**: Moderno, limpio, minimalista
- **Paleta**: Fondo gris claro (#f8f9fa), texto oscuro, acentos Bootstrap azules
- **Tipografía**: System UI / Apple sans-serif
- **Alcance**: Solo CSS

### 2. **Alternative**
- **Estilo**: Pastel, suave, amigable
- **Paleta**: Fondo crema (#FDFBF7), azul pervinca, menta pálido, rosa pastel
- **Tipografía**: Segoe UI / Tahoma
- **Alcance**: CSS + componentes (`boolean`, `select`, `fields/`)

### 3. **Cyberpunk** ⚡ (Demo de flexibilidad estructural)
- **Estilo**: Retrofuturista años 80, neón, oscuro
- **Paleta**: Fondo negro (#0b0c10), cian neón (#66fcf1), teal (#45a29e)
- **Tipografía**: Courier New (monoespaciada)
- **Alcance**: Layout completo propio + CSS extenso + componentes (`card`, `menu_item`, `select`) + parciales (`main_menu`, `user_menu`) + SCSS fuente
- **Diferencias estructurales**: Menú de usuario en el margen derecho (no arriba), iconos grandes, grid overlay de fondo, efectos glitch/scanline

### 4. **High-Contrast**
- **Estilo**: Accesibilidad, alto contraste
- **Paleta**: Fondo negro (#000000), texto amarillo (#FFFF00), bordes blancos, highlight magenta
- **Tipografía**: Arial / Helvetica (110% tamaño base)
- **Alcance**: CSS + componente card propio

### 5. **Vintage**
- **Estilo**: Retro, clásico, nostálgico
- **Paleta**: Fondo pergamino (#f4ecd8), texto marrón (#4e342e), acentos café (#8d6e63)
- **Tipografía**: Georgia / Times New Roman (serif)
- **Alcance**: Solo CSS

## Cómo Crear un Tema Nuevo

1. Crear la carpeta `templates/themes/{mi-tema}/`
2. Crear `css/default.css` con los estilos del tema
3. (Opcional) Sobreescribir componentes Blade (ej: `component/card.blade.php`, `form/boolean.blade.php`)
4. (Opcional) Para cambios estructurales, sobreescribir el layout completo (`partial/layout/main.blade.php`)
5. Ejecutar `composer update` para publicar assets a `public/themes/`

## Estructura de Archivos por Tema

| Tema | CSS | Layout Propio | Componentes | Parciales |
|:---|:---:|:---:|:---:|:---:|
| default | ✅ | — | — | — |
| alternative | ✅ | — | `boolean`, `select`, `fields/` | — |
| cyberpunk | ✅ + SCSS | ✅ completo | `card`, `menu_item`, `select` | `main_menu`, `user_menu` |
| high-contrast | ✅ | — | `card` | — |
| vintage | ✅ | — | — | — |

