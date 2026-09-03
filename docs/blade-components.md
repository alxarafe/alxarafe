# Blade anonymous components / Componentes anónimos Blade

## English

### Template precedence

Alxarafe resolves templates and anonymous Blade components in this order, from highest to lowest priority:

1. Application theme.
2. Package theme.
3. Application module.
4. Package module.
5. General application templates.
6. General package templates.

`WebDispatcher` supplies paths in this order and `Template` preserves it.

### Registration and resolution

`Template` registers as an anonymous-component root only a template path that contains a `component/` directory. Illuminate creates the internal namespace for that root. Alxarafe does not add manual hash namespaces or reuse the reserved `__components` namespace.
For compatibility, each such directory is registered in both established forms: the template root resolves names such as `component.card`, while its `component/` child resolves short names such as `form.input`.

When a new Blade factory is created, Alxarafe clears Illuminate's static component factory and anonymous-view cache. This prevents a component resolved by an earlier theme or path set from leaking into a later render.

### Consumer overrides and fallback

A consumer overrides a component by placing the same relative Blade file in a higher-priority template root. For example, an application-wide override for `<x-component.card>` belongs at `templates/component/card.blade.php`; a theme-specific override belongs at `templates/themes/{theme}/component/card.blade.php`.

If a higher-priority root does not contain the component, resolution continues through the ordered roots until the first matching file is found. Consumers do not need to copy the package component to use this fallback.

### Cache changes

Changing the configured theme or template paths creates a new Blade factory and resets component-resolution state automatically. Persistent compiled files remain separated by theme. During deployment, clear `var/cache/blade/` when replacing or moving Blade files so stale compiled templates cannot survive the release.

## Español

### Precedencia de plantillas

Alxarafe resuelve las plantillas y los componentes anónimos Blade en este orden, de mayor a menor prioridad:

1. Tema de la aplicación.
2. Tema del paquete.
3. Módulo de la aplicación.
4. Módulo del paquete.
5. Plantillas generales de la aplicación.
6. Plantillas generales del paquete.

`WebDispatcher` proporciona las rutas en este orden y `Template` lo conserva.

### Registro y resolución

`Template` registra como raíz de componentes anónimos únicamente una ruta de plantillas que contiene un directorio `component/`. Illuminate crea el namespace interno de esa raíz. Alxarafe no añade namespaces hash manuales ni reutiliza el namespace reservado `__components`.
Por compatibilidad, cada directorio se registra con las dos formas existentes: la raíz de plantillas resuelve nombres como `component.card`, mientras que su hijo `component/` resuelve nombres cortos como `form.input`.

Cuando se crea una nueva factoría Blade, Alxarafe limpia la factoría estática de componentes y la caché de vistas anónimas de Illuminate. Esto impide que un componente resuelto por un tema o conjunto de rutas anterior se filtre a un renderizado posterior.

### Overrides del consumidor y fallback

Un consumidor sobrescribe un componente colocando el mismo archivo Blade relativo en una raíz de plantillas de mayor prioridad. Por ejemplo, un override general de aplicación para `<x-component.card>` corresponde a `templates/component/card.blade.php`; un override específico de tema corresponde a `templates/themes/{theme}/component/card.blade.php`.

Si una raíz de mayor prioridad no contiene el componente, la resolución continúa por las raíces ordenadas hasta encontrar el primer archivo coincidente. Los consumidores no necesitan copiar el componente del paquete para utilizar este fallback.

### Cambios de caché

Cambiar el tema configurado o las rutas de plantillas crea una nueva factoría Blade y reinicia automáticamente el estado de resolución de componentes. Los archivos compilados persistentes permanecen separados por tema. Durante un despliegue, limpia `var/cache/blade/` cuando reemplaces o muevas archivos Blade para que no sobrevivan plantillas compiladas obsoletas a la publicación.
