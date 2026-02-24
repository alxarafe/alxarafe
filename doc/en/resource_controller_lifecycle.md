# ResourceController Lifecycle

The `ResourceController` is the base class for quickly creating CRUD controllers.
To allow flexibility without losing automation, it features a Hooks system.

## Execution Flow (Lifecycle)

When `doIndex()` (or any default action) is executed:

1.  **detectMode()**: Determines if it is List or Edit mode (based on GET/POST parameters).
2.  **beforeConfig()**: [HOOK] Executed before building the configuration. Useful for defining global variables.
3.  **buildConfiguration()**: Builds the structure of columns, fields, and tabs.
4.  **checkTableIntegrity()**: (Optional) Verifies that the table exists.
5.  **setup()**: Adds default buttons (New, Save).
6.  **Mode-Specific Hooks**:
    *   If LIST MODE -> **beforeList()**
    *   If EDIT MODE -> **beforeEdit()**
7.  **handleRequest()**: Processes the actual request (AJAX get_data, save, etc.).
8.  **renderView()**: Displays the Blade template.

## How to Use Hooks

### beforeEdit()
Use it to inject additional data into the edit view or change the default template.

```php
protected function beforeEdit()
{
    // Load extra data
    $extraData = MyModel::all();
    $this->addVariable('extraData', $extraData);
    
    // Change the template if you need a fully customized form
    $this->setDefaultTemplate('page/my_custom_edit');
}
```

### beforeList()
Use it to modify columns or filters dynamically based on the user or state.

```php
protected function beforeList()
{
    if ($this->user->is_superadmin) {
        $this->addListColumn('general', 'deleted_at', 'Deleted at');
    }
}
```
