# Theme System and Template Overriding

Alxarafe uses a theme system based on **cascading overrides** (Fallback System) of Blade templates. This model allows granular customization of the interface without needing to duplicate the entire codebase.

## Design Philosophy

The main goal is **total flexibility with minimum duplication**.

*   **Base Template (Default)**: Located in `templates/` (template root). It contains the complete and functional structure of the application by default. It doesn't belong to any specific "theme"; it is the visual core of the framework.
*   **Themes**: Located in `templates/themes/{theme_name}/`. They are sets of files that selectively **override** those in the base template.
*   **Implicit Inheritance**: If a theme does not contain a specific file (e.g., `partial/sidebar.blade.php`), the system automatically loads the equivalent file from the base template.

## Directory Structure

```
templates/
├── common/                 # Reusable base components and partials
│   ├── layout/
│   │   └── main.blade.php  # Default main layout
│   ├── partial/
│   │   ├── head.blade.php
│   │   └── sidebar.blade.php
│   └── component/
│       └── card.blade.php
│
└── themes/
    ├── cyberpunk/          # Custom "Cyberpunk" theme
    │   ├── partial/
    │   │   └── sidebar.blade.php  <-- Overwrites ONLY the base sidebar
    │   └── component/
    │       └── card.blade.php     <-- Overwrites ONLY the card component
    │
    └── my_minimal_theme/     # Theme with minimal changes
        └── partial/
            └── head.blade.php     <-- Only changes the head (e.g., CSS)
```

## Resolution Mechanism (WebDispatcher)

The framework resolves the template path in the following priority order (from highest to lowest):

1.  **Active Theme**: `templates/themes/{active_theme}/{file_path}`
2.  **Module (App)**: `src/Modules/{Module}/templates/{file_path}` (if applicable)
3.  **Base (Default)**: `templates/{file_path}`

### Flow Example

If the system requests rendering `partial.sidebar` and the active theme is `cyberpunk`:

1.  Search: `templates/themes/cyberpunk/partial/sidebar.blade.php`
    *   ✅ **Exists**: This file is rendered.
    *   ❌ **Does not exist**: Move to the next level.

2.  Search: `templates/common/partial/sidebar.blade.php` (Mapped base path)
    *   ✅ **Exists**: The base file is rendered.

This allows creating themes consisting solely of a custom CSS file (injected via `partial/head.blade.php`) or themes that radically change the HTML structure.

## JavaScript/TypeScript Customization

TypeScript code (`src/Frontend/ts`) generally remains theme-agnostic, as it handles business logic and behavior (AJAX, event handlers).

However, if a theme requires specific JS behavior (e.g., animations, exclusive widgets):
1.  A separate JS/TS file should be created for the theme.
2.  Inject it into the overridden `partial/head.blade.php` or `partial/footer.blade.php` template of the theme.
3.  Avoid modifying the core `resource.ts` for purely visual changes.

## Advantages

1.  **Maintainability**: Updates to the base template automatically propagate to all themes, except for files that they have explicitly overridden.
2.  **Lightweight**: A new theme can be as simple as a single folder with a single modified file.
3.  **Organization**: Clear separation between "what the system is" and "what is cosmetic".
