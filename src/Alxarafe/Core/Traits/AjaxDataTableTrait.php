<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Traits;

use Alxarafe\Core\Models\TableModel;
use Alxarafe\Core\Providers\Translator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait AjaxDataTable.
 *
 * This trait class externalize the work for AJAX DataTable.
 *
 * @package Alxarafe\Core\Traits
 */
trait AjaxDataTableTrait
{

    /**
     * Return the table data using AJAX
     *
     * @doc https://select2.org/data-sources/ajax
     */
    public function ajaxSearchMethod(): Response
    {
        $this->initialize();
        $this->renderer->setTemplate(null);
        $jsonData = [];

        $search = $_GET['term'];
        $table = $_GET['table'];

        $tableModel = new TableModel();
        if ($tableModel->getBy('tablename', $table)) {
            $className = $tableModel->namespace;
            $this->model = new $className();
        }
        $data = $this->model->getAllKeyValue($search);

        $result = [];
        foreach ($data as $key => $value) {
            $result[] = ['id' => $key, 'text' => $value];
        }

        $jsonData['results'] = $result;
        $jsonData['pagination'] = ["more" => false];

        $print = constant('DEBUG') === true ? constant('JSON_PRETTY_PRINT') : 0;
        return $this->sendResponse(json_encode($jsonData, $print));
    }

    /**
     * Initialize common properties
     */
    abstract public function initialize(): void;

    /**
     * Send the Response with data received.
     *
     * @param string $reply
     * @param int    $status
     *
     * @return Response
     */
    abstract public function sendResponse(string $reply, $status = Response::HTTP_OK): Response;

    /**
     * Return the table data using AJAX
     */
    public function ajaxTableDataMethod(): Response
    {
        $this->initialize();
        $this->renderer->setTemplate(null);
        // To access more easy to all values
        $requestData = $this->request->request->all();

        $recordsTotal = $this->model->countAllRecords();
        $recordsFiltered = 0;
        $data = [];

        if ($this->canAccess && $this->canRead) {
            $this->sql->searchData($data, $recordsFiltered, $requestData);
        }

        $this->renderValue($data);
        $this->fillActions($data);

        $jsonData = [
            'draw' => (int) ($requestData['draw'] ?? null),
            'recordsTotal' => $recordsTotal ?? null,
            'recordsFiltered' => $recordsFiltered ?? null,
            'data' => $data ?? null,
        ];

        $print = constant('DEBUG') === true ? constant('JSON_PRETTY_PRINT') : 0;
        return $this->sendResponse(json_encode($jsonData, $print));
    }

    /**
     * Render the returned value with html component in readonly.
     *
     * @param $data
     */
    private function renderValue(&$data): void
    {
        foreach ($data as $pos => $item) {
            foreach ($item as $key => $value) {
                if ($item[$this->model->getIdField()] == $item[$key]) {
                    continue;
                }
                if (isset($this->components[$key])) {
                    $this->components[$key]->setValue($value);
                    $data[$pos][$key] = $this->components[$key]->toHtml(true);
                }
            }
        }
    }

    /**
     * Fill 'col-action' fields with action buttons.
     *
     * @param $data
     */
    private function fillActions(&$data): void
    {
        foreach ($data as $pos => $item) {
            $id = $item[$this->model->getIdField()];
            $buttons = '<div class="btn-group" role="group">';
            foreach ($this->getActionButtons($id) as $actionButton) {
                $text = Translator::getInstance()->trans($actionButton['text']);
                $onclick = '';
                if (isset($actionButton['onclick'])) {
                    $onclick = "onclick='{$actionButton["onclick"]}'";
                }
                $buttons .= "<a class='{$actionButton["class"]}' type='{$actionButton["type"]}' href='{$actionButton["link"]}' title='{$text}' {$onclick}>"
                    . $actionButton['icon']
                    . "<span class='hidden-xs hidden-sm hidden-md'>&nbsp;{$text}</span>"
                    . '</a>';
            }
            $buttons .= '</div>';
            $data[$pos]['col-action'] = $buttons;
        }
    }

    /**
     * Returns a list of actions buttons. By default returns Read/Update/Delete actions.
     * If some needs to be replace, replace it on final class.
     *
     * @param string $id
     *
     * @return array
     */
    abstract public function getActionButtons(string $id = ''): array;

    /**
     * Returns the header for table.
     */
    public function getTableHeader(): array
    {
        $list = [];
        foreach ($this->viewData['fields'] as $key => $value) {
            $list[$key] = [
                'label' => Translator::getInstance()->trans($value['shortlabel'] ?? 'col-' . $key),
                'class' => null,
                'style' => null,
            ];
        }

        $list['col-action'] = [
            'label' => Translator::getInstance()->trans('action'),
            'class' => 'text-center',
            'style' => null,
        ];

        return $list;
    }

