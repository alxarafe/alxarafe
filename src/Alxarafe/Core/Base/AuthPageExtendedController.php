<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Helpers\Schema;
use Alxarafe\Core\Helpers\SqlGenerator;
use Alxarafe\Core\Models\TableModel;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Translator;
use Alxarafe\Core\Renders\Twig\Components\AbstractComponent;
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
     * Contains an array of components.
     * It is possible that this attribute replaces many of those that now exist.
     *
     * @var AbstractComponent[]
     */
    public $components;

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
     * Used models
     *
     * @var Table[]
     */
    public $models;

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
     * Contains the indexes of the tables in use
     *
     * @var array
     */
    public $sql;

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
        $this->sql = new SqlGenerator(
            $this->tableName,
            Schema::getFromYamlFile($this->tableName, 'viewdata')['fields'] ?? null
        );
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
        // $this->fieldsStruct = Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName)['fields'];
        $this->fieldsStruct = $this->model->getStructArray();
        // $this->indexesTables[$this->tableName] = Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName)['indexes'];
        $this->viewData = Schema::getFromYamlFile($this->tableName, 'viewdata');
        $this->getModels();
        $this->tableData[$this->tableName] = isset($this->postData[$this->tableName]) ? $this->model->getDefaultValues() : $this->postData[$this->tableName][0];
        $this->getComponents();
    }

    /**
     * Obtains an array of data from register $this->currentId.
     * If register doesn't exists, returns an empty register with default data.
     *
     * This method can do additional things in more complex situations.
     *
     * TODO: If is $this->currentId is null?
     *
     * @return array
     */
    protected function getRecordData(): array
    {
        $ret = [];
        if ($this->currentId == '' || $this->currentId == '0') {
            $ret[$this->model->tableName][0] = $this->model->defaultData();
            $ret[$this->model->tableName][0][$this->model->idField] = '';
        } else {
            // TODO: Parece que sólo obtiene el registro de la tabla principal, pero no de las relacionadas.
            $value = $this->model->getDataArray($this->currentId);
            // TODO: ¿Y si hay más de un campo formando el índice principal?
            $ret[$this->model->tableName][$this->currentId] = $value;
        }
        return $ret;
    }

    /**
     * TODO: This may have to be in FlatTable and not here.
     * Creates an array with all the models used by the current record, positioning each element in the used record.
     */
    private function getModels()
    {
        $this->models = [];
        if (isset($this->currentId)) {
            $this->models[$this->tableName] = $this->getModel($this->tableName, $this->currentId);
        }
    }

    /**
     * TODO: This may have to be in FlatTable and not here.
     * Performs a recursive search to instantiate each of the model records related to the current record.
     *
     * @param string $tableName
     * @param string $id
     *
     * @return Table|null
     */
    private function getModel(string $tableName, string $id)
    {
        $model = TableModel::getModel($tableName);
        $model->load($id);
        foreach ($model->getData() as $key => $value) {
            $field = $model->getField($key);
            if (!isset($field->referencedtable)) {
                continue;
            }
            if (!isset($this->models[$field->referencedtable])) {
                $this->models[$field->referencedtable] = $this->getModel($field->referencedtable, $model->{$key});
            }
        }
        return $model;
    }

    /**
     * Build the list of components.
     */
    private function getComponents()
    {
        $components = $this->getListFields();
        $this->components = [];
        foreach ($components as $pos => $fieldname) {
            foreach ($fieldname as $key => $data) {
                $value = [];
                $value['id'] = $data['idName'];
                $value['name'] = $data['name'];
                $value['value'] = $data['value'];
                $value['struct'] = $this->model->getField($key);
                foreach ($data['viewData'] as $keyData => $valueData) {
                    $value[$keyData] = $valueData;
                }
                $value['ctrlUrl'] = $this->url;
                $this->components[$key] = $this->getComponentClass($value);

                // Update the value of the component with the one received by POST
                $tablename = $this->components[$key]->dataset ?? $this->tableName;
                $fieldname = $this->components[$key]->fieldname ?? $key;
                if (isset($_POST[$tablename][$fieldname])) {
                    $this->components[$key]->setValue($_POST[$tablename][$fieldname]);
                }
            }
        }
    }

    /**
     * Returns a component with the data supplied as arguments.
     *
     * @param array $value
     *
     * @return AbstractComponent
     */
    private function getComponentClass(array $value)
    {
        $type = $value['component'] ?? 'Undefined';
        $file = basePath('src/Alxarafe/Core/Renders/Twig/Components/' . ucfirst($type) . 'Component.php');
        $class = 'Alxarafe\\Core\\Renders\\Twig\\Components\\' . ucfirst($type) . 'Component';
        if (!file_exists($file)) {
            $params = ['%type%' => $type];
            trigger_error(Translator::getInstance()->trans('component-does-not-exists', $params));
            $class = 'Alxarafe\\Core\\Renders\\Twig\\Components\\SpanComponent';
        }
        return new $class($value);
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
                $this->save();
                break;
            case 'save-exit':
                $this->save();
                return $this->redirect($this->url);
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
     * Save the data.
     *
     * This method can do additional things in more complex situations.
     */
    protected function save(): void
    {
        $this->getDataPost();
        $this->oldData = $this->getRecordData();

        $database = Database::getInstance();
        $engine = $database->getDbEngine();
        $engine->beginTransaction();

        $ok = true;
        foreach ($this->models as $tableName => $model) {
            if (!isset($this->postData[$tableName])) {
                continue;
            }
            $model->setData($this->postData[$tableName]);
            $save = $model->save();
            $ok = $ok && $save;
        }

        if ($ok) {
            $engine->commit();
            $this->postData = $this->getRecordData();
            $this->getComponents();
            $this->currentId = $this->model->{$this->model->getIdField()};
            FlashMessages::getInstance()::setSuccess(Translator::getInstance()->trans('register-saved'));
            return;
        }

        foreach ($this->model->errors as $error) {
            FlashMessages::getInstance()::setError($error);
        }
        FlashMessages::getInstance()::setError(Translator::getInstance()->trans('register-not-saved'));
        $engine->rollBack();
        return;
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
        $this->postData = $_POST;
        return;
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
            FlashMessages::getInstance()::setInfo(Translator::getInstance()->trans('register-locked'));
        } elseif ($this->model->delete()) {
            FlashMessages::getInstance()::setSuccess(Translator::getInstance()->trans('register-deleted'));
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
}
