# Esquema de Composición de Plantillas

Este documento proporciona un mapa visual y técnico de cómo se construyen las páginas en Alxarafe. Es fundamental para entender cómo crear nuevos temas o modificar la estructura global.

## 1. Jerarquía de Herencia (Cascade)

Alxarafe usa un sistema de "cebolla" donde cada archivo envuelve al anterior:

1.  **Vista del Controlador** (ej: `layout/list` o `page/login`)
    *   Define las secciones `@section('content')` y `@section('header_actions')`.
    *   Extiende de...
2.  **Layout Principal** (`partial/layout/main`)
    *   Define la estructura `<html>`, `<head>` y `<body>`.
    *   Incluye los parciales básicos (`head`, `body`, `footer`).
    *   Envuelve a...
3.  **Contenedor de Cuerpo** (`partial/body_standard` o `body_empty`)
    *   Divide el espacio en áreas funcionales (Menús, Contenido, Alertas).

---

## 2. Mapa Visual (Body Standard)

Cuando usas la estructura estándar (`partial/body_standard`), la página se compone así:

```text
+----------------------------------------------------------------------------------+
| main.blade.php (Estructura HTML base)                                            |
| +------------------------------------------------------------------------------+ |
| | head.blade.php (Metadatos, CSS, JS globales)                                 | |
| +------------------------------------------------------------------------------+ |
| | body_standard.blade.php                                                      | |
| | +--------------+-----------------------------------------------------------+ | |
| | | main_menu    | user_menu.blade.php (Top Bar: Reloj, Notif, Perfil)       | | |
| | | .blade.php   |                                                           | | |
| | | (Sidebar)    +-----------------------------------------------------------+ | |
| | |              | Título de la Página                                       | | |
| | |              | [Retroceder]  {header_actions}                            | | |
| | |              +-----------------------------------------------------------+ | |
| | |              | alerts.blade.php (Mensajes de error/éxito)                | | |
| | |              +-----------------------------------------------------------+ | |
| | |              |                                                           | | |
| | |              |                                                           | | |
| | |              |             @yield('content')                             | | |
| | |              |     (Aquí se inyecta la vista del controlador)            | | |
| | |              |                                                           | | |
| | |              |                                                           | | |
| | +--------------+-----------------------------------------------------------+ | |
| +------------------------------------------------------------------------------+ |
| | footer.blade.php (Scripts de cierre, Copyright)                               | |
| +------------------------------------------------------------------------------+ |
+----------------------------------------------------------------------------------+
```

---

## 3. Archivos Clave y su Función

| Archivo | Ubicación Recomendada | Propósito |
| :--- | :--- | :--- |
| **main.blade.php** | `partial/layout/` | Esqueleto HTML. Casi nunca se toca salvo para cambios estructurales profundos. |
| **head.blade.php** | `partial/` | Fuentes, CSS principal y scripts iniciales. |
| **body_standard.blade.php** | `partial/` | Define el "esqueleto" visual (dónde va el menú y dónde el contenido). |
| **main_menu.blade.php** | `partial/` | La barra lateral (Sidebar) con la navegación de módulos. |
| **user_menu.blade.php** | `partial/` | La barra superior (Top Bar). Contiene el reloj, notificaciones y menú de usuario. |
| **footer.blade.php** | `partial/` | JS de Bootstrap, jQuery y cierre de etiquetas. |

---

## 4. Personalización por Temas

Para crear un tema (ej: "DarkSide"):
1.  Creas la carpeta `templates/themes/DarkSide/`.
2.  Si quieres cambiar el Sidebar, copias `partial/main_menu.blade.php` a `templates/themes/DarkSide/partial/main_menu.blade.php` y lo editas.
3.  El sistema de Alxarafe detectará que estás en el tema "DarkSide" y preferirá tu versión a la que está en la carpeta general.

> **Regla de Oro**: Nunca edites los archivos dentro de `vendor/`. Siempre copia el archivo que quieras modificar a la carpeta `templates/` de tu aplicación manteniendo la misma ruta interna.
