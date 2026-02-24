# Template Composition Schema

This document provides a visual and technical map of how pages are built in Alxarafe. It is essential for understanding how to create new themes or modify the global structure.

## 1. Inheritance Hierarchy (Cascade)

Alxarafe uses an "onion" system where each file wraps the previous one:

1.  **Controller View** (e.g., `layout/list` or `page/login`)
    *   Defines the `@section('content')` and `@section('header_actions')` sections.
    *   Extends...
2.  **Main Layout** (`partial/layout/main`)
    *   Defines the `<html>`, `<head>`, and `<body>` structure.
    *   Includes basic partials (`head`, `body`, `footer`).
    *   Wraps...
3.  **Body Container** (`partial/body_standard` or `body_empty`)
    *   Divides the space into functional areas (Menus, Content, Alerts).

---

## 2. Visual Map (Body Standard)

When using the standard structure (`partial/body_standard`), the page is composed as follows:

```text
+----------------------------------------------------------------------------------+
| main.blade.php (Base HTML structure)                                             |
| +------------------------------------------------------------------------------+ |
| | head.blade.php (Metadata, global CSS, JS)                                    | |
| +------------------------------------------------------------------------------+ |
| | body_standard.blade.php                                                      | |
| | +--------------+-----------------------------------------------------------+ | |
| | | main_menu    | user_menu.blade.php (Top Bar: Clock, Notif, Profile)      | | |
| | | .blade.php   |                                                           | | |
| | | (Sidebar)    +-----------------------------------------------------------+ | |
| | |              | Page Title                                                | | |
| | |              | [Back]  {header_actions}                                  | | |
| | |              +-----------------------------------------------------------+ | |
| | |              | alerts.blade.php (Error/Success messages)                 | | |
| | |              +-----------------------------------------------------------+ | |
| | |              |                                                           | | |
| | |              |                                                           | | |
| | |              |             @yield('content')                             | | |
| | |              |     (Controller view is injected here)                    | | |
| | |              |                                                           | | |
| | |              |                                                           | | |
| | +--------------+-----------------------------------------------------------+ | |
| +------------------------------------------------------------------------------+ |
| | footer.blade.php (Closing scripts, Copyright)                                 | |
| +------------------------------------------------------------------------------+ |
+----------------------------------------------------------------------------------+
```

---

## 3. Key Files and Their Function

| File | Recommended Location | Purpose |
| :--- | :--- | :--- |
| **main.blade.php** | `partial/layout/` | HTML skeleton. Rarely touched except for deep structural changes. |
| **head.blade.php** | `partial/` | Fonts, main CSS, and initial scripts. |
| **body_standard.blade.php** | `partial/` | Defines the visual "skeleton" (where the menu and content go). |
| **main_menu.blade.php** | `partial/` | The Sidebar with module navigation. |
| **user_menu.blade.php** | `partial/` | The Top Bar. Contains the clock, notifications, and user menu. |
| **footer.blade.php** | `partial/` | Bootstrap JS, jQuery, and tag closing. |

---

## 4. Theme Customization

To create a theme (e.g., "DarkSide"):
1.  Create the folder `templates/themes/DarkSide/`.
2.  If you want to change the Sidebar, copy `partial/main_menu.blade.php` to `templates/themes/DarkSide/partial/main_menu.blade.php` and edit it.
3.  The Alxarafe system will detect that you are in the "DarkSide" theme and will prefer your version over the one in the general folder.

> **Golden Rule**: Never edit files inside `vendor/`. Always copy the file you want to modify to your application's `templates/` folder, maintaining the same internal path.
