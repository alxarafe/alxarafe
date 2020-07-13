<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Traits;

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
     */
    public function ajaxTableDataMethod(): Response
    {
        $this->initialize();
        $this->renderer->setTemplate(null);
        // To access more easy to all values
        $requestData = $this->request->request->all();
        $recordsTotal = 0;
        $recordsFiltered = 0;
        $data = [];

        if ($this->canAccess && $this->canRead) {
            $this->searchData($data, $recordsFiltered, $requestData);
        }

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
     * Initialize common properties
     */
    abstract public function initialize(): void;

    /**
     * Realize the search to database table.
     *
     * @param array $data
     * @param int   $recordsFiltered
     * @param array $requestData
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
            $data = $this->model->search($search, $columns, $offset, $order);
            $recordsFiltered = $this->model->searchCount($search, $columns);
        } else {
            $search = '';
            $data = $this->model->search($search, $columns, $offset, $order);
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
     * Send the Response with data received.
     *
     * @param string $reply
     * @param int    $status
     *
     * @return Response
     */
    abstract public function sendResponse(string $reply, $status = Response::HTTP_OK): Response;

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
                    $list[$pos][$key] = [
                        'label' => Translator::getInstance()->trans($viewDataValue['shortlabel'] ?? 'col-' . $key),
                        'value' => $valueData[$key],
                        'idName' => $this->tableName . constant('IDSEPARATOR') . $pos . constant('IDSEPARATOR') . $key,
                        'listPosition' => $pos,
                        'isPk' => $key === $this->model->getIdField(),
                        'struct' => $this->fieldsStruct[$key],
                        'tableName' => $this->tableName,
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

                $list[$pos][$key] = [
                    'label' => Translator::getInstance()->trans($viewDataValue['shortlabel'] ?? 'col-' . $key),
                    'value' => $valueData[$key],
                    'idName' => $this->tableName . constant('IDSEPARATOR') . $pos . constant('IDSEPARATOR') . $key,
                    'listPosition' => $pos,
                    'isPk' => $key === $this->model->getIdField(),
                    'struct' => $this->fieldsStruct[$key],
                    'tableName' => $this->tableName,
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
}
