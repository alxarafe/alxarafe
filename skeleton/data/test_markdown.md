---
title: Alxarafe Showcase
subtitle: Experimentando con el motor de Markdown y componentes visuales.
---

<div class="markdown-showcase">

# Alxarafe: Potencia y Simplicidad

El framework está diseñado para ofrecer una experiencia de desarrollo fluida, combinando la robustez de PHP 8.2+ con un sistema de componentes flexible y extensible. Esta página demuestra las capacidades de renderizado de contenido mediante bloques dinámicos.

::: callout-info
## El propósito de esta demo
Aquí puedes probar cómo se comportan los diferentes bloques personalizados (Callouts, Grids, Cards) y ver cómo el CSS global aplica estilos "premium" de forma automática.
:::

## Características principales

:::: feature-grid
::: feature-card icon="fa-bolt"
## Rendimiento
Arquitectura optimizada para tiempos de respuesta mínimos. Sin sobrecarga innecesaria, solo el código que tu aplicación necesita para brillar.
:::

::: feature-card icon="fa-shield-halved"
## Seguridad
Protección integrada contra ataques comunes. Manejo seguro de sesiones, validación estricta y cumplimiento de estándares PSR.
:::

::: feature-card icon="fa-puzzle-piece"
## Modularidad
Crea módulos independientes y reutilizables fácilmente. Cada pieza del sistema se conecta de forma natural y escalable.
:::
::::

## Layouts Flexibles (Side-by-Side)

Con el sistema de `feature-grid` y `feature-item`, puedes crear disposiciones complejas que se adaptan a cualquier resolución de pantalla.

:::: feature-grid
::: feature-item
### Control total del diseño
Aprovecha las clases de Bootstrap vinculadas a Markdown para crear columnas personalizadas. Puedes indicar el ancho (`width="6"`) y el orden para alternar texto e imágenes.

### Inmutabilidad y Estructura
Aprende a definir estructuras de datos sólidas que mantengan la integridad de tu aplicación a lo largo del tiempo.
:::

::: feature-item
![Showcase Image](https://picsum.photos/seed/alxarafe-layout/800/600)
:::
::::

::: .mt-5.mb-5.text-center
![Centered Showcase](/alxarafe/assets/img/logo.png)
_Pie de foto opcional usando el logotipo local de Alxarafe._
:::

::: callout-note
## Nota técnica
El sistema utiliza **Parsedown** como motor base, extendido con filtros regex personalizados para soportar bloques de Quarto/Pandoc.
:::

## Ejemplo de código

```php
// Alxarafe: Renderizando componentes
echo MarkdownService::render($content);
```

::: callout-warn
## Advertencia
Esta página de previsualización se restablece periódicamente para mantener la integridad de la demostración.
:::

</div>
