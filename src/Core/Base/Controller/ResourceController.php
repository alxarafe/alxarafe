<?php

namespace Alxarafe\Base\Controller;

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

    protected string $mode = self::MODE_LIST;

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

    protected ?string $recordId = null;

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
            'index.php?page=' . $this->class_name . '&id=new'
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

        if (!empty($columns)) {
            // If columns is a simple list, apply to default/active tab.
            // If it's a nested array with keys matching tabs?
            // Simplified: apply to the first/default tab if flat, or check structure.

            // Heuristic: Check if keys overlap with defined tabs
            $isTabsConfig = !empty(array_intersect_key($columns, $this->config['list']['tabs']));

            if ($isTabsConfig) {
                foreach ($columns as $tabId => $cols) {
                    if (isset($this->config['list']['tabs'][$tabId])) {
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
        if (!empty($fields)) {
            // Similar heuristic for sections could apply
            $defaultSection = 'main';
            $this->addEditSection($defaultSection, 'General');
            $this->setEditFields($fields, $defaultSection);
        } else {
            // Auto-scaffold edit fields from model if empty?
        }
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
            $this->activeTab = $_GET['tab'] ?? array_key_first($this->config['list']['tabs'] ?? []) ?? '';

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
        $this->config['list']['head_buttons'][] = [
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
        $this->config['edit']['head_buttons'][] = [
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
        $this->config['list']['row_actions'][] = [
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
        $this->config['list']['tabs'][$id] = [
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
     * @param string|AbstractColumn $fieldOrColumn
     * @param string $label (Deprecated if using AbstractColumn)
     * @param string $type (Deprecated if using AbstractColumn)
     * @param array $options (Deprecated if using AbstractColumn)
     */
    protected function addListColumn(string $tabId, $fieldOrColumn, string $label = '', string $type = 'text', array $options = [])
    {
        if (!isset($this->config['list']['tabs'][$tabId])) {
            return;
        }

        if ($fieldOrColumn instanceof AbstractField) {
            $this->config['list']['tabs'][$tabId]['columns'][] = $fieldOrColumn;
        } else {
            // Legacy support
            $this->config['list']['tabs'][$tabId]['columns'][] = array_merge([
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
        $this->config['edit']['sections'][$id] = [
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
        if (!isset($this->config['edit']['sections'][$sectionId])) {
            return;
        }

        if ($fieldOrObject instanceof AbstractField || $fieldOrObject instanceof FormField) {
            $this->config['edit']['sections'][$sectionId]['fields'][] = $fieldOrObject;
        } else {
            // Legacy support
            $this->config['edit']['sections'][$sectionId]['fields'][] = array_merge([
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
        if (!isset($this->config['list']['tabs'][$tabId])) {
            return;
        }

        $this->config['list']['tabs'][$tabId]['filters'][] = $filter;
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
        if (!isset($this->config['list']['tabs'][$tabId])) {
            return ['error' => 'Invalid tab'];
        }

        $tabConfig = $this->config['list']['tabs'][$tabId];
        $modelClass = $tabConfig['model'];
        $model = new $modelClass();
        $table = $model::tableName();

        $limit = $this->config['list']['limit'];

        // --- QUERY BUILDING ---
        $whereParts = ['1=1'];

        // Apply Tab Conditions (Implicit Filters)
        if (!empty($tabConfig['conditions'])) {
            foreach ($tabConfig['conditions'] as $key => $val) {
                if ($val === null) {
                    $whereParts[] = "{$key} IS NULL";
                } elseif ($val === 'NOT NULL') {
                    $whereParts[] = "{$key} IS NOT NULL";
                } else {
                    $safeVal = addslashes($val);
                    $whereParts[] = "{$key} = '{$safeVal}'";
                }
            }
        }

        // 0. Global Search
        $globalQuery = $_GET['q'] ?? null;
        if ($globalQuery && !empty($this->globalSearchFields)) {
            $searchParts = [];
            foreach ($this->globalSearchFields as $field) {
                $safeQ = addslashes($globalQuery);
                $searchParts[] = "LOWER({$field}) LIKE LOWER('%{$safeQ}%')";
            }
            if (!empty($searchParts)) {
                $whereParts[] = '(' . implode(' OR ', $searchParts) . ')';
            }
        }

        // 1. Apply Filters
        foreach ($tabConfig['filters'] as $filter) {
            $field = $filter->getField();

            // Handle values.
            // For simple types: param = filter_{tab}_{field}
            // For ranges: params = filter_{tab}_{field}_from, ..._to

            if ($filter->getType() === 'date_range') {
                $paramFrom = 'filter_' . $tabId . '_' . $field . '_from';
                $paramTo = 'filter_' . $tabId . '_' . $field . '_to';
                $valFrom = $_GET[$paramFrom] ?? null;
                $valTo = $_GET[$paramTo] ?? null;

                if ($valFrom || $valTo) {
                    $filter->apply($whereParts, ['from' => $valFrom, 'to' => $valTo]);
                }
            } else {
                $paramName = 'filter_' . $tabId . '_' . $field;
                $value = $_GET[$paramName] ?? null;

                if ($value !== null && $value !== '') {
                    $filter->apply($whereParts, $value);
                }
            }
        }

        $whereSQL = implode(' AND ', $whereParts);

        // Total count (filters applied)
        $countSql = "SELECT COUNT(*) as total FROM " . $table . " WHERE " . $whereSQL;
        $countRes = DB::select($countSql);
        $total = $countRes[0]['total'] ?? 0;

        // Fetch Data
        $sql = "SELECT * FROM " . $table . " WHERE " . $whereSQL . " ORDER BY " . ($model->primaryColumn() ?? 'id') . " DESC";
        $rows = DB::selectLimit($sql, $limit, $this->offset);

        // Process rows to include computed columns / relations
        $results = [];
        foreach ($rows as $row) {
            $item = new $modelClass($row);
            $processed = $row; // Start with raw data

            foreach ($tabConfig['columns'] as $col) {
                if ($col instanceof AbstractField) {
                    $col = $col->jsonSerialize();
                }
                $field = $col['field'];

                // If field is already in row, good. If not, try to fetch from model.
                if (!array_key_exists($field, $row)) {
                    $val = null;

                    // 1. Try getter method (get_field or getField)
                    $getter = 'get_' . $field;
                    $getterCamel = 'get' . str_replace('_', '', ucwords($field, '_'));

                    if (method_exists($item, $getter)) {
                        $val = $item->$getter();
                    } elseif (method_exists($item, $getterCamel)) {
                        $val = $item->$getterCamel();
                    } elseif (property_exists($item, $field)) {
                        $val = $item->$field;
                    } // 2. Try Dot Notation (e.g. partner.nombre)
                    elseif (strpos($field, '.') !== false) {
                        $parts = explode('.', $field);
                        $obj = $item;
                        foreach ($parts as $part) {
                            $partGetter = 'get_' . $part;
                            if (is_object($obj)) {
                                if (method_exists($obj, $partGetter)) {
                                    $obj = $obj->$partGetter();
                                } elseif (isset($obj->$part)) {
                                    $obj = $obj->$part;
                                } else {
                                    // Try generic 'get_'$part if relation
                                    // This is naive, but might work for simple cases
                                    $obj = null;
                                }
                            } else {
                                $obj = null;
                            }
                        }
                        $val = $obj;
                    }

                    // If we found an object (like a related model), try to get a string representation
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
        $modelClass = null;
        if (method_exists($this, 'get_model_class_name')) {
            $modelClass = $this->get_model_class_name();
        } else {
            $tabs = $this->config['list']['tabs'] ?? [];
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
        $data = $model->get($this->recordId);

        if (!$data) {
            return ['error' => 'Record not found'];
        }

        $values = [];
        foreach ($data as $key => $val) {
            $values[$key] = $val;
        }

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
        $data = $_POST['data'] ?? [];
        if (empty($data)) {
            $this->jsonResponse(['error' => 'No data provided']);
            exit;
        }

        // Determine Model
        $modelClass = null;
        if (method_exists($this, 'get_model_class_name')) {
            $modelClass = $this->get_model_class_name();
        } else {
            $tabs = $this->config['list']['tabs'] ?? [];
            $firstTab = reset($tabs);
            $modelClass = $firstTab['model'] ?? null;
        }

        if (!$modelClass || !class_exists($modelClass)) {
            $this->jsonResponse(['error' => 'Model configuration missing']);
            exit;
        }

        $model = new $modelClass();

        if ($this->recordId && $this->recordId !== 'new') {
            $model = $model->get($this->recordId);
            if (!$model) {
                $this->jsonResponse(['error' => 'Record not found']);
                exit;
            }
        }

        // Populate Model
        // TODO: Validate allowed fields vs Config?
        foreach ($data as $key => $value) {
            if (property_exists($model, $key)) {
                $model->$key = $value;
            }
        }

        if ($model->save()) {
            $this->jsonResponse([
                'status' => 'success',
                'id' => $model->{$model->primaryColumn()},
                'data' => $model->getData(),
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
        $this->template = 'core/alxarafe_resource_view';

        $this->viewConfig = base64_encode(json_encode([
            'mode' => $this->mode,
            'recordId' => $this->recordId,
            'config' => $this->config,
            'templates' => $this->getFieldTemplates()
        ]));
    }

    private function getFieldTemplates(): array
    {
        $templates = [];
        $basePath = constant('BASE_PATH') . '/Templates/Component/Field';

        if (!is_dir($basePath)) {
            return $templates;
        }

        // Scan List Templates
        $listPath = $basePath . '/List';
        if (is_dir($listPath)) {
            $files = scandir($listPath);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..' || !str_ends_with($file, '.blade.php')) continue;

                $type = substr($file, 0, -10); // remove .blade.php
                $key = strtolower($type) . '_list';
                $templates[$key] = file_get_contents($listPath . '/' . $file);
            }
        }

        // Scan Edit Templates
        $editPath = $basePath . '/Edit';
        if (is_dir($editPath)) {
            $files = scandir($editPath);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..' || !str_ends_with($file, '.blade.php')) continue;

                $type = substr($file, 0, -10); // remove .blade.php
                $key = strtolower($type) . '_edit';
                $templates[$key] = file_get_contents($editPath . '/' . $file);
            }
        }

        return $templates;
    }


    /**
     * Simplified configuration for List Columns.
     * Supports associative array: ['field_name' => ['label' => '...', ...]]
     * or indexed array: ['field_name', 'field2']
     */
    protected function setListColumns(array $columns, string $tabId = '')
    {
        if (empty($tabId)) {
            $tabId = array_key_first($this->config['list']['tabs'] ?? []) ?? 'default';
        }

        $modelClass = $this->config['list']['tabs'][$tabId]['model'] ?? null;
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
        if (!$modelClass && !empty($this->config['list']['tabs'])) {
            $modelClass = reset($this->config['list']['tabs'])['model'] ?? null;
        }

        $metadata = [];
        if ($modelClass && class_exists($modelClass) && method_exists($modelClass, 'getFields')) {
            $metadata = $modelClass::getFields();
        }

        foreach ($fields as $key => $value) {
            // Case 1: Value is a Field Object (Unified or Legacy FormField)
            if (is_object($value) && ($value instanceof AbstractField || $value instanceof FormField)) {
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

            // Auto-detect required
            if (!isset($options['required'])) {
                if (!empty($meta['required']) || (isset($meta['empty']) && $meta['empty'] === 'NO')) {
                    $options['required'] = true;
                }
            }

            $this->addEditField($sectionId, $field, $options['label'], $options['type'], $options);
        }
    }

    protected function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
