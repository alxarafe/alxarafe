# Workflow de Componentes – Referencia de API

`Namespace: Alxarafe\Component\Workflow`

Componentes de máquina de estados para gestionar transiciones de estado de entidades.

## `StatusWorkflow`

Implementación genérica de máquina de estados para gestionar estados del ciclo de vida de entidades.

### Métodos

| Método | Firma | Descripción |
|---|---|---|
| `addTransition()` | `addTransition(StatusTransition $t): self` | Registra transición permitida. |
| `canTransition()` | `canTransition(string $from, string $to): bool` | Verifica si transición es válida. |
| `apply()` | `apply(Model $model, string $newStatus): bool` | Aplica transición a un modelo. |
| `getAvailableTransitions()` | `getAvailableTransitions(string $current): array` | Lista transiciones válidas. |

### Ejemplo

```php
$workflow = new StatusWorkflow();
$workflow->addTransition(new StatusTransition('borrador', 'publicado', 'Publicar'));
$workflow->addTransition(new StatusTransition('publicado', 'archivado', 'Archivar'));

if ($workflow->canTransition($pedido->status, 'publicado')) {
    $workflow->apply($pedido, 'publicado');
}
```

## `StatusTransition`

Objeto valor representando una transición de estado.

```php
new StatusTransition(
    from: 'borrador',
    to: 'publicado',
    label: 'Publicar',
    icon: 'fas fa-check',
    permission: 'posts.publish'
)
```
