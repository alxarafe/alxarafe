# Campos de Componentes – Referencia de API

`Namespace: Alxarafe\Component\Fields`

Componentes de campo para generación programática de formularios. Todos extienden `AbstractField`.

## `AbstractField` (abstract)

Clase base para todos los componentes de campo de formulario. Proporciona serialización JSON, renderizado Blade, botones de acción y visibilidad dependiente de módulo.

### Constructor

```php
public function __construct(string $field, string $label, array $options = [])
```

### Opciones Comunes

| Opción | Tipo | Descripción |
|---|---|---|
| `required` | `bool` | Campo obligatorio |
| `readonly` | `bool` | Solo lectura |
| `col` | `string` | Clase de columna Bootstrap (defecto: `'col-12'`) |
| `maxlength` | `int` | Longitud máxima (auto-enriquecida desde esquema BD) |
| `module` | `string` | Módulo requerido para visibilidad |

### Métodos Clave

| Método | Firma | Descripción |
|---|---|---|
| `getType()` | `abstract getType(): string` | Tipo del campo |
| `isVisible()` | `isVisible(): bool` | Verifica visibilidad por módulo |
| `addAction()` | `addAction(string $icon, string $onclick, ...): self` | Añade botón de acción |
| `render()` | `render(array $extraData = []): string` | Renderiza a HTML vía Blade |

## Tipos de Campo

| Tipo | Clase | Uso |
|---|---|---|
| Texto | `Text` | `new Text('name', 'Nombre')` |
| Área de texto | `Textarea` | `new Textarea('desc', 'Descripción')` |
| Entero | `Integer` | `new Integer('qty', 'Cantidad', ['min' => 0])` |
| Decimal | `Decimal` | `new Decimal('price', 'Precio', ['step' => '0.01'])` |
| Booleano | `Boolean` | `new Boolean('active', 'Activo')` |
| Fecha | `Date` | `new Date('birth', 'Nacimiento')` |
| Fecha y Hora | `DateTime` | `new DateTime('created', 'Creado')` |
| Hora | `Time` | `new Time('start', 'Inicio')` |
| Selector | `Select` | `new Select('status', 'Estado', ['options' => ...])` |
| Selector mejorado | `Select2` | `new Select2('cat', 'Categoría', ['ajax_url' => ...])` |
| Lista de relación | `RelationList` | `new RelationList('orders', 'Pedidos')` |
| Oculto | `Hidden` | `new Hidden('token', 'Token')` |
| Texto estático | `StaticText` | `new StaticText('info', 'Info')` |
| Icono | `Icon` | `new Icon('icon', 'Icono')` |
| Imagen | `Image` | `new Image('avatar', 'Avatar')` |
