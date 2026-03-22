# Component Workflow – API Reference

`Namespace: Alxarafe\Component\Workflow`

State machine components for managing entity status transitions.

---

## `StatusWorkflow`

**Source:** [StatusWorkflow.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Component/Workflow/StatusWorkflow.php)

Generic state machine implementation for managing entity lifecycle states (e.g., draft → published → archived).

### Key Methods

| Method | Signature | Description |
|---|---|---|
| `addTransition()` | `addTransition(StatusTransition $transition): self` | Registers an allowed transition. |
| `canTransition()` | `canTransition(string $from, string $to): bool` | Checks if a transition is valid. |
| `apply()` | `apply(Model $model, string $newStatus): bool` | Applies a transition to a model. |
| `getAvailableTransitions()` | `getAvailableTransitions(string $currentStatus): array` | Lists valid transitions from current state. |

### Example

```php
use Alxarafe\Component\Workflow\StatusWorkflow;
use Alxarafe\Component\Workflow\StatusTransition;

$workflow = new StatusWorkflow();
$workflow->addTransition(new StatusTransition('draft', 'published', 'Publish'));
$workflow->addTransition(new StatusTransition('published', 'archived', 'Archive'));
$workflow->addTransition(new StatusTransition('draft', 'deleted', 'Delete'));

if ($workflow->canTransition($order->status, 'published')) {
    $workflow->apply($order, 'published');
}
```

---

## `StatusTransition`

**Source:** [StatusTransition.php](file:///home/rsanjose/Desarrollo/Alxarafe/alxarafe/src/Core/Component/Workflow/StatusTransition.php)

Value object representing a single state transition.

### Constructor

```php
public function __construct(
    public string $from,    // Source status
    public string $to,      // Target status
    public string $label,   // Display label for the action
    public ?string $icon = null,       // Optional FontAwesome icon
    public ?string $permission = null  // Optional required permission
)
```
