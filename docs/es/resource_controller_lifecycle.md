# Ciclo de Vida del ResourceController

El `ResourceController` es la clase base para criar controladores CRUD rápidamente.
Para permitir flexibilidad sin perder la automatización, dispone de un sistema de Hooks.

## Flujo de Ejecución (Lifecycle)

Cuando se ejecuta `doIndex()` (o cualquier acción por defecto):

1.  **detectMode()**: Determina si es Listado o Edición (basado en parámetros GET/POST).
2.  **beforeConfig()**: [HOOK] Se ejecuta antes de construir la configuración. Útil para definir variables globales.
3.  **buildConfiguration()**: Construye la estructura de columnas, campos y pestañas.
4.  **checkTableIntegrity()**: (Opcional) Verifica que la tabla exista.
5.  **setup()**: Añade botones por defecto (Nuevo, Guardar).
6.  **Hooks Específicos de Modo**:
    *   Si es MODO LISTA -> **beforeList()**
    *   Si es MODO EDICIÓN -> **beforeEdit()**
7.  **handleRequest()**: Procesa la petición real (AJAX get_data, save, etc).
8.  **renderView()**: Muestra la plantilla Blade.

## Cómo Usar los Hooks

### beforeEdit()
Úsalo para inyectar datos adicionales a la vista de edición o cambiar la plantilla por defecto.

```php
protected function beforeEdit()
{
    // Cargar datos extra
    $extraData = MyModel::all();
    $this->addVariable('extraData', $extraData);
    
    // Cambiar la plantilla si necesitas un formulario totalmente personalizado
    $this->setDefaultTemplate('page/my_custom_edit');
}
```

### beforeList()
Úsalo para modificar las columnas o filtros dinámicamente según el usuario o estado.

```php
protected function beforeList()
{
    if ($this->user->is_superadmin) {
        $this->addListColumn('general', 'deleted_at', 'Borrado el');
    }
}
```
