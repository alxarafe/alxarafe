# Gestión de Menús - Estado y Pendientes

Este documento registra el estado actual de la implementación del sistema de menús y las tareas pendientes para completar la arquitectura robusta.

**Fecha de actualización**: 2026-02-13

## 1. Estado Actual (Modo Runtime)

Debido a restricciones en el entorno de despliegue (Docker sin acceso directo para ejecutar `composer dump-autoload` en caliente), se ha implementado una solución **temporal basada en Runtime** que permite funcionalidad inmediata sin romper la aplicación.

### Componentes Funcionales
1.  **Atributo `#[Menu]`**:
    - Ubicación: `src/Core/Attribute/Menu.php`
    - Funcionalidad: Permite definir metadatos de menú en los controladores.
    - Estado: **Activo**. Copiado manualmente para evitar error de autoload.

2.  **Servicio `MenuManager` (Runtime)**:
    - Ubicación: `src/Modules/Admin/Service/MenuManager.php`
    - Funcionalidad: Escanea los controladores en cada petición (cached per request) buscando atributos `#[Menu]`.
    - Limitación: No lee de base de datos. No es persistente (no se pueden editar menús desde admin). Es más lento que la lectura de BD.

3.  **Integración en `AuthController`**:
    - Se ha añadido el atributo `#[Menu]` al método `doIndex` para mostrar "My Profile" en el menú de usuario.

4.  **Integración en Plantilla (`top_bar.blade.php`)**:
    - Se ha modificado para leer `header_user_menu` inyectado por `GenericController`.
    - **Fallback de Seguridad**: Si el sistema de menús falla, muestra directamente el usuario logueado (`Auth::$user`) hardcodeado en la plantilla.

### Componentes Desactivados / Revertidos
Para restaurar la estabilidad del sistema, se han eliminado los siguientes componentes que requerían regeneración del autoloader:
- `MenuSyncer.php`: El servicio que sincroniza a la BD.
- `SyncerInterface.php`: La interfaz contrato.
- `SysMenu` / `SysMenuItem`: Modelos Eloquent.
- Migraciones: `20260213202504_create_sys_menus_tables.php`.
- Test Unitario: `Tests/Unit/MenuSyncerTest.php`.

---

## 2. Tareas Pendientes (Roadmap)

Para completar la arquitectura "Code-First, Database-Cached" originalmente diseñada, se deben realizar los siguientes pasos cuando sea posible ejecutar comandos de mantenimiento en el servidor.

### A. Restauración de Infraestructura (Prioridad Alta)
- [ ] **Restaurar Migración**: Volver a crear y ejecutar `20260213202504_create_sys_menus_tables.php`.
- [ ] **Restaurar Modelos**: Recrear `SysMenu.php` y `SysMenuItem.php`.
- [ ] **Autoloader**: Ejecutar `composer dump-autoload` para registrar las nuevas clases correctamente.

### B. Implementación de Sincronización (Prioridad Media)
- [ ] **Crear `SyncerInterface`**: Definir el contrato estándar.
- [ ] **Implementar `MenuSyncer`**: Crear el servicio que lee los atributos `#[Menu]` y actualiza la tabla `sys_menu_items` (UPSERT).
- [ ] **Script de Despliegue**: Añadir llamada a `MenuSyncer::sync()` en el pipeline de despliegue o en un comando `sys:sync`.

### C. Transición a Modo Base de Datos (Prioridad Media)
- [ ] **Actualizar `MenuManager`**: Modificar `MenuManager::get()` para que lea de `SysMenuItem` (con caché) en lugar de escanear controladores en vivo.
- [ ] **Backend de Gestión**: Crear un controlador `MenuAdminController` para permitir a los administradores reordenar y editar ítems desde la UI.

### D. Optimización y Limpieza
- [ ] **Eliminar escaneo en tiempo real**: Una vez activo el modo BD, eliminar la lógica de `scanMenus()` de `MenuManager` para mejorar el rendimiento.
- [ ] **Tests**: Restaurar y ampliar `MenuSyncerTest`.

## 3. Notas Técnicas para el Desarrollador

Si necesitas editar los menús ahora mismo:
1.  Edita el controlador correspondiente (ej: `AuthController`).
2.  Añade o modifica el atributo `#[Menu(...)]`.
3.  El cambio será visible inmediatamente (gracias al modo Runtime), pero ten en cuenta que puede impactar ligeramente en el rendimiento.

---
**Importante**: No descomentar ni restaurar los archivos de la carpeta `src/Modules/Admin/Model` sin asegurar antes que se puede regenerar el mapa de clases de Composer, o la aplicación arrojará un "Class not found" fatal.