    /**
     * Returns the content for the body of table.
     */
    public function getTableBody(): array
    {
        $list = [];
        if (isset($this->postData[$this->tableName])) {
            foreach ($this->postData[$this->tableName] as $pos => $valueData) {
                foreach ($this->viewData['fields'] as $key => $viewDataValue) {
                    $dataset = $viewDataValue['dataset'] ?? $this->tableName;
                    $fieldname = $viewDataValue['fieldname'] ?? $key;
                    $list[$pos][$key] = [
                        'label' => Translator::getInstance()->trans($viewDataValue['shortlabel'] ?? 'col-' . $key),
                        'value' => $valueData[$key],
                        'idName' => $dataset . constant('IDSEPARATOR') . $pos . constant('IDSEPARATOR') . $fieldname,
                        'name' => "{$dataset}[{$fieldname}]",
                        'listPosition' => $pos,
                        'isPk' => $key === $this->model->getIdField(),
                        // 'struct' => $this->fieldsStruct[$key],
                        'struct' => $this->sql->getModel($dataset)->getStructArray()[$fieldname],
                        'tableName' => $dataset,
                        'fieldname' => $fieldname,
                        'viewData' => $viewDataValue,
                    ];
                }
            }
        }
        return $list;
    }

    /**
     * Returns a list of fields for the tablename.
     */
    public function getListFields(): array
    {
        $list = [];
        foreach ($this->postData[$this->tableName] as $pos => $valueData) {
            foreach ($this->viewData['fields'] as $key => $viewDataValue) {
                // Translate common user details
                $translate = ['title', 'placeholder'];
                foreach ($translate as $keyTrans => $valueTrans) {
                    if (isset($viewDataValue[$keyTrans])) {
                        $viewDataValue[$keyTrans] = Translator::getInstance()->trans($viewDataValue[$keyTrans]);
                    }
                }

                $dataset = $viewDataValue['dataset'] ?? $this->tableName;
                $fieldname = $viewDataValue['fieldname'] ?? $key;

                // If is a related field, get its value
                $value = $valueData[$key] ?? null;
                if (!isset($value) && $dataset !== $this->tableName) {
                    $value = $this->sql->getModel($dataset)->{$fieldname};
                }

                $list[$pos][$key] = [
                    'label' => Translator::getInstance()->trans($viewDataValue['shortlabel'] ?? 'col-' . $key),
                    'value' => $value,
                    'idName' => $dataset . constant('IDSEPARATOR') . $pos . constant('IDSEPARATOR') . $fieldname,
                    'name' => "{$dataset}[{$fieldname}]",
                    'listPosition' => $pos,
                    'isPk' => $key === $this->model->getIdField(),
                    // 'struct' => $this->fieldsStruct[$key],
                    'struct' => $this->sql->getModel($dataset)->getStructArray()[$fieldname],
                    'tableName' => $dataset,
                    'fieldname' => $fieldname,
                    'viewData' => $viewDataValue,
                ];
            }
        }

        return $list;
    }

    /**
     * Returns a footer list of fields for the table.
     */
    public function getTableFooter(): array
    {
        return [];
    }

    /**
     * Realize the search to database table.
     *
     * @param array $data
     * @param int   $recordsFiltered
     * @param array $requestData
     *
     * @deprecated Use SqlGenerator searchData.
     */
    private function searchData(array &$data, int &$recordsFiltered, array $requestData = []): void
    {
        // Page to start
        $offset = $requestData['start'];
        // Columns used un table by order
        $columns = $this->getDefaultColumnsSearch();
        // Remove this extra column for search (not in table)
        if (in_array('col-action', $columns, true)) {
            unset($columns[array_search('col-action', $columns, true)]);
        }
        // Order
        $order = '';
        if (isset($columns[$requestData['order'][0]['column']])) {
            $order = $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'];
        }
        // Default data
        $recordsTotal = $this->model->countAllRecords();
        // All registers in the actual page
        $recordsFiltered = $recordsTotal;
        if (!empty($requestData['search']['value'])) {
            // Data for this search
            $search = $requestData['search']['value'];
            $data = $this->sql->search($search, $columns, $offset, $order);
            $recordsFiltered = $this->sql->searchCount($this->model->tableName, $search, $columns);
        } else {
            $search = '';
            $data = $this->sql->search($search, $columns, $offset, $order);
        }
    }

    /**
     * Return a default list of col.
     *
     * @return array
     */
    public function getDefaultColumnsSearch(): array
    {
        $list = [];
        $i = 0;
        foreach ($this->viewData['fields'] as $key => $value) {
            $list[$i] = $key;
            $i++;
        }
        $list[$i] = 'col-action';
        return $list;
    }
}
