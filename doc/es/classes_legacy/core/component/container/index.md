# Contenedores de Componentes – Referencia de API

`Namespace: Alxarafe\Component\Container`

Componentes contenedores para estructurar layouts de formularios.

## `Panel`
Agrupa campos en un panel colapsable.
```php
$panel = new Panel('info', 'Información de Contacto');
$panel->addChild(new Text('email', 'Email'));
```

## `Tab`
Pestaña individual dentro de un `TabGroup`. Soporta visibilidad condicional y badges.
```php
$tab = new Tab('dir', 'Direcciones', 'fas fa-map', $campos);
$tab->setBadgeCount(3);
```

## `TabGroup`
Renderiza múltiples `Tab` como interfaz de pestañas.

## `Row`
Contenedor de fila horizontal para campos lado a lado.
```php
$row = new Row('nombre_row');
$row->addChild(new Text('nombre', 'Nombre', ['col' => 'col-6']));
$row->addChild(new Text('apellido', 'Apellido', ['col' => 'col-6']));
```

## `Separator`
Separador visual (línea horizontal) entre secciones.

## `HtmlContent`
Inyecta contenido HTML arbitrario en el layout.
