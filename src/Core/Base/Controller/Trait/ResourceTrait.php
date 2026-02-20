<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Base\Controller\Trait;

use Alxarafe\Base\Controller\Interface\ResourceInterface;
use Alxarafe\Component\AbstractField;
use Alxarafe\Component\Container\Panel;
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
trait ResourceTrait
{
    // Modes

    public string $mode = ResourceInterface::MODE_LIST;

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
     * @var array Relations to eager load (e.g. ['user', 'category'])
     */
    protected array $with = [];

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

        $this->beforeConfig();

        $this->buildConfiguration();
        $this->checkTableIntegrity();

        $this->setup(); // Standard buttons

        if ($this->mode === ResourceInterface::MODE_LIST) {
            $this->beforeList();
        } elseif ($this->mode === ResourceInterface::MODE_EDIT) {
            $this->beforeEdit();
        }

        $this->handleRequest();

        if (isset($_GET['ajax'])) {
            // If we are here, it means an AJAX request was sent but not handled by handleRequest
            // We return a JSON error instead of letting the framework fail trying to find a view
            $this->jsonResponse(['status' => 'error', 'error' => 'Unknown AJAX action: ' . htmlspecialchars($_GET['ajax'])]);
            exit;
        }

        // If not an API/AJAX request, render the view
        $this->renderView();
    }

    // --- Lifecycle Hooks ---

    /**
     * Hook called before building configuration.
     */
    protected function beforeConfig()
    {
}

    /**
     * Hook called before processing list mode logic.
     */
    protected function beforeList()
    {
}

    /**
     * Hook called before processing edit mode logic.
     */
    protected function beforeEdit()
    {
}

    /**
     * Hook called after a record is saved.
     * 
     * @param \Alxarafe\Base\Model\Model $model The saved model instance.
     * @param array $data The original submitted data.
     */
    protected function afterSaveRecord(\Alxarafe\Base\Model\Model $model, array $data)
    {
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
     * Handle Save action.
     * Routes to privateCore for detection and handling.
     */
    public function doSave(): bool
    {
        $this->privateCore();
        return true;
    }

    /**
     * Handle Delete action.
     */
    public function doDelete(): bool
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

        // Auto-scaffold if empty
        if (empty($fields)) {
            $modelClass = $this->structConfig['list']['tabs'][$defaultTab]['model'] ?? null;
            if ($modelClass && class_exists($modelClass) && method_exists($modelClass, 'getFields')) {
                $fields = $this->convertModelFieldsToComponents($modelClass::getFields());
            }
        }

        // Normalize to Tabs Structure
        $tabsConfig = [];
        if (!empty($fields)) {
            $isStructured = false;
            foreach ($fields as $v) {
                if (is_object($v) && method_exists($v, 'getFields')) {
                    $isStructured = true;
                    break;
                }
                if (is_array($v) && isset($v['fields'])) {
                    $isStructured = true;
                    break;
                }
            }

            if (!$isStructured) {
                // Flat Array -> Default Tab (Treat as 'main' section)
                $tabsConfig['main'] = ['label' => 'General', 'fields' => $fields];
            } else {
                // Structured Array -> Multi-Tab
                foreach ($fields as $key => $tabData) {
                    if (is_object($tabData) && method_exists($tabData, 'getFields')) {
                        $tabsConfig[$tabData->getField()] = [
                            'label' => $tabData->getLabel(),
                            'fields' => $tabData->getFields()
                        ];
                    } elseif (is_array($tabData) && isset($tabData['fields'])) {
                        $tabsConfig[$key] = [
                            'label' => $tabData['label'] ?? ucfirst($key),
                            'fields' => $tabData['fields']
                        ];
                    }
                }
            }
        }

        // Apply Configuration and Metadata Enrichment
        if (!empty($tabsConfig)) {
            // Prepare Metadata Lookup
            $fieldsByName = [];
            if ($this->modelClass && method_exists($this->modelClass, 'getFields')) {
                $dbFields = $this->modelClass::getFields();
                foreach ($dbFields as $f) {
                    if (!empty($f['field'])) {
                        $fieldsByName[$f['field']] = $f;
                    }
                }
            }

            foreach ($tabsConfig as $sectionId => $sectionData) {
                $this->addEditSection($sectionId, $sectionData['label']);

                $sectionFields = $sectionData['fields'];

                // Metadata Enrichment Loop
                if (!empty($fieldsByName)) {
                    foreach ($sectionFields as $fieldObj) {
                        if (!($fieldObj instanceof \Alxarafe\Component\AbstractField)) continue;

                        $fName = $fieldObj->getField();
                        if (!isset($fieldsByName[$fName])) continue;

                        $dbDef = $fieldsByName[$fName];
                        $currentOpts = $fieldObj->getOptions()['options'] ?? [];
                        $newOpts = [];

                        // 1. Max Length (Varchar)
                        if (!isset($currentOpts['maxlength']) && !empty($dbDef['length']) && is_numeric($dbDef['length'])) {
                            $newOpts['maxlength'] = (int)$dbDef['length'];
                        }

                        // 2. Numeric Constraints
                        if (isset($dbDef['type'])) {
                            $isNumeric = in_array(strtolower($dbDef['type']), ['int', 'integer', 'tinyint', 'smallint', 'mediumint', 'bigint', 'decimal', 'float', 'double']);
                            if ($isNumeric) {
                                if (!isset($currentOpts['min']) && !empty($dbDef['unsigned'])) {
                                    $newOpts['min'] = 0;
                                }

                                if (strtolower($dbDef['type']) === 'tinyint') {
                                    if (!empty($dbDef['unsigned'])) {
                                        if (!isset($currentOpts['max'])) $newOpts['max'] = 255;
                                    } else {
                                        if (!isset($currentOpts['min'])) $newOpts['min'] = -128;
                                        if (!isset($currentOpts['max'])) $newOpts['max'] = 127;
                                    }
                                }
                            }
                        }

                        if (!empty($newOpts)) {
                            $fieldObj->mergeOptions($newOpts);
                        }
                    }
                }

                // Register fields for this section
                $this->setEditFields($sectionFields, $sectionId);
            }
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
            $this->mode = ResourceInterface::MODE_EDIT;
            // Auto-enable protection in edit mode
            $this->protectChanges = true;
        } else {
            $this->mode = ResourceInterface::MODE_LIST;
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
        if ($this->mode === ResourceInterface::MODE_LIST) {
            $this->activeTab = $_GET['tab'] ?? array_key_first($this->structConfig['list']['tabs'] ?? []) ?? '';

            if (isset($_GET['ajax']) && $_GET['ajax'] === 'get_data') {
                $this->jsonResponse($this->fetchListData($this->activeTab));
                exit;
            }
        }

        // Edit Mode Handler
        if ($this->mode === ResourceInterface::MODE_EDIT) {
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

        if (!empty($this->with)) {
            $query->with($this->with);
        }

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

            // DEBUG: Check if relations are loaded
            // \Alxarafe\Tools\Debug::message("Row " . $item->id . " keys: " . implode(',', array_keys($row)));

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
        $query = $model->newQuery();

        if (!empty($this->with)) {
            $query->with($this->with);
        }

        $data = $query->find($this->recordId);

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
        // Separate Main Model Data and Relation Data
        $modelData = [];
        $relationData = [];

        // Use processed configuration (instantiated components)
        $fieldDefs = [];

        $collectFields = function ($fields) use (&$fieldDefs, &$collectFields) {
            foreach ($fields as $f) {
                if ($f instanceof \Alxarafe\Component\Container\Panel) {
                    $collectFields($f->getFields());
                } elseif ($f instanceof \Alxarafe\Component\AbstractField) {
                    $fieldDefs[$f->getField()] = $f;
                }
            }
        };

        if (!empty($this->structConfig['edit']['sections'])) {
            foreach ($this->structConfig['edit']['sections'] as $section) {
                if (!empty($section['fields'])) {
                    $collectFields($section['fields']);
                }
            }
        }

        foreach ($data as $key => $value) {
            // Check if exact match exists
            if (isset($fieldDefs[$key])) {
                if ($fieldDefs[$key]->getType() === 'relation_list') {
                    $relationData[$key] = $value;
                } else {
                    $modelData[$key] = $value;
                }
                continue;
            }

            // Check if it's a bracketed key belonging to a relation (e.g. addresses[0][street])
            $foundRelation = false;
            foreach ($fieldDefs as $fieldName => $def) {
                if ($def->getType() === 'relation_list') {
                    // Check if key starts with "fieldName["
                    if (strpos((string)$key, $fieldName . '[') === 0) {
                        // It's part of this relation.
                        // We need to structure it into $relationData[$fieldName]
                        // Parse: addresses[123][street] -> value
                        // This requires expanding the dot/bracket notation.
                        // Simple regex extraction:
                        if (preg_match('/^' . preg_quote($fieldName, '/') . '\[([^\]]+)\]\[([^\]]+)\]$/', (string)$key, $matches)) {
                            // matches[1] = index, matches[2] = subfield
                            $relationData[$fieldName][$matches[1]][$matches[2]] = $value;
                        }
                        $foundRelation = true;
                        break;
                    }
                }
            }

            if (!$foundRelation) {
                $modelData[$key] = $value;
            }
        }

        DB::connection()->beginTransaction();

        try {
            // Populate Main Model
            $pkName = $model->getKeyName();
            foreach ($modelData as $key => $value) {
                if (($key === $pkName || $key === 'created_at' || $key === 'updated_at') && empty($value)) {
                    continue;
                }
                // Determine if field belongs to model (simple check: is fillable or column exists)
                // For now, trusting fillable or robust assignment
                $model->$key = $value;
            }

            if (!$model->save()) {
                DB::connection()->rollBack();
                $this->jsonResponse(['error' => 'Failed to save record']);
                exit;
            }

            // Save Relations
            // Save Relations
            foreach ($relationData as $relationName => $rows) {
                if (!method_exists($model, $relationName)) continue;

                $relation = $model->$relationName();
                $relatedModel = $relation->getRelated();
                $foreignKey = $relation->getForeignKeyName(); // e.g. person_id
                $localKey = $model->getKey(); // Person ID
                $relatedKeyName = $relatedModel->getKeyName();

                // 1. Sync: Delete records missing from submission
                $keepIds = [];
                if (is_array($rows)) {
                    foreach ($rows as $row) {
                        if (is_array($row) && !empty($row[$relatedKeyName])) {
                            $keepIds[] = $row[$relatedKeyName];
                        }
                    }
                }

                // Delete records belonging to this parent that are NOT in the keep list
                $query = $relatedModel->where($foreignKey, $localKey);
                if (!empty($keepIds)) {
                    $query->whereNotIn($relatedKeyName, $keepIds);
                }
                $query->delete();

                // 2. Upsert: Create or Update submitted records
                if (is_array($rows)) {
                    foreach ($rows as $row) {
                        if (!is_array($row)) continue;

                        // ID for update, or null for create
                        $rowId = $row[$relatedKeyName] ?? null;
                        if (isset($row[$relatedKeyName])) unset($row[$relatedKeyName]);

                        // Set Foreign Key
                        $row[$foreignKey] = $localKey;

                        $relatedModel->updateOrCreate(
                            [$relatedKeyName => $rowId],
                            $row
                        );
                    }
                }
            }

            DB::connection()->commit();

            $this->afterSaveRecord($model, $data);

            $this->jsonResponse([
                'status' => 'success',
                'id' => $model->{$model->primaryColumn()},
                'data' => $model->toArray(),
                'message' => 'Record saved successfully'
            ]);
        } catch (\Alxarafe\Base\Testing\HttpResponseException $e) {
            throw $e;
        } catch (\Throwable $e) {
            DB::connection()->rollBack();
            $msg = $e->getMessage();
            if (empty($msg)) {
                $msg = 'An error occurred but the exception message was empty.';
            }
            $this->jsonResponse([
                'status' => 'error',
                'error' => $msg,
                'class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        exit;
    }

    // --- View Rendering ---

    protected function renderView()
    {
        // Default back URL for Edit Mode
        if (empty($this->backUrl) && $this->mode === \Alxarafe\Base\Controller\Interface\ResourceInterface::MODE_EDIT) {
            $this->backUrl = static::url();
        }

        // Skip automatic view resolution if a template was manually set in controller (e.g. beforeList)
        if (!$this->getTemplateName()) {
            $module = static::getModuleName();
            $controller = static::getControllerName();
            $action = $this->mode; // 'list' or 'edit'

            // Prepare Paths
            $basePath = defined('BASE_PATH') ? constant('BASE_PATH') : __DIR__ . '/../../../../..';
            $cacheDir = $basePath . '/../var/cache/resources/' . $module . '/' . $controller;
            $customDir = $basePath . '/templates/custom/' . $module . '/' . $controller;

            $viewName = $action;

            // 1. Check Custom
            $customFile = $customDir . '/' . $viewName . '.blade.php';
            if (file_exists($customFile)) {
                $this->addTemplatesPath($customDir);
                $this->setDefaultTemplate($viewName);
            } else {
                // 2. Check/Generate Cache
                if (!is_dir($cacheDir)) {
                    if (!mkdir($cacheDir, 0777, true)) {
                        error_log("ResourceTrait: Failed to create cache directory: $cacheDir");
                    }
                }

                // Generate README.md if missing
                if (!file_exists($cacheDir . '/README.md')) {
                    $readmeContent = "# Automatically Generated Views\n\n" .
                        "This directory contains views automatically generated by the ResourceController based on the Controller configuration.\n\n" .
                        "**DO NOT EDIT THESE FILES DIRECTLY.**\n" .
                        "Any changes made here will be overwritten when the cache is cleared or regenerated.\n\n" .
                        "## How to Customize\n\n" .
                        "To customize a view (e.g., `{$viewName}.blade.php`):\n" .
                        "1. Copy the file from this directory.\n" .
                        "2. Paste it into the custom directory:\n" .
                        "   `{$customDir}`\n" .
                        "3. Edit the copied file.\n\n" .
                        "The system automatically prioritizes the file in the custom directory.\n";
                    file_put_contents($cacheDir . '/README.md', $readmeContent);
                }

                $cacheFile = $cacheDir . '/' . $viewName . '.blade.php';

                // Always regenerate if in debug mode or missing?
                // For now, check existence.
                if (!file_exists($cacheFile)) {
                    $content = $this->generateViewContent($action);
                    if ($content) {
                        if (file_put_contents($cacheFile, $content) === false) {
                            error_log("ResourceTrait: Failed to write cache file: $cacheFile");
                        } else {
                            chmod($cacheFile, 0666); // Ensure writable
                        }
                    } else {
                        error_log("ResourceTrait: View content generation returned empty for $action");
                    }
                }

                if (file_exists($cacheFile)) {
                    $this->addTemplatesPath($cacheDir);
                    $this->setDefaultTemplate($viewName);
                } else {
                    error_log("ResourceTrait: Cache file not found after generation attempt: $cacheFile");

                    // Fallback to generic if generation failed or empty
                    // Fallback to generic if generation failed or empty
                    $this->setDefaultTemplate('core/alxarafe_resource_view');
                }
            }
        }

        // Pass standard variables
        $this->addVariable('config', $this->structConfig);
        $this->addVariable('recordId', $this->recordId);
        $this->addVariable('mode', $this->mode);

        // Flatten fields for Dynamic View Binding
        $viewFields = [];
        $collectViewFields = function ($fields) use (&$viewFields, &$collectViewFields) {
            foreach ($fields as $f) {
                if ($f instanceof \Alxarafe\Component\Container\Panel) {
                    $collectViewFields($f->getFields());
                } elseif ($f instanceof AbstractField) {
                    $viewFields[$f->getField()] = $f;
                }
            }
        };

        if (!empty($this->structConfig['edit']['sections'])) {
            foreach ($this->structConfig['edit']['sections'] as $section) {
                if (!empty($section['fields'])) {
                    $collectViewFields($section['fields']);
                }
            }
        }
        $this->addVariable('fields', $viewFields);

        // Initialize View Config for JS fallback if needed
        $themeManager = new \Alxarafe\Base\Frontend\ThemeManager();
        $templates = array_merge($themeManager->getFieldTemplates(), $themeManager->getLayoutTemplates());

        $this->viewConfig = base64_encode(json_encode([
            'mode' => $this->mode,
            'recordId' => $this->recordId,
            'config' => $this->structConfig,
            'protectChanges' => $this->protectChanges ?? false,
            'templates' => $templates
        ]));
    }

    protected function generateViewContent(string $mode): string
    {
        if ($mode === ResourceInterface::MODE_EDIT) {
            return $this->generateEditView();
        }
        // List mode placeholder for now - or simple dump
        return $this->generateListView();
    }

    protected function generateEditView(): string
    {
        $out = "@extends('partial.layout.main')\n";
        $out .= "@section('content')\n";
        $out .= "<div class=\"container-fluid\">\n";
        // Form Wrapper
        $out .= "    <form method=\"POST\" action=\"?module=" . static::getModuleName() . "&controller=" . static::getControllerName() . "\">\n";
        $out .= "        <input type=\"hidden\" name=\"action\" value=\"save\">\n";
        $out .= "        <input type=\"hidden\" name=\"id\" value=\"{{ \$recordId }}\">\n\n";

        // Action Buttons (Header)
        if (!empty($this->structConfig['edit']['head_buttons'])) {
            $out .= "        <div class=\"mb-3 text-end\">\n";
            foreach ($this->structConfig['edit']['head_buttons'] as $btn) {
                // Render button html or component
                $out .= "            <button type=\"submit\" class=\"btn btn-" . ($btn['type'] ?? 'secondary') . "\">" . ($btn['label'] ?? '') . "</button>\n";
            }
            $out .= "        </div>\n";
        }

        // Sections
        if (!empty($this->structConfig['edit']['sections'])) {
            foreach ($this->structConfig['edit']['sections'] as $secId => $section) {
                $out .= "        <div class=\"card mb-4\">\n";
                $out .= "            <div class=\"card-header\">" . ($section['title'] ?? ucfirst($secId)) . "</div>\n";
                $out .= "            <div class=\"card-body\">\n";
                $out .= "                <div class=\"row\">\n";

                // Fields
                if (!empty($section['fields'])) {
                    foreach ($section['fields'] as $field) {
                        // Recursively handle panels
                        if ($field instanceof \Alxarafe\Component\Container\Panel) {
                            $out .= "                <!-- Panel: " . $field->getLabel() . " -->\n";
                            $out .= "                <div class=\"" . $field->getColClass() . "\">\n";
                            $out .= "                    <div class=\"card mb-3\">\n";
                            $out .= "                        <div class=\"card-header\">" . $field->getLabel() . "</div>\n";
                            $out .= "                        <div class=\"card-body\">\n";
                            $out .= "                            <div class=\"row\">\n";
                            foreach ($field->getFields() as $subField) {
                                if ($subField instanceof AbstractField) {
                                    $out .= $this->generateFieldInclude($subField);
                                }
                            }
                            $out .= "                            </div>\n"; // End nested row
                            $out .= "                        </div>\n";
                            $out .= "                    </div>\n";
                            $out .= "                </div>\n";
                        } elseif ($field instanceof AbstractField) {
                            $out .= $this->generateFieldInclude($field);
                        }
                    }
                }

                $out .= "                </div>\n"; // End section row
                $out .= "            </div>\n";
                $out .= "        </div>\n";
            }
        }

        $out .= "        <div class=\"mb-5\">\n";
        $out .= "            <button type=\"submit\" class=\"btn btn-primary\"><i class=\"fas fa-save\"></i> {{ \\Alxarafe\\Lib\\Trans::_('save') }}</button>\n";
        $out .= "        </div>\n";

        $out .= "    </form>\n";
        $out .= "</div>\n";
        $out .= "@endsection\n";
        return $out;
    }

    protected function generateFieldInclude(AbstractField $field): string
    {
        // Dynamic Reference to $fields variable passed from controller
        $fieldName = $field->getField();
        $safeName = str_replace("'", "\\'", $fieldName);
        $colClass = $field->getColClass(); // Baking the layout info

        return "                @if(isset(\$fields['" . $safeName . "']))\n" .
            "                    <div class=\"" . $colClass . "\">\n" .
            "                        @include('form." . $field->getComponent() . "', \$fields['" . $safeName . "']->jsonSerialize())\n" .
            "                    </div>\n" .
            "                @endif\n";
    }

    protected function generateListView(): string
    {
        // Basic placeholder that falls back to JS renderer for specific implementation
        // Or just basic table
        $out = "@extends('partial.layout.main')\n";
        $out .= "@section('content')\n";
        // Use the JS renderer for List for now as it's complex
        $out .= "    <div id=\"alxarafe-resource-container\" class=\"mt-3\"></div>\n";
        $out .= "    <script src=\"/js/resource.bundle.js\"></script>\n";
        $out .= "    <script>\n";
        $out .= "        document.addEventListener('DOMContentLoaded', function() {\n";
        $out .= "            try {\n";
        $out .= "                var config = JSON.parse(atob(\"{{ \$me->viewConfig }}\"));\n";
        $out .= "                new AlxarafeResource.AlxarafeResource(document.getElementById('alxarafe-resource-container'), config);\n";
        $out .= "            } catch(e) { console.error(e); }\n";
        $out .= "        });\n";
        $out .= "    </script>\n";
        $out .= "@endsection\n";
        return $out;
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
                // Check for Panel (Container) masquerading as Field
                // If it is a Panel, we register it as a separate SECTION, not a field.
                if ($value instanceof \Alxarafe\Component\Container\Panel) {
                    $panelSectionId = $value->getField();
                    // Check if section exists, if not add it
                    if (!isset($this->structConfig['edit']['sections'][$panelSectionId])) {
                        $this->addEditSection($panelSectionId, $value->getLabel());
                    }
                    // Recursively set fields for this new section
                    $this->setEditFields($value->getFields(), $panelSectionId);
                    continue;
                }

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
    protected function jsonResponse(mixed $data)
    {
        if (defined('ALX_TESTING')) {
            throw new \Alxarafe\Base\Testing\HttpResponseException($data);
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Checks if the table(s) for the model(s) exist.
     */
    protected function checkTableIntegrity()
    {
        $missing = [];
        $models = []; // Collect models

        if ($this->structConfig['list']['tabs']) {
            foreach ($this->structConfig['list']['tabs'] as $t) {
                if (isset($t['model'])) $models[] = $t['model'];
            }
        }
        if (empty($models) && $this->modelClass) {
            $models[] = $this->modelClass;
        }

        foreach (array_unique($models) as $m) {
            if (!class_exists($m)) continue;
            try {
                $instance = new $m();
                $table = $instance->getTable();
                if (!DB::schema()->hasTable($table)) {
                    $missing[] = $table;
                }
            } catch (\Exception $e) {
            }
        }

        if (!empty($missing)) {
            $msg = 'Faltan tablas en la base de datos: ' . implode(', ', $missing) . '. Por favor, ejecute las migraciones.';
            if (isset($_GET['ajax'])) {
                $this->jsonResponse(['status' => 'error', 'error' => $msg]);
            }
            $this->alerts[] = ['type' => 'danger', 'message' => $msg];
            // Simple render
            echo '<div class="alert alert-danger m-5"><h1>Error de Base de Datos</h1><p>' . $msg . '</p></div>';
            exit;
        }
    }
}
