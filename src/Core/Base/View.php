<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Schema;
use Alxarafe\Helpers\Utils;

/**
 * Class View
 *
 * @package Alxarafe\Base
 */
class View extends SimpleView
{
    /**
     * True si se desea proteger la página de un cierre accidental mediante JS.
     *
     * En common.js hay funciones para gestionar el valor de la variable
     * puedoCerrar que se pone a false invocando a fieldChanged cada vez que
     * un campo es modificado.
     *
     * oninput="javascript:fieldChanged();"
     *
     * Si $this->protectedClose es true, se añadirá al <body> del documento
     * una llamada a la función canIClose();
     *
     * <body{% if view.protectClose %} onBeforeUnload='return canIClose()'{% endif %}>
     *
     * @var bool
     */
    public $protectClose;

    /**
     * Table fields structure.
     *
     * @var
     */
    public $fieldsStruct;

    /**
     * Data received or sended in post.
     *
     * @var array
     */
    public $tableData;

    /**
     * The descendant of PageController that is accessed as page.
     *
     * @var SimpleController
     */
    public $controller;

    /**
     * The controller name, without namespace (the call controller value).
     *
     * @var string
     */
    public $controllerName;

    /**
     * Used on form to set a default value.
     *
     * @var string
     */
    public $encType;

    /**
     * Random code used to identify table/s by ID.
     *
     * @var string
     */
    public $code;

    /**
     * @var
     */
    public $btnAdd;

    /**
     * @var
     */
    public $btnSave;

    /**
     * @var
     */
    public $btnCancel;

    /**
     * Es el id que estamos editando:
     * - null sería en modo listado (consulta)
     * - '' sería en modo alta (preguntando código)
     * - '0' sería en modo alta (código automático)
     *
     * @var null|string
     */
    protected $currentId;

    /**
     * Es el estado de edición:
     * - listing cuando se muestra la lista de registros.
     * - adding justo antes de empezar a añadir un nuevo registro.
     * - editing cuando se está añadiendo o modificando uno exitente.
     *
     * @var string
     */
    protected $status;

    /**
     * The model related to this view.
     *
     * @var mixed
     */
    protected $model;

    /**
     * The table relate to the model.
     *
     * @var string
     */
    protected $tableName;

    /**
     * Path for button "new"
     *
     * @var string
     */
    protected $pathnew;

    /**
     * Path for button "edit"
     *
     * @var string
     */
    protected $pathedit;

    /**
     * The data view details for each data field.
     *
     * @var array
     */
    protected $viewData;

    /**
     * Array of config data
     *
     * @var array
     */
    protected $config;

    /**
     * Constructor de la vista
     * Solo garantiza la instancia. El código se traspasa al método run.
     *
     * @param SimpleController $controller
     * @param array            $config
     */
    public function __construct($controller, array $config = [])
    {
        if (!($controller instanceof PageController)) {
            $this->debugTool->addMessage('messages', 'Must be a PageController descendent: <pre>' . var_export($controller, true) . '</pre>');
        }
        parent::__construct($controller);

        $this->controller = $controller;
        $this->controllerName = $this->controller->shortName;
        $this->config = $config;
    }

    /**
     * Run ejecuta la plantilla, pero desde la plantilla se invoca a view.view().
     * Así que continuar el código por el método view().
     *
     * @param array $data
     * @param array $params
     *
     * @return void
     */
    public function run(array $data = null, array $params = []): void
    {
        $this->model = $this->controller->model;
        $this->tableName = $this->model->tableName;
        $this->viewData = Schema::getFromYamlFile($this->tableName, 'viewdata');
        $this->status = $this->controller->getStatus();

        // Rutas para los botones nuevo, edición e impresión
        $this->pathnew = constant('BASE_URI') . '?' .
            constant('CALL_CONTROLLER') . '=' . filter_input(INPUT_GET, constant('CALL_CONTROLLER')) .
            '&' . constant('METHOD_CONTROLLER') . '=add';
        $this->pathedit = constant('BASE_URI') . '?' .
            constant('CALL_CONTROLLER') . '=' . filter_input(INPUT_GET, constant('CALL_CONTROLLER')) .
            '&' . constant('METHOD_CONTROLLER') . '=edit' .
            '&id=#';

        $this->protectClose = ($this->status == 'editing');

        $this->fieldsStruct = Config::$bbddStructure[$this->tableName]['fields'];
        $this->tableData = $data ?? $this->controller->postData;

        $this->code = Utils::randomString(10);

        $this->btnAdd = true; //$this->fastedit || !$this->editing;
        $this->btnSave = true; //$this->fastedit || $this->editing;
        $this->btnCancel = true;

        // Apply the related skin to each status
        switch ($this->status) {
            case 'adding':
                $this->renderer->setTemplate('master/create');
                break;
            case 'showing':
                $this->renderer->setTemplate('master/read');
                break;
            case 'editing':
                $this->renderer->setTemplate('master/update');
                break;
            case 'listing':
            default:
                $this->renderer->setTemplate('master/list');
                break;
        }
    }
}
