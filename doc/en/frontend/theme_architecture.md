# Theme Architecture & Asset Management

## Overview

In Alxarafe, theme definitions are centralized within the `templates/themes` directory of the core package (or module). This ensures that version control and updates are managed via Composer, while publicly accessible assets (CSS, JS, Images) are published to the web root (`public/themes`) during installation, update, or runtime execution if missing.

## Directory Structure

### Source (Development)
Theme assets reside alongside their Blade templates:
```
/src (or root)
  /templates
    /themes
      /default
        /css
          default.css
        /js
        /partial
          head.blade.php
      /alternative
        /css
          default.css
        /component
          ...
```

### Destination (Public)
Only static assets are published to the web server's public directory:
```
/public
  /themes
    /default
      /css
        default.css
    /alternative
      /css
        default.css
```

## Publication Mechanism

The `Alxarafe\Scripts\ComposerScripts` class handles synchronization. It scans `templates/themes` for specific asset directories (`css`, `js`, `assets`, `img`, `fonts`) and copies them to `public/themes`.

### Why this approach?
1.  **Encapsulation**: All theme resources (logic/views and styles) are kept together in the source.
2.  **Security**: PHP/Blade files remain outside the web root.
3.  **Maintainability**: Updates to the core package automatically update the public assets.
4.  **Docker Resilience**: If assets are missing in the `public` environment (e.g., due to Docker volume mounts), `index.php` detects the absence and triggers automatic publication.

## Usage

When creating a new theme:
1.  Create a folder in `templates/themes/{my-theme}`.
2.  Place your CSS in `templates/themes/{my-theme}/css/`.
3.  Run `composer update` or manually trigger the script.
4.  In your Blade layout, reference assets using the public path: `/themes/{my-theme}/css/style.css`.

## Auto-Publication in Development Environments
To facilitate development in containerized environments (Docker), the `index.php` entry point includes an existence check. If it detects that `themes` or `css` folders are missing in `public`, it automatically invokes `ComposerScripts::postUpdate` to regenerate them.
