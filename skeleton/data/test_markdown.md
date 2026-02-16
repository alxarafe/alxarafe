---
title: Test de Markdown Alxarafe
author: Antigravity
date: 2026-02-16
tags: [markdown, test, framework]
---

# Prueba de Markdown

Este es un documento de prueba para validar el nuevo `MarkdownService` del framework **Alxarafe**.

## Soporte de bloques especiales

Alxarafe ahora soporta bloques de aviso tipo Quarto/Pandoc:

::: callout-info
## Información Importante
Este es un bloque de información. Utiliza el icono `fas fa-info-circle`.
:::

::: callout-warn
## Advertencia
Cuidado con este bloque. Utiliza el icono `fas fa-exclamation-triangle`.
:::

::: callout-note
## Nota
Una simple nota para el lector. Utiliza el icono `fas fa-sticky-note`.
:::

::: callout-tip
## Consejo
Un consejo útil. Utiliza el icono predeterminado `fas fa-lightbulb`.
:::

## Formato estándar

También podemos usar formato estándar de Markdown:

- **Negrita** e *itálica*.
- [Enlaces a Google](https://www.google.com)
- Listas desordenadas:
  - Elemento A
  - Elemento B

### Código

```php
echo "Hola Alxarafe";
```
