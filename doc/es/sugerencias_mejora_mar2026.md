# Sugerencias de Mejora (Marzo 2026)

Este documento detalla las sugerencias de mejora para el framework Alxarafe tras la actualización a la v0.4.8.

## 🛠️ Mejoras Recientemente Implementadas

### Atributo `#[ExtraFieldsModel]`
- **Descripción**: Permite vincular explícitamente un modelo de datos con su clase de campos extra (*extrafields*).
- **Uso**: 
  ```php
  #[ExtraFieldsModel(modelClass: MyExtraFields::class, prefix: 'cf_', label: 'campos_pers')]
  class MyModel extends Model { ... }
  ```
- **Ventaja**: Elimina la rigidez del nombre de clase (antes debía terminar en `Extrafields` u `ExtraFields`) y permite configurar el prefijo de los campos en el formulario y la etiqueta de la sección de forma independiente por modelo.

---

## 🚀 Sugerencias de Mejora Futura

### 1. Migración de Webpack a Vite
- **Estado Actual**: Se utiliza Webpack para la compilación de TS/SCSS del framework y VitePress para la documentación.
- **Propuesta**: Unificar todo el stack de assets en Vite.
- **Beneficios**:
    - **Velocidad**: Vite es significativamente más rápido en desarrollo (HMR).
    - **Simplicidad**: Un solo motor de visualización y compilación para todo el framework.
    - **Modernidad**: Mejor soporte para módulos ES y carga bajo demanda.

### 2. Modularización de `ResourceTrait`
- **Estado Actual**: `ResourceTrait.php` es un trait monolítico de más de 1800 líneas que maneja listados, edición, metadatos, botones, etc.
- **Propuesta**: Fragmentar el trait en componentes reutilizables:
    - `HasListLogic`: Gestión de tablas y filtros.
    - `HasEditLogic`: Lógica de formularios y persistencia.
    - `HasMetadataScanner`: Autodetección de tipos y validaciones.
- **Beneficios**: Facilita el mantenimiento, permite a los controladores usar solo lo que necesiten y mejora la legibilidad.

### 3. Tipado Estricto de PHP 8.2+
- **Propuesta**: Adoptar las nuevas capacidades del lenguaje en el Core.
- **Acciones**:
    - Uso de propiedades `readonly` en clases de configuración.
    - Tipado de retorno obligatorio en todos los hooks de ciclo de vida (`setup`, `beforeEdit`, `afterSaveRecord`).
    - Parámetros tipados de forma estricta (`mixed` -> tipos reales).
- **Beneficios**: Código más robusto, detección de errores en tiempo de diseño y mejor experiencia para el desarrollador en el IDE.
