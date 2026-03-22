# Referencia del Módulo Admin

El **Módulo Admin** (`CoreModules\Admin`) es el núcleo de gestión integrado de Alxarafe. Proporciona la infraestructura esencial para la autenticación, gestión de usuarios, control de acceso basado en roles (RBAC) y la configuración del sistema.

## Funcionalidades

- **Autenticación**: Inicio de sesión seguro, gestión de perfiles y manejo de sesiones.
- **Gestión de Usuarios**: Creación, edición y activación de usuarios con preferencias personalizadas (idioma, tema, zona horaria).
- **RBAC**: Permisos detallados y asignación de roles.
- **Configuración del Sistema**: Interfaz de usuario para gestionar el archivo `config.json` sin edición directa de archivos.
- **Gestión de Módulos**: Activación/desactivación de módulos y resolución de dependencias.
- **Herramientas de Base de Datos**: Interfaz para ejecutar migraciones y gestionar seeders.
- **Logs de Auditoría**: Rastreo automático de cambios en los registros.

---

## Controladores

### `AuthController`
Gestiona el flujo de autenticación pública.
- **Acciones**: `doLogin()`, `logout()`, `doRecoverPassword()`.
- **Vista**: Integrado con `login.blade.php`.

### `UserController`
Extiende a `ResourceController` para proporcionar CRUD para el modelo `User`.
- **Interfaz Automática**: Utiliza `UserService::getFormPanels()` para ensamblar paneles UI de alto nivel.
- **Acciones Especiales**: `doSetDefaultPage()` (establece la URI actual como el punto de entrada predeterminado para el usuario).
- **Seguridad**: Garantiza que los usuarios puedan editar su propio perfil, pero que solo los administradores puedan cambiar roles o el estado de administrador.

### `RoleController`
Gestiona los roles y sus permisos asociados.
- **Permisos**: Descubre todos los métodos de controlador disponibles en todo el framework para presentar una lista de permisos activables.

### `ConfigController`
Proporciona una interfaz segura para el archivo `config.json`.
- **Validación**: Verifica que las credenciales de la base de datos y las claves de seguridad sean válidas antes de guardar.

### `ModuleController`
Lista todos los módulos descubiertos y sus metadatos.
- **Atributos**: Lee `#[ModuleInfo]` y `#[RequireModule]` para presentar el estado y las dependencias de los módulos.

### `MigrationController`
Interfaz de usuario para `Config::doRunMigrations()`.
- **Feedback**: Muestra un log detallado de las clases de migración ejecutadas y su estado.

---

## Modelos

### `User`
El modelo de identidad principal.
- **Campos**: `name`, `email`, `password`, `role_id`, `is_admin`, `language`, `timezone`, `theme`, `avatar`, `default_page`.
- **Traits**: Utiliza `DtoTrait` para respuestas de API y `HasAuditLog` para el seguimiento de cambios.

### `Role` y `Permission`
Implementan el esquema RBAC.
- **Relación**: Un Rol tiene muchos Permisos (`hasMany`).
- **Esquema**:
    - `Role`: `id`, `name`, `label`, `active`.
    - `Permission`: `role_id`, `module`, `controller`, `action`.

### `AuditLog`
Almacena diferencias (diffs) serializadas de los cambios en los modelos.
- **Estructura**: `user_id`, `event` (creado/actualizado/eliminado), `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`.

---

## Servicios

### `MenuManager`
El motor detrás de la navegación basada en atributos.
- **Método**: `getArrayMenu()` – Escanea todos los controladores para buscar atributos `#[Menu]`.
- **Filtrado**: Oculta automáticamente los elementos del menú si el usuario no tiene el permiso (`permission`) requerido definido en el atributo.

### `UserService`
Lógica de negocio para las operaciones de usuario.
- **`getFormPanels()`**: Utiliza contenedores de componentes (`Panel`) y campos (`Select2`, `Boolean`, etc.) para definir programáticamente la interfaz compleja de edición de usuarios.
- **`saveUser()`**: Gestiona el hash de contraseñas, el procesamiento de carga de avatares y la persistencia de preferencias.

### `NotificationManager`
Sistema de mensajería interna para alertas del sistema (ej. migraciones exitosas, errores de inicio de sesión).

---

## Plantillas (Templates)

El módulo Admin sigue la estructura de directorios estándar, pero también incluye sobrescrituras de diseño especializadas:

- `Templates/page/login.blade.php`: La pantalla de inicio de sesión independiente.
- `Templates/page/config.blade.php`: La interfaz de configuración con pestañas.
- `Templates/page/role_edit.blade.php`: La interfaz de la matriz de permisos.

Los módulos pueden sobrescribir estas plantillas colocando un archivo con el mismo nombre en `APP_PATH/Modules/Admin/Templates/page/`.
