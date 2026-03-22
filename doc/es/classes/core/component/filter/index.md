# Filtros de Componentes – Referencia de API

`Namespace: Alxarafe\Component\Filter`

Componentes de filtro para vistas de listado. Todos extienden `AbstractFilter`.

| Filtro | Clase | Uso |
|---|---|---|
| Texto libre | `TextFilter` | `new TextFilter('name', 'Buscar por Nombre')` |
| Selector | `SelectFilter` | `new SelectFilter('status', 'Estado', ['options' => ...])` |
| Selector mejorado | `Select2Filter` | `new Select2Filter('cat', 'Categoría', ['ajax_url' => ...])` |
| Autocompletar | `AutocompleteFilter` | `new AutocompleteFilter('city', 'Ciudad', ['source_url' => ...])` |
| Rango de fechas | `DateRangeFilter` | `new DateRangeFilter('created_at', 'Creado Entre')` |
| Relación | `RelationFilter` | `new RelationFilter('user_id', 'Usuario', ['model' => User::class])` |
