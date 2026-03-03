# Propuestas de Mejoras — Próxima Versión (v0.4.8)

Este documento registra las funcionalidades propuestas para la evolución del framework Alxarafe. Los elementos se eliminarán de esta lista una vez hayan sido implementados y validados.

> **📢 ¿Usas Alxarafe en tu proyecto?**
> Envía tus propuestas de mejora a través del [Sistema de Feedback](feedback/FEEDBACK.md).
> Las propuestas se gestionan como ficheros YAML y puedes consultar su estado en el [changelog](feedback/changelog.yml).

## 🚀 Funcionalidades Propuestas

### 🛡️ Automatización de Workflow en la UI
- **Descripción**: Permitir que el `ResourceController` detecte automáticamente si un modelo usa el trait `HasWorkflow`.
- **Objetivo**: Renderizar automáticamente los botones de transición de estado en el formulario de edición (`edit mode`) sin intervención manual en el controlador.
- **Estado**: ✅ Implementado — detección automática en `setup()`, botones inyectados y transiciones vía `handleWorkflowTransition()`.

### 🏷️ Soporte para Atributo `#[ExtraFieldsModel]`
- **Descripción**: Implementar un atributo PHP 8 para los modelos que permita definir explícitamente la clase de "campos extra", su sufijo, prefijo en el formulario y etiqueta.
- **Objetivo**: Superar la limitación actual de buscar únicamente por el nombre `{Model}Extrafields` y dar más flexibilidad en el mapeo de bases de datos externas.
- **Estado**: ✅ Implementado — `detectExtrafieldsClass()` lee atributo `#[ExtraFieldsModel]` vía Reflection, con fallback por convención.

### 📢 Sistema de Comunicación Unificado
- **Descripción**: Crear un estándar de comunicación/notificación entre el núcleo de Alxarafe y las aplicaciones consumidoras (como `workframe`).
- **Objetivo**: Dinamizar la propagación de mejoras, avisos de actualizaciones y manejo de mensajes de sistema (`Messages`) de forma centralizada.
- **Estado**: ✅ Implementado — ver [doc/feedback/](feedback/FEEDBACK.md).

### 🧩 Estandarización de Alertas (`Messages`)
- **Descripción**: Refactorizar el uso de la clase `Lib\Messages` para que todas las acciones de transición y persistencia generen alertas visuales (`success`, `danger`, `warning`) consistentes en toda la suite.
- **Estado**: ✅ Implementado — `Messages::addMessage/addError` integrado en `saveRecord()` y `handleWorkflowTransition()`. Respuestas JSON incluyen `Messages::getMessages()`.
