# Feedback y Mejoras desde Chascarrillo

Este documento registra las mejoras solicitadas, implementadas o identificadas durante el desarrollo de la aplicación **Chascarrillo**.

## 📅 Marzo 2026

### ✅ Configuración Extensible (v0.4.3)
- **Solicitud:** Permitir que las aplicaciones añadan sus propias pestañas de configuración sin modificar el core.
- **Implementación:**
    - `Config::registerSection(string $section, array $keys)` para registrar nuevas secciones.
    - `Config::getConfigStructure()` para obtener la estructura combinada (core + app).
    - `ConfigController::getPost()` adaptado para procesar secciones dinámicas.
- **Resultado:** Chascarrillo ahora puede gestionar sus propios ajustes de "Blog" y "Social" integrados en el panel de administración.

### ✅ Corrección de Prioridad de Rutas (v0.4.4 - Pendiente de release)
- **Problema:** El core del framework tenía prioridad sobre los módulos de la aplicación en el autodiscovery de rutas.
- **Cambio:** Se ha invertido el orden en `Routes::$search_routes` para que `Modules/` (App) sobreescriba a `CoreModules/` (Framework).
- **Impacto:** Permite que Chascarrillo sobreescriba controladores del core simplemente creando uno con el mismo nombre en su propia estructura.

### ✅ Seguridad: Visibilidad de Contraseña DB (v0.4.4 - Pendiente)
- **Problema:** En la pestaña de "Conexión", la contraseña de la base de datos era visible en el inspector de HTML durante la carga inicial.
- **Implementación:** Limpieza de `db.pass` en `ConfigController::getPost()` para asegurar que el registro enviado a la vista siempre viaje vacío. Se mantiene el soporte en `saveRecord()` para no sobrescribir si llega en blanco.

### ✅ Prioridad de Idioma y Cookies (v0.4.4 - Pendiente)
- **Problema:** Un usuario veía el sitio en alemán a pesar de tenerlo configurado en español. Esto se debía a que las cookies de `localhost` de otros proyectos tenían prioridad sobre la configuración del sitio cuando el usuario tenía su preferencia en "Default" (NULL en DB).
- **Corrección:** Se ha ajustado la prioridad en `WebDispatcher::run()`. Si el usuario está autenticado, las cookies se ignoran y se prioriza su perfil o la configuración global del sitio. Esto evita que cookies "huérfanas" de otros proyectos afecten al actual.

### ⏳ Traducciones Dinámicas en Tablas
- **Estado:** Identificado como deseable.
- **Descripción:** Facilitar que campos que vienen de base de datos (como tipos de domicilio o canales de contacto) se traduzcan automáticamente si el valor tiene un prefijo especial (ej. `#`).

---
Este registro ayuda a mantener la trazabilidad de la evolución del framework basada en el uso real.
