# Menu Management - Status and Pending Items

This document records the current status of the menu system implementation and the pending tasks to complete the robust architecture.

**Update Date**: 2026-02-13

## 1. Current Status (Runtime Mode)

Due to deployment environment restrictions (Docker without direct access to run `composer dump-autoload` in real-time), a **temporary Runtime-based** solution has been implemented that allows immediate functionality without breaking the application.

### Functional Components
1.  **`#[Menu]` Attribute**:
    - Location: `src/Core/Attribute/Menu.php`
    - Functionality: Allows defining menu metadata in controllers.
    - Status: **Active**. Manually copied to avoid autoload errors.

2.  **`MenuManager` Service (Runtime)**:
    - Location: `src/Modules/Admin/Service/MenuManager.php`
    - Functionality: Scans controllers on each request (cached per request) for `#[Menu]` attributes.
    - Limitation: Does not read from the database. It is not persistent (menus cannot be edited from admin). It is slower than database reading.

3.  **Integration in `AuthController`**:
    - The `#[Menu]` attribute has been added to the `doIndex` method to show "My Profile" in the user menu.

4.  **Template Integration (`top_bar.blade.php`)**:
    - Modified to read `header_user_menu` injected by `GenericController`.
    - **Security Fallback**: If the menu system fails, it directly shows the logged-in user (`Auth::$user`) hardcoded in the template.

### Deactivated / Reverted Components
To restore system stability, the following components that required autoloader regeneration have been removed:
- `MenuSyncer.php`: The service that synchronizes with the DB.
- `SyncerInterface.php`: The contract interface.
- `SysMenu` / `SysMenuItem`: Eloquent models.
- Migrations: `20260213202504_create_sys_menus_tables.php`.
- Unit Test: `Tests/Unit/MenuSyncerTest.php`.

---

## 2. Pending Tasks (Roadmap)

To complete the "Code-First, Database-Cached" architecture originally designed, the following steps must be taken when it is possible to run maintenance commands on the server.

### A. Infrastructure Restoration (High Priority)
- [ ] **Restore Migration**: Re-create and run `20260213202504_create_sys_menus_tables.php`.
- [ ] **Restore Models**: Recreate `SysMenu.php` and `SysMenuItem.php`.
- [ ] **Autoloader**: Run `composer dump-autoload` to correctly register the new classes.

### B. Synchronization Implementation (Medium Priority)
- [ ] **Create `SyncerInterface`**: Define the standard contract.
- [ ] **Implement `MenuSyncer`**: Create the service that reads `#[Menu]` attributes and updates the `sys_menu_items` table (UPSERT).
- [ ] **Deployment Script**: Add a call to `MenuSyncer::sync()` in the deployment pipeline or in a `sys:sync` command.

### C. Database Mode Transition (Medium Priority)
- [ ] **Update `MenuManager`**: Modify `MenuManager::get()` to read from `SysMenuItem` (with caching) instead of scanning controllers live.
- [ ] **Management Backend**: Create a `MenuAdminController` to allow administrators to reorder and edit items from the UI.

### D. Optimization and Cleanup
- [ ] **Remove real-time scanning**: Once DB mode is active, remove the `scanMenus()` logic from `MenuManager` to improve performance.
- [ ] **Tests**: Restore and expand `MenuSyncerTest`.

## 3. Technical Notes for the Developer

If you need to edit menus right now:
1.  Edit the corresponding controller (e.g., `AuthController`).
2.  Add or modify the `#[Menu(...)]` attribute.
3.  The change will be immediately visible (thanks to Runtime mode), but keep in mind that it may slightly impact performance.

---
**Important**: Do not uncomment or restore files from the `src/Modules/Admin/Model` folder without first ensuring that the Composer class map can be regenerated, or the application will throw a fatal "Class not found" error.
