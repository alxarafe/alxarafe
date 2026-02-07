<?php

namespace Alxarafe\Base\Controller;

use Alxarafe\Component\AbstractField;
use Alxarafe\Component\AbstractFilter;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * Class ResourceController
 *
 * Unified controller for Listing and Editing resources.
 *
 * - No ID provided -> List Mode
 * - ID provided -> Edit Mode
 */
abstract class ResourceController extends Controller
{
    // Modes
    public const MODE_LIST = 'list';
    public const MODE_EDIT = 'edit';

    public string $mode = self::MODE_LIST;

    /**
     * Define the primary model class for this controller.
     * Can return a single class name string, or an array for multiple tabs/models.
     *
     * Examples:
     * return \Plugins\my_plugin\Model\MyModel::class;
     * return ['tab1' => Model1::class, 'tab2' => Model2::class];
     *
     * @return string|array
     */
    abstract protected function getModelClass();

    /**
     * Define columns for the list view.
     * Returns an array of field names or field definitions.
     * If empty, can optionally auto-generate from model.
     *
     * @return array
     */
    protected function getListColumns(): array
    {
        return [];
    }

    /**
     * Define fields for the edit form.
     * Returns an array of field names or field definitions.
     *
     * @return array
     */
    protected function getEditFields(): array
    {
        return [];
    }

    /**
     * Define filters for the list view.
     *
     * @return array
     */
    protected function getFilters(): array
    {
        return [];
    }

    public ?string $recordId = null;

    /**
     * @var string|null Default Model Class (optional, for simple controllers)
     */
    protected ?string $modelClass = null;

    /**
     * @var array Configuration structure
     */
    protected array $structConfig = [
        'list' => [
            'tabs' => [],
            'head_buttons' => [],
            'row_actions' => [],
            'limit' => 50,
        ],
        'edit' => [
            'sections' => [],
            'head_buttons' => [],
            'actions' => [],
        ]
    ];

    /**
     * @var string Active tab identifier (List Mode)
     */
    protected string $activeTab = '';

    public function getActiveTab(): string
    {
        return $this->activeTab;
    }

    /**
     * @var int Current page/offset (List Mode)
     */
    protected int $offset = 0;

    /**
     * @var string Configuration JSON (Base64) passed to view.
     */
    public string $viewConfig = '';

    /**
     * Initial setup of the controller configuration.
     * Logic for default buttons (Code over Configuration).
     */
    protected function setup()
    {
        // 1. Generic "New" Button
        $this->addListButton(
            'new',
            'Nuevo',
            'fas fa-plus',
            'primary',
            'right',
            'url',
            // Uses class_name to build URL (e.g. index.php?page=clientes&id=new)
            'index.php?module=' . static::getModuleName() . '&controller=' . static::getControllerName() . '&id=new'
        );
    }

    /**
     * Main entry point.
     */
    protected function privateCore()
    {
        $this->detectMode();
        $this->buildConfiguration();

        $this->setup(); // Standard buttons
        $this->handleRequest();

        // If not an API/AJAX request, render the view
        if (!isset($_GET['ajax'])) {
            $this->renderView();
        } else {
            // If we are here, it means an AJAX request was sent but not handled by handleRequest
            // We return a JSON error instead of letting the framework fail trying to find a view
            $this->jsonResponse(['status' => 'error', 'error' => 'Unknown AJAX action: ' . htmlspecialchars($_GET['ajax'])]);
            exit;
        }
    }

    /**
     * Default action handler.
     */
    public function doIndex(): bool
    {
        $this->privateCore();
        return true;
    }

