<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Traits;

use Alxarafe\Providers\Translator;

/**
 * Trait AjaxDataTable.
 *
 * This trait class externalize the work for AJAX DataTable.
 *
 * @package Alxarafe\Traits
 */
trait AjaxDataTable
{
    /**
     * Return the table data using AJAX
     */
    public function ajaxTableDataMethod()
    {
        $this->initialize();
        $this->renderer->setTemplate(null);
        // To access more easy to all values
        $requestData = $_REQUEST;
        $recordsTotal = 0;
        $recordsFiltered = 0;
        $data = [];

        if ($this->canAccess && $this->canRead) {
            // Page to start
            $offset = $requestData['start'];
            // Columns used un table by order
            $columns = $this->getDefaultColumnsSearch();
            // Remove this extra column for search (not in table)
            if (in_array('col-action', $columns)) {
                unset($columns[array_search('col-action', $columns)]);
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

        $json_data = [
            "draw" => intval($requestData['draw'] ?? null),
            "recordsTotal" => $recordsTotal ?? null,
            "recordsFiltered" => $recordsFiltered ?? null,
            "data" => $data ?? null,
        ];

        $print = constant('DEBUG') === true ? constant('JSON_PRETTY_PRINT') : 0;
        return $this->sendResponse(json_encode($json_data, $print));
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
        foreach ($this->viewData as $key => $value) {
            $list[$i] = $key;
            $i++;
        }
        $list[$i] = 'col-action';
        return $list;
    }

    /**
     * Returns the header for table.
     */
    public function getTableHeader()
    {
        $list = [];
        foreach ($this->viewData as $key => $value) {
            $list[$key] = [
                'label' => Translator::getInstance()->trans($value['shortlabel'] ?? 'col-' . $key),
                'class' => null,
                'style' => null,
            ];
        }

        $list['col-action'] = [
            'label' => Translator::getInstance()->trans('action'),
            'class' => 'text-center',
            'style' => 'width: 1%; min-width: 225px; max-width: 300px;',
        ];

        return $list;
    }

    /**
     * Returns the content for the body of table.
     */
    public function getTableBody()
    {
        $list = [];
        if (isset($this->postData[$this->tableName])) {
            foreach ($this->postData[$this->tableName] as $pos => $valueData) {
                foreach ($this->viewData as $key => $viewDataValue) {
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
        /*
          // TODO: Actions maybe was better add here, but need more work to do that.
          $list['col-action'] = [
          'label' => null,
          ];
         */
        return $list;
    }

    /**
     * Returns a list of fields for the tablename.
     */
    public function getListFields()
    {
        $list = [];
        foreach ($this->postData[$this->tableName] as $pos => $valueData) {
            foreach ($this->viewData as $key => $viewDataValue) {
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
        /*
          $list['col-action'] = [
          'label' => null,
          ];
         */
        return $list;
    }

    /**
     * Returns a footer list of fields for the table.
     */
    public function getTableFooter()
    {
        $list = [];
        /*
          foreach ($this->viewData as $key => $value) {
          $list[$key] = [
          'label' => Translator::getInstance()->trans($value['shortlabel'] ?? 'col-' . $key),
          'class' => null,
          'style' => null,
          ];
          }

          $list['col-action'] = [
          'label' => Translator::getInstance()->trans('action'),
          'class' => 'text-center',
          'style' => 'width: 1%; min-width: 225px; max-width: 300px;',
          ];
         */
        return $list;
    }
}