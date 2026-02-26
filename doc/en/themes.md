# Available Themes in Alxarafe

## Overview

Alxarafe includes a theme system that allows for full visual customization of the application. Themes are selected using the palette switcher (🎨 icon) in the user menu.

## Design Philosophy

Most themes are a **simple CSS change** or a component with different behavior (for example, changing a checkbox for a yes/no selector). The framework is simple by default, but **very flexible**.

To demonstrate this structural flexibility, **Cyberpunk** acts as the "black sheep": it relocates the user menu to the right margin (instead of the top), uses larger icons, and has a completely custom layout. All this is achieved through custom components and a layout override, without modifying the base framework.

> **Principle**: The sidebar menu is shown when menu options are available and hidden when they are not. No distinction is made between public and private at the layout level.

## Loading Mechanism

The active theme is determined with the following priority:

1. **`alx_theme` cookie** → set when changing the theme from the switcher.
2. **User preference** → `theme` field in the user record (if logged in).
3. **Configuration** → `config.json` → `main.theme`.
4. **Fallback** → `default`.

When a logged-in user changes the theme, it is automatically persisted in their user record.

The theme's CSS is loaded from `/themes/{name}/css/default.css` and Blade templates are resolved by cascade: first the theme's, then the module's, then the general ones.

## Included Themes

### 1. **Default** (System)
- **Style**: Modern, clean, minimalist.
- **Palette**: Light gray background (#f8f9fa), dark text, blue Bootstrap accents.
- **Typography**: System UI / Apple sans-serif.
- **Scope**: CSS only.

### 2. **Alternative**
- **Style**: Pastel, soft, friendly.
- **Palette**: Cream background (#FDFBF7), periwinkle blue, pale mint, pastel pink.
- **Typography**: Segoe UI / Tahoma.
- **Scope**: CSS + components (`boolean`, `select`, `fields/`).

### 3. **Cyberpunk** ⚡ (Structural flexibility demo)
- **Style**: 80s retrofuturistic, neon, dark.
- **Palette**: Black background (#0b0c10), neon cyan (#66fcf1), teal (#45a29e).
- **Typography**: Courier New (monospace).
- **Scope**: Full custom layout + extensive CSS + components (`card`, `menu_item`, `select`) + partials (`main_menu`, `user_menu`) + source SCSS.
- **Structural differences**: User menu on the right margin (not top), large icons, background grid overlay, glitch/scanline effects.

### 4. **High-Contrast**
- **Style**: Accessibility, high contrast.
- **Palette**: Black background (#000000), yellow text (#FFFF00), white borders, magenta highlight.
- **Typography**: Arial / Helvetica (110% base size).
- **Scope**: CSS + custom card component.

### 5. **Vintage**
- **Style**: Retro, classic, nostalgic.
- **Palette**: Parchment background (#f4ecd8), brown text (#4e342e), coffee accents (#8d6e63).
- **Typography**: Georgia / Times New Roman (serif).
- **Scope**: CSS only.

## How to Create a New Theme

1. Create a `templates/themes/{my-theme}/` folder.
2. Create `css/default.css` with the theme styles.
3. (Optional) Override Blade components (e.g., `component/card.blade.php`, `form/boolean.blade.php`).
4. (Optional) For structural changes, override the full layout (`partial/layout/main.blade.php`).
5. Run `composer update` to publish assets to `public/themes/`.

## File Structure per Theme

| Theme | CSS | Custom Layout | Components | Partials |
|:---|:---:|:---:|:---:|:---:|
| default | ✅ | — | — | — |
| alternative | ✅ | — | `boolean`, `select`, `fields/` | — |
| cyberpunk | ✅ + SCSS | ✅ complete | `card`, `menu_item`, `select` | `main_menu`, `user_menu` |
| high-contrast | ✅ | — | `card` | — |
| vintage | ✅ | — | — | — |
