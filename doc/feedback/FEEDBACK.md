# 📢 Cómo enviar feedback al core de Alxarafe

Este documento explica cómo las aplicaciones que usan Alxarafe como dependencia
pueden enviar propuestas de mejora, reportes de bugs y sugerencias al equipo del core.

## Flujo resumido

```
Tu App                          Alxarafe Core
─────                           ──────────────
1. Crea .yml en                 
   .alxarafe/feedback/          
                                2. Ejecuta: composer collect-feedback
                                3. Revisa y actualiza registry.yml
                                4. Publica estado en changelog.yml
5. Recibe changelog.yml         
   vía composer update          
```

## Paso a paso

### 1. Crear el directorio de feedback en tu app

```bash
mkdir -p .alxarafe/feedback
```

### 2. Copiar la plantilla

Copia la plantilla desde el core:

```bash
cp vendor/alxarafe/alxarafe/doc/feedback/proposal_template.yml \
   .alxarafe/feedback/001-mi-propuesta.yml
```

### 3. Rellenar la propuesta

Edita el fichero `.yml` con los datos de tu propuesta. Los campos obligatorios son:

| Campo         | Descripción                                    |
|:------------- |:---------------------------------------------- |
| `id`          | Identificador único dentro de tu app           |
| `title`       | Título descriptivo y conciso                   |
| `app`         | Nombre de tu aplicación                        |
| `date`        | Fecha de creación (YYYY-MM-DD)                 |
| `priority`    | `high`, `medium` o `low`                       |
| `category`    | `feature`, `bugfix`, `improvement`, `breaking` |
| `description` | Descripción detallada del problema/necesidad   |
| `use_case`    | Caso de uso real en tu aplicación              |

### 4. Hacer commit

```bash
git add .alxarafe/feedback/001-mi-propuesta.yml
git commit -m "feedback: propuesta de mejora para Alxarafe"
```

### 5. Consultar el estado

Después de un `composer update`, revisa:

```
vendor/alxarafe/alxarafe/doc/feedback/changelog.yml
```

Cada entrada tendrá un `status`:

| Estado         | Significado                          |
|:-------------- |:------------------------------------ |
| `received`     | Recibida, pendiente de revisión      |
| `accepted`     | Aprobada para implementación         |
| `rejected`     | Rechazada (ver campo `response`)     |
| `deferred`     | Aplazada para versión futura         |
| `implemented`  | Implementada en el core              |
| `released`     | Incluida en una release publicada    |

## Convención de nombres

```
.alxarafe/feedback/NNN-titulo-corto.yml
```

- `NNN`: número secuencial de 3 dígitos (001, 002, ...)
- `titulo-corto`: descripción breve en kebab-case

## Ejemplo

```yaml
id: "001"
title: "Renderizado automático de botones de Workflow"
app: "workframe"
author: "rsanjose"
date: "2026-03-03"
priority: "high"
category: "feature"
affects:
  - "ResourceController"
  - "HasWorkflow"
description: |
  El ResourceController debería detectar automáticamente si el modelo
  usa el trait HasWorkflow y renderizar los botones de transición.
use_case: |
  En workframe, cada modelo con workflow requiere código duplicado
  en el controlador para mostrar los botones.
```

## Preguntas frecuentes

**¿Necesito acceso al repositorio del core?**
No. Las propuestas viven en tu propio repositorio.

**¿Cómo llega mi propuesta al core?**
El mantenedor del core ejecuta periódicamente `composer collect-feedback`
que escanea las apps satélite del workspace.

**¿Puedo proponer cambios breaking?**
Sí, usa `category: "breaking"` y explica el impacto en `description`.
