<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Schema;
use Alxarafe\Helpers\Utils;
use Alxarafe\Providers\Database;
use Alxarafe\Providers\FlashMessages;
use Alxarafe\Providers\Translator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Symbol used to separate items.
 */
define('IDSEPARATOR', '~');

/**
 * Class AuthPageExtendedController
 *
 * @package Alxarafe\Base
 */
abstract class AuthPageExtendedController extends AuthPageController
{
    /**
     * Contiene los datos que hay en $_POST. Es un array con el formato:
     * $this->postData[nombre_tabla][id_registro][nombre_campo]=valor
     *
     * @var array
     */
    public $postData;

    /**
     * La tabla principal del mantenimiento
     *
     * @var Table
     */
    public $model;

    /**
     * The table relate to the model.
     *
     * @var string
     */
    public $tableName;

    /**
     * The data view details for each data field.
     *
     * @var array
     */
    public $viewData;

    /**
     * Type of encryption for form.
     *
     * @var string
     */
    public $encType;

    /**
     * Data received or sended in post.
     *
     * @var array
     */
    public $tableData;

    /**
     * Code to table id.
     *
     * @var string
     */
    public $code;

    /**
     * Contains additional buttons info
     *
     * @var array
     */
    public $newButtons;

    /**
     * Contiene los datos que hay actualmente en disco. Es un array con el formato:
     * $this->oldData[nombre_tabla][id_registro][nombre_campo]=valor
     *
     * Se carga con lo que hay en el disco cada vez que entra en el controlador.
     * Cuando se guarda, se compara lo que hay en olddata con lo que hay en postData
     * para actualizar sólo los campos que han cambiado.
     *
     * TODO: Lo suyo sería que esos datos se pasasen por sesión y que sólo se cargasen
     * la primera vez que se entre en una ficha, de manera que si la edición falla,
     * no se actualice, y de esa forma, no se modifique más que lo que realmente ha
     * sido modicado en la ficha. Tal y como está ahora, se podría dar el caso de que
     * alguien haya modificado algo, se cargue un dato que NO COINCIDA con lo que hay
     * en el POST, y al guardar se devuelva a como estaba (igual que está en el POST),
     * cuando entiendo que si en la ficha no se ha modificado, el dato no debería de
     * ser cambiado. A lo sumo, informar de que ha sido modificado por alguien.
     *
     * @var array
     */
    protected $oldData;

    /**
     * @var array
     */
    protected $fieldsStruct;

    /**
     * Contiene la clave primaria del registro en curso.
     * En el caso de alta contendrá cadena vacía '' o 0.
     *
     * Al final, se ha optado por considerar el proceso de alta cuando no existe
     * valor en POST para el ID.
     *
     * @var string|null
     */
    protected $currentId;

    /**
     * Puede contener 3 valores: listing, adding o editing.
     *
     * @var string
     */
    protected $status;

    /**
     * AuthPageExtendedController constructor.
     *
     * Se le pasa el modelo principal del controlador y la vista a utilizar.
     * Se invoca de la forma:
     *
     * public function __construct()
     * {
     *      parent::__construct(new Person());  // Se el pasa el modelo
     * }
     *
     * @param Table|null $model
     */
    public function __construct($model = null)
    {
        // Se inicia el controlador...
        $this->model = $model;
        $this->tableName = $this->model->tableName;
        parent::__construct();
        $this->newButtons = $this->getNewButtons();
        $this->renderer->setTemplate('default');
    }

    public function getNewButtons()
    {
        return [];
    }