    /**
     * Builds the internal configuration array from the method returns.
     */
    protected function buildConfiguration()
    {
        $modelDefinition = $this->getModelClass();

        // --- 1. BUILD LIST CONFIG ---

        // Handle Model/Tabs Definition
        if (is_array($modelDefinition)) {
            // Multiple tabs defined in getModelClass
            foreach ($modelDefinition as $tabId => $modelClass) {
                // If value is array, it might contain title, etc. (future expansion)
                // For now assuming key=tabId, value=ModelClass
                $this->addListTab($tabId, ucfirst($tabId), $modelClass);
            }
            $defaultTab = array_key_first($modelDefinition);
        } else {
            // Single Model
            $this->modelClass = $modelDefinition;
            $defaultTab = 'general';
            $this->addListTab($defaultTab, 'General', $this->modelClass);
        }

        // Handle Columns
        $columns = [];
        if (method_exists($this, 'getListFields')) {
            $columns = $this->getListFields();
        } elseif (method_exists($this, 'getListColumns')) {
            $columns = $this->getListColumns();
        }

        if (empty($columns)) {
            $modelClass = $this->structConfig['list']['tabs'][$defaultTab]['model'] ?? null;
            if ($modelClass && class_exists($modelClass) && method_exists($modelClass, 'getFields')) {
                $columns = $this->convertModelFieldsToComponents($modelClass::getFields());
            }
        }

        if (!empty($columns)) {
            // If columns is a simple list, apply to default/active tab.
            // If it's a nested array with keys matching tabs?
            // Simplified: apply to the first/default tab if flat, or check structure.

            // Heuristic: Check if keys overlap with defined tabs
            $isTabsConfig = !empty(array_intersect_key($columns, $this->structConfig['list']['tabs']));

            if ($isTabsConfig) {
                foreach ($columns as $tabId => $cols) {
                    if (isset($this->structConfig['list']['tabs'][$tabId])) {
                        $this->setListColumns($cols, $tabId);
                    }
                }
            } else {
                $this->setListColumns($columns, $defaultTab);
            }
        } else {
            // TODO: Auto-scaffold columns if empty?
        }

        // Handle Filters
        $filters = $this->getFilters();
        foreach ($filters as $filter) {
            // Assuming filter objects or simplified arrays
            if ($filter instanceof AbstractFilter) {
                $this->addListFilter($defaultTab, $filter);
            }
        }

        // --- 2. BUILD EDIT CONFIG ---

        $fields = $this->getEditFields();
        if (empty($fields)) {
            $modelClass = $this->structConfig['list']['tabs'][$defaultTab]['model'] ?? null;
            if ($modelClass && class_exists($modelClass) && method_exists($modelClass, 'getFields')) {
                $fields = $this->convertModelFieldsToComponents($modelClass::getFields());
            }
        }

        if (!empty($fields)) {
            // Similar heuristic for sections could apply
            $defaultSection = 'main';
            $this->addEditSection($defaultSection, 'General');
            $this->setEditFields($fields, $defaultSection);
        }
    }

