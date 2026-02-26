# Themes and Templates System in Alxarafe

This document details how the Alxarafe framework's template system works, how Blade file paths are resolved, and how the application's appearance can be customized using themes and template overriding.

## 1. Folder Hierarchy and Template Resolution

Alxarafe uses a "fallback" (or cascade) system to locate template files (`.blade.php`). When the controller requests a view, the system searches the following locations, **in this exact order**. The first file found is the one used.

### 1.1. Custom Theme (Application and Package)

The system first checks if a specific version of the template exists for the active theme.
This allows for multiple appearances without modifying the core code.

1.  **Application Theme**: `[APP_ROOT]/templates/themes/[THEME]/`
    *   *Usage*: To define or modify a specific theme for this instance of the application.
2.  **Package Theme**: `vendor/alxarafe/alxarafe/templates/themes/[THEME]/`
    *   *Usage*: Predefined themes distributed with the framework (e.g., `default`, `cyberpunk`).

### 1.2. Module Templates

If not found in the theme, the system searches within the folders of the corresponding module.

3.  **Application Module**: `[APP_ROOT]/Modules/[MODULE]/templates/`
    *   *Usage*: Override the views of a specific module (e.g., `Admin`, `User`) without touching the vendor.
4.  **Package Module**: `vendor/alxarafe/alxarafe/src/Modules/[MODULE]/templates/`
    *   *Usage*: Original location of core module views.

### 1.3. General Templates

If the view is not specific to a theme or a module, it searches the general template folders.

5.  **Global Application Templates**: `[APP_ROOT]/templates/`
    *   *Usage*: Global changes affecting the entire application are defined here (e.g., changing `layout/main.blade.php` for everyone). **This is the recommended folder for general customizations.**
6.  **Global Package Templates (Default)**: `vendor/alxarafe/alxarafe/templates/`
    *   *Usage*: **Framework base structure.** Contains default layouts, components, and partials. This folder is updated with `composer update` and **MUST NOT be modified manually**, as changes would be lost.

---

## 2. Default Template Structure

The default theme (`default`) and the base structure in `vendor/alxarafe/alxarafe/templates/` define the page composition.

### 2.1. Main File: `layout/main.blade.php`

This is the main HTML skeleton of the application. It defines the `<html>`, `<head>`, and `<body>` structure.
It loads the following main blocks:

*   **Header (`partial.head`)**: Metadata, CSS, and global Scripts.
*   **Body (`partial.body_standard` or `partial.body_empty`)**: Visual container.
*   **Footer (`partial.footer`)**: Page footer and closing scripts.

### 2.2. Content Blocks (`partial/body_standard.blade.php`)

Within the standard body, the screen is divided into functional areas. Although they may vary visually (top bar, side bar, off-canvas), they are conceptually defined as follows:

#### **A. Main Menu (`main_menu`)**
*   **Default file**: `templates/partial/main_menu.blade.php`.
*   **Function**: Contains the main navigation of the application (Modules, Controllers).

#### **B. Icon and Utility Menu (`user_menu`)**
*   **Default file**: `templates/partial/user_menu.blade.php`.
*   **Function**: User tools, notifications, theme switcher, language change, user profile.

#### **C. Central Content (`content`)**
*   **Definition**: `@yield('content')`
*   **Function**: This is where the specific view for each controller is injected.

### 2.3. Key Folders in `templates/` Summary

| Folder | Description |
| :--- | :--- |
| `layout/` | Base page structures (e.g., `column`, `row`, `container`). |
| `partial/` | Reusable fragments (`header`, `footer`, `alerts`, `main_menu`, `user_menu`). |
| `component/` | UI components (e.g., `card`, `modal`, `button`). |
| `form/` | Templates for automatic form rendering. |
| `page/` | Specific full pages (e.g., `migration`, `error`). |
| `core/` | Internal system views (e.g., automatic CRUD). |
| `themes/` | Folders for specific themes (`default`, `cyberpunk`, etc.). |

---

## 3. Theme CSS Loading

The active theme CSS is loaded dynamically in `partial/head.blade.php` using this priority:

1. **Cookie `alx_theme`** → set when the user selects a theme from the switcher
2. **Configuration** → `config.json` → `main.theme`
3. **Fallback** → `default`

The CSS file `<link href="/themes/{active_theme}/css/default.css">` is loaded automatically.

---

## 4. Available Themes

| Theme | Style | Key Colors | Font |
|:---|:---|:---|:---|
| **default** | Modern, clean | Light gray bg, dark text, blue accents | System UI |
| **alternative** | Pastel, soft | Cream bg, periwinkle blue, mint green | Segoe UI |
| **cyberpunk** | Dark, neon, futuristic | Black bg, cyan neon, teal | Courier New |
| **high-contrast** | Accessibility-focused | Black bg, yellow text, magenta highlights | Arial 110% |
| **vintage** | Retro, classic | Parchment bg, brown text, coffee accents | Georgia (serif) |

### Theme File Structure

| Theme | CSS | Custom Layout | Custom Components | Custom Partials |
|:---|:---:|:---:|:---:|:---:|
| default | ✅ | — | — | — |
| alternative | ✅ | — | `boolean`, `select`, `fields/` | — |
| cyberpunk | ✅ + SCSS | ✅ full layout | `card`, `menu_item`, `select` | `main_menu`, `user_menu` |
| high-contrast | ✅ | — | `card` | — |
| vintage | ✅ | — | — | — |

---

## 5. Assets (CSS/JS) Publishing

The `ComposerScripts` script is responsible for publishing static files (images, CSS, JS) from the package to the public folder.

*   **Source**: `vendor/alxarafe/alxarafe/assets` and `vendor/alxarafe/alxarafe/templates/themes/[THEME]/{css,js,assets,img,fonts}`
*   **Destination**: `public/alxarafe/assets` and `public/themes/[THEME]/`

**Important**: Unlike `.blade.php` templates (which are read dynamically based on the hierarchy), CSS/JS files **are physically copied** to `public`. If you need to modify the base CSS, you must do so by creating a new theme or overriding the file in your own asset structure, not by editing the files in `vendor`.

---

## 6. Creating a New Theme

1.  Create a folder in `templates/themes/{my-theme}/`
2.  Create `css/default.css` with the theme styles
3.  (Optional) Add Blade templates that override defaults (e.g., `partial/layout/main.blade.php`)
4.  (Optional) Add themed components (e.g., `component/card.blade.php`)
5.  Run `composer update` or the publish script to copy assets to `public/themes/`