    /**
     * Retorna el estado en el que se encuentra la edición en estos momentos:
     * listing (mostrando listado) / adding (añadiendo ficha) / editing (editando)
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Initialize common properties
     */
    public function initialize()
    {
        $this->currentId = filter_input(INPUT_GET, $this->model->getIdField());
        $this->postData = $this->getRecordData();
        $this->fieldsStruct = Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName)['fields'];
        $this->viewData = Schema::getFromYamlFile($this->tableName, 'viewdata');
        // If not defined in yaml file, use all table fields
        if (empty($this->viewData)) {
            foreach ($this->fieldsStruct as $key => $value) {
                $this->viewData[$key] = [];
            }
        }
        $this->tableData[$this->tableName] = isset($this->postData[$this->tableName]) ? $this->model->getDefaultValues() : $this->postData[$this->tableName][0];
    }

    /**
     * Obtiene un array con los datos del registro especificado en $this->currentId
     * Si el registro no existe, se retorna un registro en blanco con los datos por
     * defecto.
     *
     * Este método haría cosas adicionales en el caso mantienimientos complejos.
     *
     * @return array
     */
    protected function getRecordData(): array
    {
        $ret = [];
        if ($this->currentId == '' || $this->currentId == '0') {
            $ret[$this->model->tableName][0] = $this->model->getDefaultValues();
            $ret[$this->model->tableName][0][$this->model->idField] = '';
        } else {
            $value = $this->model->getDataArray($this->currentId);
            // TODO: ¿Y si hay más de un campo formando el índice principal?
            $ret[$this->model->tableName][$this->currentId] = $value;
        }
        return $ret;
    }

    /**
     * Create new record.
     */
    public function createMethod(): Response
    {
        $this->initialize();
        $this->status = 'adding';
        $this->renderer->setTemplate('master/create');
        return $this->sendResponseTemplate();
    }

    /**
     * Create new record, used as alias
     *
     * @return Response
     */
    public function addMethod(): Response
    {
        return $this->createMethod();
    }

    /**
     * Read existing record.
     */
    public function readMethod(): Response
    {
        $this->initialize();
        $this->postData = $this->getRecordData();
        $this->status = 'showing';
        $this->renderer->setTemplate('master/read');
        return $this->sendResponseTemplate();
    }

    /**
     * Read existing record, used as alias
     *
     * @return Response
     */
    public function showMethod(): Response
    {
        return $this->readMethod();
    }

    /**
     * Update existing record.
     *
     * @return Response
     */
    public function updateMethod(): Response
    {
        $this->initialize();
        $this->status = 'editing';
        $this->renderer->setTemplate('master/update');
        $action = filter_input(INPUT_POST, 'action');
        switch ($action) {
            case 'cancel':
                $this->cancel();
                break;
            case 'save':
                $this->getDataPost();
                $this->oldData = $this->getRecordData();
                $this->save();
                break;
        }
        return $this->sendResponseTemplate();
    }

    /**
     * Update existing record, used as alias
     *
     * @return Response
     */
    public function editMethod(): Response
    {
        return $this->updateMethod();
    }

    /**
     * Default delete method for delete an individual register.
     *
     * @return Response
     */
    public function deleteMethod(): Response
    {
        $this->initialize();
        // This 'locked' field can exists or not, if exist is used to not allow delete it.
        if (property_exists($this->model, 'locked') && $this->model->locked) {
            FlashMessages::getInstance()::setError(Translator::getInstance()->trans('register-locked'));
        } elseif ($this->model->delete()) {
            FlashMessages::getInstance()::setError(Translator::getInstance()->trans('register-deleted'));
        } else {
            FlashMessages::getInstance()::setError(Translator::getInstance()->trans('register-not-deleted'));
        }
        return $this->redirect($this->url);
    }

    /**
     * Default delete method for delete an individual register, used as alias
     *
     * @return Response
     */
    public function removeMethod(): Response
    {
        return $this->deleteMethod();
    }

    /**
     * Cancela la edición regresando al controlador/registro que corresponda
     *
     * @return RedirectResponse
     */
    protected function cancel(): RedirectResponse
    {
        // Si no hay puesto id estaba en la pantalla del listado de registros...
        if ($this->status == 'listing') {
            return $this->redirect(baseUrl('index.php'));
        }
        return $this->redirect($this->url);
    }

    /**
     * Devuelve los datos enviados por POST
     *
     * Este método haría cosas adicionales en el caso mantienimientos complejos.
     *
     * @return void
     */
    protected function getDataPost(): void
    {
        $this->postData = [];
        foreach ($_POST as $key => $value) {
            if (substr_count($key, constant('IDSEPARATOR')) == 2) {
                $field = explode(constant('IDSEPARATOR'), $key);
                $this->postData[$field[0]][$field[1]][$field[2]] = is_array($value) ? array_values($value)[0] : $value;
            }
        }
    }

    /**
     * Guarda los datos, y si tiene éxito, recarga la página.
     * Este método haría cosas adicionales en el caso mantienimientos complejos.
     *
     * TODO: Al recargar la página, no es posible enviar mensaje informando del éxito.
     */
    protected function save(): void
    {
        if ($this->model->saveRecord($this->postData)) {
            $this->currentId = $this->model->{$this->model->getIdField()};
            $this->postData = $this->getRecordData();
            FlashMessages::getInstance()::setError(Translator::getInstance()->trans('register-saved'));
            //$this->redirect($this->url . '&' . $this->model->getIdField() . '=' . $this->currentId);
        }
        //$_POST['id'] = $this->currentId;
    }

    /**
     * Access denied page.
     */
    public function accessDenied()
    {
        $this->renderer->setTemplate('master/noaccess');
    }

    /**
     * El punto de entrada es run.
     * Index realiza los procesos necesarios una vez instanciada la clase.
     *
     * @return Response
     */
    public function indexMethod(): Response
    {
        $this->initialize();
        $this->listData();
        return $this->sendResponseTemplate();
    }

    /**
     * List all records on model.
     *
     * @return Response
     */
    public function listData(): Response
    {
        $this->status = 'listing';
        $this->renderer->setTemplate('master/list');
        $this->code = Utils::randomString(10);
        return $this->sendResponseTemplate();
    }

    /**
     * Return the table data using AJAX
     */
    public function ajaxTableDataMethod()
    {
        $this->initialize();
        $this->renderer->setTemplate(null);
        // Para acceder de forma más simplificada y unificada a los valores
        $requestData = $_REQUEST;
        $recordsTotal = 0;
        $recordsFiltered = 0;
        $data = [];

        if ($this->canAccess && $this->canRead) {
            // Página de la que se empieza
            $offset = $requestData['start'];
            // Las columnas que se usen la tabla por su orden
            $columns = $this->getDefaultColumnsSearch();
            // Remove this column for search
            if (in_array('col-action', $columns)) {
                unset($columns[array_search('col-action', $columns)]);
            }
            // Orden
            $order = '';
            if (isset($columns[$requestData['order'][0]['column']])) {
                $order = $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'];
            }
            // Datos por defecto
            $recordsTotal = $this->model->countAllRecords();
            // Todos los registros de la página actual
            $recordsFiltered = $recordsTotal;
            if (!empty($requestData['search']['value'])) {
                // Datos para la búsqueda
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

    /**
     * Se le pasa un registro con datos de la tabla actual, y cumplimenta los que
     * falten con los datos por defecto.
     *
     * @param array $record
     *
     * @return array
     */
    protected function setDefaults(array $record): array
    {
        $ret = [];
        foreach (Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName)['fields'] as $key => $struct) {
            if (isset($record[$key])) {
                $ret[$key] = $record[$key];
            } else {
                $ret[$key] = $struct['default'] ?? '';
            }
        }
        return $ret;
    }
}
