# Admin Module Reference

The **Admin Module** (`CoreModules\Admin`) is the built-in management core of Alxarafe. It provides the essential infrastructure for authentication, user management, role-based access control (RBAC), and system configuration.

## Features

- **Authentication**: Secure login, profile management, and session handling.
- **User Management**: Creation, editing, and activation of users with custom preferences (language, theme, timezone).
- **RBAC**: Fine-grained permissions and role assignments.
- **System Config**: UI for managing `config.json` without direct file editing.
- **Module Management**: Activation/deactivation of modules and dependency resolution.
- **Database Tools**: UI for running migrations and managing seeders.
- **Audit Logs**: Automatic tracking of record changes.

---

## Controllers

### `AuthController`
Handles the public-facing authentication flow.
- **Actions**: `doLogin()`, `logout()`, `doRecoverPassword()`.
- **View**: Integrated with `login.blade.php`.

### `UserController`
Extends `ResourceController` to provide CRUD for the `User` model.
- **Auto-UI**: Uses `UserService::getFormPanels()` to assemble high-level UI panels.
- **Special Actions**: `doSetDefaultPage()` (sets the current URI as the user's entry point).
- **Security**: Ensures users can edit their own profile but only administrators can change roles or admin status.

### `RoleController`
Manages roles and their associated permissions.
- **Permissions**: Discovers all available controller methods across the framework to present a toggleable permission list.

### `ConfigController`
Provides a secure interface to `config.json`.
- **Validation**: Ensures database credentials and security keys are valid before saving.

### `ModuleController`
Lists all discovered modules and their metadata.
- **Attributes**: Reads `#[ModuleInfo]` and `#[RequireModule]` to present status and dependencies.

### `MigrationController`
UI wrapper for `Config::doRunMigrations()`.
- **Feedback**: Shows a detailed log of executed migration classes and their status.

---

## Models

### `User`
The primary identity model.
- **Fields**: `name`, `email`, `password`, `role_id`, `is_admin`, `language`, `timezone`, `theme`, `avatar`, `default_page`.
- **Traits**: Uses `DtoTrait` for API responses and `HasAuditLog` for change tracking.

### `Role` & `Permission`
Implements the RBAC schema.
- **Relation**: A Role `hasMany` Permissions.
- **Schema**:
    - `Role`: `id`, `name`, `label`, `active`.
    - `Permission`: `role_id`, `module`, `controller`, `action`.

### `AuditLog`
Stores serialized diffs of model changes.
- **Structure**: `user_id`, `event` (created/updated/deleted), `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`.

---

## Services

### `MenuManager`
The engine behind the attribute-driven navigation.
- **Method**: `getArrayMenu()` – Scans all controllers for `#[Menu]` attributes.
- **Filtering**: Automatically hides menu items if the user lacks the required `permission` defined in the attribute.

### `UserService`
Business logic for user operations.
- **`getFormPanels()`**: Uses Component Containers (`Panel`) and Fields (`Select2`, `Boolean`, etc.) to define the user edit complex UI programmatically.
- **`saveUser()`**: Handles password hashing, avatar upload processing, and preference persistence.

### `NotificationManager`
Internal messaging system for system alerts (e.g., successful migrations, login errors).

---

## Templates

The Admin module follows the standard directory structure but also includes specialized layout overrides:

- `Templates/page/login.blade.php`: The standalone login screen.
- `Templates/page/config.blade.php`: The tabbed configuration interface.
- `Templates/page/role_edit.blade.php`: The permission matrix UI.

Modules can override these templates by placing a file with the same name in `APP_PATH/Modules/Admin/Templates/page/`.
