<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Helpers\Schema;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Translator;
use Alxarafe\Core\Traits\AjaxDataTableTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Symbol used to separate items.
 */
define('IDSEPARATOR', '~');

/**
 * Class AuthPageExtendedController
 *
 * @package Alxarafe\Core\Base
 */
abstract class AuthPageExtendedController extends AuthPageController
{
    use AjaxDataTableTrait;

    /**
     * Contains all data received from $_POST.
     *
     * @var array
     */
    public $postData;

    /**
     * Main table model.
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
     * NOTE: If code is unique for each case, datatables state save works.
     *
     * @var string
     */
    public $code;

    /**
     * Contains all data from table.
     *
     * Every time that controller is loaded, the old data is renewed from table.
     * When save, oldData is compared with postData to updated only modified fields.
     *
     * TODO: This data can be stored in a FlashMessage to be passed in SESSION as original data.
     * Can happens that a field was modified for more than one user and this change result not see it.
     *
     * ORIGINAL EXPLANATION
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
     * Contains the field structure.
     *
     * @var array
     */
    protected $fieldsStruct;

    /**
     * Contains the primary key of register in use.
     * If its a new register, contains ''.
     *
     * @var string|null
     */
    protected $currentId;

    /**
     * Can contain: listing, adding or editing.
     *
     * @var string
     */
    protected $status;

    /**
     * AuthPageExtendedController constructor.
     *
     * @param Table|null $model
     */
    public function __construct($model = null)
    {
        $this->model = $model;
        $this->tableName = $this->model->tableName;
        parent::__construct();
        $this->renderer->setTemplate('default');
    }

    /**
     * Returns a list of extra actions.
     *
     * @return array
     */
    public function getExtraActions(): array
    {
        return [];
    }

    /**
     * Returns the actual status of the controller.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
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
     * Initialize common properties
     */
    public function initialize(): void
    {
        $this->currentId = $this->request->query->get($this->model->getIdField());
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
     * Obtains an array of data from register $this->currentId.
     * If register doesn't exists, returns an empty register with default data.
     *
     * This method can do additional things in more complex situations.
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
     * Read existing record, used as alias
     *
     * @return Response
     */
    public function showMethod(): Response
    {
        return $this->readMethod();
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
     * Update existing record, used as alias
     *
     * @return Response
     */
    public function editMethod(): Response
    {
        return $this->updateMethod();
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
        switch ($this->request->request->get('action')) {
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
     * Cancels goes to main controller status.
     *
     * @return RedirectResponse
     */
    protected function cancel(): RedirectResponse
    {
        // Si no hay puesto id estaba en la pantalla del listado de registros...
        if ($this->status === 'listing') {
            return $this->redirect(baseUrl('index.php'));
        }
        return $this->redirect($this->url);
    }

    /**
     * Returns the data received from $_POST
     *
     * This method can do additional things in more complex situations.
     *
     * @return void
     */
    protected function getDataPost(): void
    {
        $this->postData = [];
        foreach ($_POST as $key => $value) {
            if (substr_count($key, constant('IDSEPARATOR')) === 2) {
                $field = explode(constant('IDSEPARATOR'), $key);
                $this->postData[$field[0]][$field[1]][$field[2]] = is_array($value) ? array_values($value)[0] : $value;
            }
        }
    }

    /**
     * Save the data, and reload the page on success.
     *
     * This method can do additional things in more complex situations.
     */
    protected function save(): void
    {
        if ($this->model->saveRecord($this->postData)) {
            $this->currentId = $this->model->{$this->model->getIdField()};
            $this->postData = $this->getRecordData();
            FlashMessages::getInstance()::setError(Translator::getInstance()->trans('register-saved'));
            $this->redirect($this->url . '&' . $this->model->getIdField() . '=' . $this->currentId);
        }
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
     * Access denied page.
     */
    public function accessDenied(): void
    {
        $this->renderer->setTemplate('master/noaccess');
    }

    /**
     * The start point of the controller.
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
        //$this->code = 'table-' . $this->tableName . '-user-' . $this->username . Utils::randomString(10);
        // If code is unique for each case, datatables state save works.
        $this->code = 'table-' . $this->tableName . '-user-' . $this->username;
        return $this->sendResponseTemplate();
    }

    /**
     * Returns a list of actions buttons. By default returns Read/Update/Delete actions.
     * If some needs to be replace, replace it on final class.
     *
     * @param string $id
     *
     * @return array
     */
    public function getActionButtons(string $id = ''): array
    {
        $actionButtons = [];
        if ($this->canRead) {
            $actionButtons['read'] = [
                'class' => 'btn btn-info btn-sm',
                'type' => 'button',
                'link' => $this->url . '&' . constant('METHOD_CONTROLLER') . '=show&id=' . $id,
                'icon' => '<i class="fas fa-search-plus"></i>',
                'text' => $this->translator->trans('show'),
            ];
        }
        if ($this->canUpdate) {
            $actionButtons['update'] = [
                'class' => 'btn btn-primary btn-sm',
                'type' => 'button',
                'link' => $this->url . '&' . constant('METHOD_CONTROLLER') . '=edit&id=' . $id,
                'icon' => '<i class="far fa-edit"></i>',
                'text' => $this->translator->trans('edit'),
            ];
        }
        if ($this->canDelete) {
            $actionButtons['delete'] = [
                'class' => 'btn btn-danger btn-sm',
                'type' => 'button',
                'link' => '#',
                'onclick' => 'confirmDelete("' . $this->url . '&' . constant('METHOD_CONTROLLER') . '=delete&id=' . $id . '");',
                'icon' => '<i class="far fa-trash-alt"></i>',
                'text' => $this->translator->trans('delete'),
            ];
        }

        return $actionButtons;
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
        if (isset(Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName)['fields'])) {
            foreach (Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName)['fields'] as $key => $struct) {
                $ret[$key] = $record[$key] ?? $struct['default'] ?? '';
            }
        }
        return $ret;
    }
}