    /**
     * Converts Model::getFields() metadata into UI Components.
     *
     * @param array $modelFields
     * @return array
     */
    protected function convertModelFieldsToComponents(array $modelFields): array
    {
        $components = [];

        foreach ($modelFields as $fieldData) {
            $field = $fieldData['field'] ?? '';
            if (empty($field)) continue;

            // Skip internal fields
            if (in_array($field, ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                continue;
            }

            $label = $fieldData['label'] ?? ucfirst($field);
            $type = $fieldData['genericType'] ?? 'text';
            $dbType = $fieldData['dbType'] ?? '';

            $options = [
                'required' => $fieldData['required'] ?? false,
                'readonly' => ($field === 'id' || $field === 'created_at' || $field === 'updated_at'),
            ];

            // Map Max Length
            if (!empty($fieldData['length']) && is_numeric($fieldData['length'])) {
                $options['maxlength'] = (int)$fieldData['length'];
            }

            // Handle Default Logic
            if (isset($fieldData['default'])) {
                $options['default_value'] = $fieldData['default'];
            }

            switch ($type) {
                case 'boolean':
                    $components[] = new \Alxarafe\Component\Fields\Boolean($field, $label, $options);
                    break;
                case 'date':
                    $components[] = new \Alxarafe\Component\Fields\Date($field, $label, $options);
                    break;
                case 'datetime':
                    $components[] = new \Alxarafe\Component\Fields\DateTime($field, $label, $options);
                    break;
                case 'time':
                    $components[] = new \Alxarafe\Component\Fields\Time($field, $label, $options);
                    break;
                case 'integer':
                    // Integer Logic
                    if (str_contains($dbType, 'unsigned')) {
                        $options['min'] = 0;
                    }
                    $components[] = new \Alxarafe\Component\Fields\Integer($field, $label, $options);
                    break;
                case 'decimal':
                    // Decimal Logic
                    if (str_contains($dbType, 'unsigned')) {
                        $options['min'] = 0;
                    }
                    $components[] = new \Alxarafe\Component\Fields\Decimal($field, $label, $options);
                    break;
                case 'textarea':
                    $options['multiline'] = true;
                    $components[] = new \Alxarafe\Component\Fields\Textarea($field, $label, $options);
                    break;

                // Fallback for number if somehow reaches here (deprecated generic)
                case 'number':
                    $options['type'] = 'number';
                    $components[] = new \Alxarafe\Component\Fields\Decimal($field, $label, $options);
                    break;

                default:
                    $components[] = new \Alxarafe\Component\Fields\Text($field, $label, $options);
                    break;
            }
        }

        return $components;
    }

    /**
     * Detects if we are in List or Edit mode based on request.
     */
    protected function detectMode()
    {
        // Check for ID in GET or POST
        $this->recordId = $_GET['id'] ?? $_POST['id'] ?? $_GET['code'] ?? null;

        if ($this->recordId) {
            $this->mode = self::MODE_EDIT;
        } else {
            $this->mode = self::MODE_LIST;
        }
    }

    /**
     * Handle incoming requests.
     */
    protected function handleRequest()
    {
        // Common params
        if (isset($_GET['offset'])) {
            $this->offset = (int)$_GET['offset'];
        }

        // List Mode Handler
        if ($this->mode === self::MODE_LIST) {
            $this->activeTab = $_GET['tab'] ?? array_key_first($this->structConfig['list']['tabs'] ?? []) ?? '';

            if (isset($_GET['ajax']) && $_GET['ajax'] === 'get_data') {
                $this->jsonResponse($this->fetchListData($this->activeTab));
                exit;
            }
        }

        // Edit Mode Handler
        if ($this->mode === self::MODE_EDIT) {
            // Handle save, delete, etc.
            if (isset($_GET['ajax']) && $_GET['ajax'] === 'get_record') {
                $this->jsonResponse($this->fetchRecordData());
                exit;
            }
            // Support both POST action and AJAX param for save
            if ((isset($_POST['action']) && $_POST['action'] === 'save') || (isset($_GET['ajax']) && $_GET['ajax'] === 'save_record')) {
                $this->saveRecord();
            }
        }
    }

    // --- Configuration Methods ---

    /**
     * Add a button to the List View Header.
     */
    protected function addListButton(string $name, string $label, string $icon, string $type = 'primary', string $location = 'right', string $action = 'url', string $target = '')
    {
        $this->structConfig['list']['head_buttons'][] = [
            'name' => $name,
            'label' => $label,
            'icon' => $icon,
            'type' => $type,
            'location' => $location, // 'left' or 'right'
            'action' => $action, // 'url', 'js', 'modal'
            'target' => $target
        ];
    }

    /**
     * Add a button to the Edit View Header.
     */
    protected function addEditButton(string $name, string $label, string $icon, string $type = 'secondary', string $location = 'right', string $action = 'url', string $target = '')
    {
        $this->structConfig['edit']['head_buttons'][] = [
            'name' => $name,
            'label' => $label,
            'icon' => $icon,
            'type' => $type,
            'location' => $location,
            'action' => $action,
            'target' => $target
        ];
    }

    /**
     * Add a row action button (for each row in list).
     */
    protected function addRowAction(string $name, string $label, string $icon, string $action = 'url')
    {
        $this->structConfig['list']['row_actions'][] = [
            'name' => $name,
            'label' => $label,
            'icon' => $icon,
            'action' => $action
        ];
    }

    /**
     * Add a tab for List Mode.
     */
    protected function addListTab(string $id, string $title, string $modelClassName, array $conditions = [])
    {
        $this->structConfig['list']['tabs'][$id] = [
            'title' => $title,
            'model' => $modelClassName,
            'columns' => [],
            'filters' => [],
            'conditions' => $conditions // Key-Value pairs e.g. ['activo' => 1]
        ];

        if (empty($this->activeTab)) {
            $this->activeTab = $id;
        }
    }

    /**
     * Add a column to a List Tab.
     *
     * @param string $tabId
     * @param string|AbstractField $fieldOrColumn
     * @param string $label (Deprecated if using AbstractField)
     * @param string $type (Deprecated if using AbstractField)
     * @param array $options (Deprecated if using AbstractField)
     */
    protected function addListColumn(string $tabId, $fieldOrColumn, string $label = '', string $type = 'text', array $options = [])
    {
        if (!isset($this->structConfig['list']['tabs'][$tabId])) {
            return;
        }

        if ($fieldOrColumn instanceof AbstractField) {
            $this->structConfig['list']['tabs'][$tabId]['columns'][] = $fieldOrColumn;
        } else {
            // Legacy support
            $this->structConfig['list']['tabs'][$tabId]['columns'][] = array_merge([
                'field' => $fieldOrColumn,
                'label' => $label,
                'type' => $type,
                'visible' => true,
            ], $options);
        }
    }

    /**
     * Add a section for Edit Mode.
     */
    protected function addEditSection(string $id, string $title)
    {
        $this->structConfig['edit']['sections'][$id] = [
            'title' => $title,
            'fields' => [],
        ];
    }

    /**
     * Add a field to an Edit Section.
     *
     * @param string $sectionId
     * @param string|AbstractField $fieldOrObject
     * @param string $label (Deprecated if using AbstractField)
     * @param string $type (Deprecated if using AbstractField)
     * @param array $options (Deprecated if using AbstractField)
     */
    protected function addEditField(string $sectionId, $fieldOrObject, string $label = '', string $type = 'text', array $options = [])
    {
        if (!isset($this->structConfig['edit']['sections'][$sectionId])) {
            return;
        }

        if ($fieldOrObject instanceof AbstractField) {
            $this->structConfig['edit']['sections'][$sectionId]['fields'][] = $fieldOrObject;
        } else {
            // Legacy support
            $this->structConfig['edit']['sections'][$sectionId]['fields'][] = array_merge([
                'field' => $fieldOrObject,
                'label' => $label,
                'type' => $type,
                'visible' => true,
            ], $options);
        }
    }

    // --- Data Fetching ---

    /**
     * Add a filter to a List Tab.
     *
     * @param string $tabId
     * @param AbstractFilter $filter
     */
    protected function addListFilter(string $tabId, AbstractFilter $filter)
    {
        if (!isset($this->structConfig['list']['tabs'][$tabId])) {
            return;
        }

        $this->structConfig['list']['tabs'][$tabId]['filters'][] = $filter;
    }

    // --- Global Search Configuration ---
    protected array $globalSearchFields = [];

    /**
     * Define fields for Global Search bar (param 'q').
     */
    protected function addGlobalSearch(array $fields)
    {
        $this->globalSearchFields = $fields;
    }

    protected function fetchListData(string $tabId): array
    {
        if (!isset($this->structConfig['list']['tabs'][$tabId])) {
            return ['error' => 'Invalid tab'];
        }

        $tabConfig = $this->structConfig['list']['tabs'][$tabId];
        $modelClass = $tabConfig['model'];
        /** @var \Alxarafe\Base\Model\Model $model */
        $model = new $modelClass();

        $limit = $this->structConfig['list']['limit'];

        // --- QUERY BUILDING ---
        $query = $model->newQuery();

        // Apply Tab Conditions (Implicit Filters)
        if (!empty($tabConfig['conditions'])) {
            foreach ($tabConfig['conditions'] as $key => $val) {
                if ($val === null) {
                    $query->whereNull($key);
                } elseif ($val === 'NOT NULL') {
                    $query->whereNotNull($key);
                } else {
                    $query->where($key, '=', $val);
                }
            }
        }

        // 0. Global Search
        $globalQuery = $_GET['q'] ?? null;
        if ($globalQuery && !empty($this->globalSearchFields)) {
            $query->where(function ($q) use ($globalQuery) {
                foreach ($this->globalSearchFields as $field) {
                    $q->orWhereRaw("LOWER({$field}) LIKE LOWER(?)", ["%{$globalQuery}%"]);
                }
            });
        }

        // 1. Apply Filters
        foreach ($tabConfig['filters'] as $filter) {
            $field = $filter->getField();

            if ($filter->getType() === 'date_range') {
                $paramFrom = 'filter_' . $tabId . '_' . $field . '_from';
                $paramTo = 'filter_' . $tabId . '_' . $field . '_to';
                $valFrom = $_GET[$paramFrom] ?? null;
                $valTo = $_GET[$paramTo] ?? null;

                if ($valFrom || $valTo) {
                    $filter->apply($query, ['from' => $valFrom, 'to' => $valTo]);
                }
            } else {
                $paramName = 'filter_' . $tabId . '_' . $field;
                $value = $_GET[$paramName] ?? null;

                if ($value !== null && $value !== '') {
                    $filter->apply($query, $value);
                }
            }
        }

        try {
            // Total count
            $total = $query->count();

            // Fetch Data
            $query->orderBy($model->primaryColumn(), 'DESC');
            $query->limit((int)$limit);
            $query->offset((int)$this->offset);

            $models = $query->get();
            return $this->processResultModels($models, $tabConfig['columns'], $total, $limit);
        } catch (\Exception $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    protected function processResultModels($models, $columns, $total, $limit): array
    {
        $results = [];
        foreach ($models as $item) {
            // Eloquent model instance
            $row = $item->toArray(); // Get basic attributes
            $processed = $row;

            foreach ($columns as $col) {
                if ($col instanceof AbstractField) {
                    $col = $col->jsonSerialize();
                }
                $field = $col['field'];

                // If field is present in array, use it.
                // UNLESS it's a computed accessor or relation that toArray doesn't include by default (appends).
                // But let's follow logic: if key exists, keep it? 
                // Original logic: "If field is already in row, good. If not, try to fetch from model."

                if (!array_key_exists($field, $row)) {
                    $val = null;

                    // 1. Try getter/accessor
                    // Eloquent uses getAttribute logic.
                    // But we also support custom get_X methods.
                    $getter = 'get_' . $field;
                    $getterCamel = 'get' . str_replace('_', '', ucwords($field, '_'));

                    if (method_exists($item, $getter)) {
                        $val = $item->$getter();
                    } elseif (method_exists($item, $getterCamel)) {
                        $val = $item->$getterCamel();
                    } else {
                        // Try attribute via Eloquent magic (mutators/relations)
                        // But if it wasn't in toArray(), it might be hidden or a relation.
                        try {
                            $val = $item->$field;
                        } catch (\Exception $e) {
                            $val = null;
                        }
                    }

                    // 2. Try Dot Notation (partner.nombre)
                    if ($val === null && strpos($field, '.') !== false) {
                        $parts = explode('.', $field);
                        $obj = $item;
                        foreach ($parts as $part) {
                            if (is_object($obj)) {
                                // Eloquent relations are accessible as properties
                                try {
                                    $obj = $obj->$part;
                                } catch (\Exception $e) {
                                    $obj = null;
                                }
                            } else {
                                $obj = null;
                            }
                        }
                        $val = $obj;
                    }

                    // Object to String conversion
                    if (is_object($val)) {
                        if (method_exists($val, 'get_name')) {
                            $val = $val->get_name();
                        } elseif (method_exists($val, '__toString')) {
                            $val = (string)$val;
                        }
                    }

                    $processed[$field] = $val;
                }

                // Boolean Casting Fix
                if (($col['type'] ?? '') === 'boolean' || ($col['component'] ?? '') === 'boolean') {
                    $processed[$field] = (bool)($processed[$field] ?? false);
                }
            }
            $results[] = $processed;
        }

        return [
            'data' => $results,
            'meta' => [
                'total' => $total,
                'limit' => $limit,
                'offset' => $this->offset,
            ]
        ];
    }

    protected function fetchRecordData(): array
    {
        if (!$this->recordId) {
            return ['error' => 'No ID provided'];
        }

        // Determine Model
        if (method_exists($this, 'get_model_class_name')) {
            $modelClass = $this->get_model_class_name();
        } else {
            $tabs = $this->structConfig['list']['tabs'] ?? [];
            $firstTab = reset($tabs);
            $modelClass = $firstTab['model'] ?? null;
        }

        if (!$modelClass || !class_exists($modelClass)) {
            return ['error' => 'Model configuration missing'];
        }

        // Handle New Record
        if ($this->recordId === 'new') {
            return [
                'id' => 'new',
                'data' => [],
                'meta' => [
                    'model' => $modelClass,
                    'is_new' => true
                ]
            ];
        }

        $model = new $modelClass();
        $data = $model::find($this->recordId);

        if (!$data) {
            return ['error' => 'Record not found'];
        }

        $values = $data->toArray();

        return [
            'id' => $this->recordId,
            'data' => $values,
            'meta' => [
                'model' => $modelClass
            ]
        ];
    }

    protected function saveRecord()
    {
        // Handle JSON Input
        $contentType = $_SERVER["CONTENT_TYPE"] ?? $_SERVER["HTTP_CONTENT_TYPE"] ?? '';
        $rawInput = file_get_contents('php://input');

        // Try to decode JSON if content type matches or if raw input looks like JSON
        if (stripos($contentType, 'application/json') !== false || ($rawInput && $rawInput[0] === '{')) {
            $json = json_decode($rawInput, true);
            if (is_array($json)) {
                $_POST = array_merge($_POST, $json);
            }
        }

        $data = $_POST['data'] ?? [];
        if (empty($data)) {
            $this->jsonResponse([
                'error' => 'No data provided',
                'debug_content_type' => $contentType,
                'debug_post' => $_POST,
                'debug_request' => $_REQUEST,
                'debug_raw' => $rawInput, // Return the actual captured input
                'debug_json_error' => json_last_error_msg()
            ]);
            exit;
        }

        // Determine Model
        if (method_exists($this, 'get_model_class_name')) {
            $modelClass = $this->get_model_class_name();
        } else {
            $tabs = $this->structConfig['list']['tabs'] ?? [];
            $firstTab = reset($tabs);
            $modelClass = $firstTab['model'] ?? null;
        }

        if (!$modelClass || !class_exists($modelClass)) {
            $this->jsonResponse(['error' => 'Model configuration missing']);
            exit;
        }

        $model = new $modelClass();

        if ($this->recordId && $this->recordId !== 'new') {
            $model = $modelClass::find($this->recordId);
            if (!$model) {
                $this->jsonResponse(['error' => 'Record not found']);
                exit;
            }
        }

        // Populate Model
        // Avoid overwriting ID and Timestamps with empty values from form
        $pkName = $model->getKeyName();
        foreach ($data as $key => $value) {
            if (($key === $pkName || $key === 'created_at' || $key === 'updated_at') && empty($value)) {
                continue;
            }
            $model->$key = $value;
        }

        if ($model->save()) {
            $this->jsonResponse([
                'status' => 'success',
                'id' => $model->{$model->primaryColumn()},
                'data' => $model->toArray(),
                'message' => 'Record saved successfully'
            ]);
        } else {
            $errors = ['Error saving record'];
            if (method_exists($model, 'getResponseObject')) {
                $response = $model::getResponseObject();
                if (!empty($response->errors)) {
                    $errors = $response->errors;
                }
            }

            $this->jsonResponse([
                'status' => 'error',
                'error' => implode('; ', $errors),
                'errors' => $errors
            ]);
        }
        exit;
    }

    // --- View Rendering ---

    protected function renderView()
    {
        // Single view template that handles both modes via JS? or separate templates?
        // Ideally a Single Page App experience.
        $this->setDefaultTemplate('core/alxarafe_resource_view');

        // Pass configuration to View (Blade)
        $this->addVariable('config', $this->structConfig);

        $themeManager = new \Alxarafe\Base\Frontend\ThemeManager();
        $templates = array_merge($themeManager->getFieldTemplates(), $themeManager->getLayoutTemplates());

        $this->viewConfig = base64_encode(json_encode([
            'mode' => $this->mode,
            'recordId' => $this->recordId,
            'config' => $this->structConfig,
            'templates' => $templates
        ]));
    }


    /**
     * Simplified configuration for List Columns.
     * Supports associative array: ['field_name' => ['label' => '...', ...]]
     * or indexed array: ['field_name', 'field2']
     */
    protected function setListColumns(array $columns, string $tabId = '')
    {
        if (empty($tabId)) {
            $tabId = array_key_first($this->structConfig['list']['tabs'] ?? []) ?? 'default';
        }

        $modelClass = $this->structConfig['list']['tabs'][$tabId]['model'] ?? null;
        $metadata = [];
        if ($modelClass && class_exists($modelClass) && method_exists($modelClass, 'getFields')) {
            $metadata = $modelClass::getFields();
        }

        foreach ($columns as $key => $value) {
            // Case 1: Value is a Component Object (e.g. new Icon(...))
            if ($value instanceof AbstractField) {
                // Directly add the component. Metadata lookup is not needed as the object is already configured.
                $this->addListColumn($tabId, $value);
                continue;
            }

            // Case 2: Associative Array ['field_name' => ['options']]
            if (is_string($key)) {
                $field = $key;
                $options = is_array($value) ? $value : [];
            } // Case 3: Simple String ['field_name']
            else {
                $field = (string)$value;
                $options = [];
            }

            // Metadata Lookup
            $meta = $metadata[$field] ?? [];

            // Defaults from Metadata
            if (empty($options['label'])) {
                $options['label'] = $meta['comment'] ?? $meta['label'] ?? ucfirst($field);
            }
            if (empty($options['type'])) {
                $options['type'] = $meta['generictype'] ?? 'text';
            }

            // Transfer all metadata to options
            $options = array_merge($meta, $options);

            $this->addListColumn($tabId, $field, $options['label'], $options['type'], $options);
        }
    }

    /**
     * Simplified configuration for Edit Fields.
     */
    protected function setEditFields(array $fields, string $sectionId = 'main')
    {
        // For Edit Mode, we typically assume the primary model of the controller?
        // Or do we have a model per section? Usually one model per Edit View.
        $modelClass = $this->modelClass; // Fallback

        // Try to get model from first tab of list?? Or explicit?
        if (!$modelClass && !empty($this->structConfig['list']['tabs'])) {
            $modelClass = reset($this->structConfig['list']['tabs'])['model'] ?? null;
        }

        $metadata = [];
        if ($modelClass && class_exists($modelClass) && method_exists($modelClass, 'getFields')) {
            $metadata = $modelClass::getFields();
        }

        foreach ($fields as $key => $value) {
            // Case 1: Value is a Field Object (Unified or Legacy FormField)
            if (is_object($value) && ($value instanceof AbstractField)) {
                $this->addEditField($sectionId, $value);
                continue;
            }

            // Case 2: Associative or Simple String
            $field = is_string($key) ? $key : $value;
            $options = is_array($value) ? $value : [];

            $meta = $metadata[$field] ?? [];

            if (empty($options['label'])) {
                $options['label'] = $meta['comment'] ?? $meta['label'] ?? ucfirst($field);
            }
            if (empty($options['type'])) {
                $options['type'] = $meta['generictype'] ?? 'text';
            }

            // Transfer all metadata to options
            $options = array_merge($meta, $options);

            // Auto-detect required
            if (!isset($options['required'])) {
                if (!empty($meta['required']) || (isset($meta['empty']) && $meta['empty'] === 'NO')) {
                    $options['required'] = true;
                }
            }

            $this->addEditField($sectionId, $field, $options['label'], $options['type'], $options);
        }
    }

    #[\Override]
    protected function jsonResponse($data)
    {
        if (defined('ALX_TESTING')) {
            throw new \Alxarafe\Base\Testing\HttpResponseException($data);
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
