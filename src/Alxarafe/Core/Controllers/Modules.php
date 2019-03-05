<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Alxarafe\Core\Base\CacheCore;
use Alxarafe\Core\Helpers\FormatUtils;
use Alxarafe\Core\Helpers\Utils;
use Alxarafe\Core\Models\Module;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Translator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Modules
 *
 * @package Alxarafe\Core\Controllers
 */
class Modules extends AuthPageExtendedController
{
    /**
     * Array that contains the paths to search.
     *
     * @var array
     */
    protected $searchDir;

    /**
     * Modules folder were are stored.
     *
     * @var string
     */
    private $modulesFolder;

    /**
     * @var array
     */
    private $modulesList = [];

    /**
     * Modules constructor.
     */
    public function __construct()
    {
        parent::__construct(new Module());
        $this->modulesFolder = basePath('src' . constant('DIRECTORY_SEPARATOR') . 'Modules');
        $this->searchDir = [
            'Alxarafe' => constant('ALXARAFE_FOLDER'),
        ];
    }

    /**
     * The start point of the controller.
     *
     * @return Response
     */
    public function indexMethod(): Response
    {
        $this->modulesList = $this->getAvailableModules();
        $this->updateModulesData();

        switch ($this->request->request->get('action')) {
            case 'regenerate':
                CacheCore::getInstance()->getEngine()->clear();
                FlashMessages::getInstance()::setSuccess(Translator::getInstance()->trans('cache-cleared-successfully'));
                $this->regenerateData();
                // Previous execution is instanciate a new controller, we need to redirect to this page to avoid false execution.
                return $this->redirect(baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=' . $this->shortName));
        }

        return parent::indexMethod();
    }

    /**
     * Returns a list of availabe modules.
     *
     * @return array
     */
    private function getAvailableModules(): array
    {
        $modules = Finder::create()
            ->directories()
            ->depth(0)
            ->in($this->modulesFolder)
            ->sortByName();
        $modulesList = [];
        foreach ($modules as $module) {
            $modulesList[$module->getFileName()] = str_replace(basePath(DIRECTORY_SEPARATOR), '', $module->getPathName());
        }
        return $modulesList;
    }

    /**
     * Updated all modules to database.
     */
    private function updateModulesData()
    {
        foreach ($this->modulesList as $name => $path) {
            $module = new Module();
            if (!$module->getBy('name', $name)) {
                $module->name = $name;
                $module->path = $path;
                $module->updated_date = FormatUtils::getFormatted(FormatUtils::getFormatDateTime());
                $module->save();
            }
        }
    }

    /**
     * Regenerate some needed data.
     *
     * @return void
     */
    private function regenerateData(): void
    {
        Utils::executePreprocesses($this->searchDir);
    }

    /**
     * Default create method for new registers.
     *
     * @return Response
     */
    public function createMethod(): Response
    {
        // TODO: Implement createMethod() method.
        // Require allow to submit a file
        return parent::createMethod();
    }

    /**
     * Default read method for new registers.
     *
     * @return Response
     */
    public function readMethod(): Response
    {
        // TODO: Implement readMethod() method.
        // The data can be showed from table.
        return parent::readMethod();
    }

    /**
     * Default update method for update an individual register.
     *
     * @return Response
     */
    public function updateMethod(): Response
    {
        // TODO: Implement updateMethod() method.
        // The data must be updated from each module.
        return parent::updateMethod();
    }

    /**
     * Default delete method for delete an individual register.
     *
     * @return Response
     */
    public function deleteMethod(): Response
    {
        if (!$this->canAccess || !$this->canDelete) {
            $this->renderer->setTemplate('master/noaccess');
            return $this->sendResponseTemplate();
        }
        $id = $this->request->query->get($this->model->getIdField());
        $this->model = new Module();
        if ($this->model->load($id)) {
            $this->model->enabled = 0;
            if ($this->model->save()) {
                FlashMessages::getInstance()::setSuccess(
                    $this->translator->trans('module-disabled', ['%moduleName%' => $this->model->{$this->model->getNameField()}])
                );
            }
        }

        Utils::rrmdir(basePath($this->model->path));
        return parent::deleteMethod();
    }

    /**
     * Default enable method for enable an individual register.
     *
     * @return Response
     */
    public function enableMethod(): Response
    {
        if (!$this->canAccess || !$this->canUpdate) {
            $this->renderer->setTemplate('master/noaccess');
            return $this->sendResponseTemplate();
        }
        $id = $this->request->query->get($this->model->getIdField());
        $this->model = new Module();
        if ($this->model->load($id)) {
            $this->model->enabled = FormatUtils::getFormatted(FormatUtils::getFormatDateTime());;
            if ($this->model->save()) {
                FlashMessages::getInstance()::setSuccess(
                    $this->translator->trans('module-enabled', ['%moduleName%' => $this->model->{$this->model->getNameField()}])
                );
            }
        }

        return $this->redirect(baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=' . $this->shortName));
    }

    /**
     * Default disable method for disable an individual register.
     *
     * @return Response
     */
    public function disableMethod(): Response
    {
        if (!$this->canAccess || !$this->canUpdate) {
            $this->renderer->setTemplate('master/noaccess');
            return $this->sendResponseTemplate();
        }
        $id = $this->request->query->get($this->model->getIdField());
        $this->model = new Module();
        if ($this->model->load($id)) {
            $this->model->enabled = null;
            if ($this->model->save()) {
                FlashMessages::getInstance()::setSuccess(
                    $this->translator->trans('module-disabled', ['%moduleName%' => $this->model->{$this->model->getNameField()}])
                );
            }
        }

        return $this->redirect(baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=' . $this->shortName));
    }

    /**.
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'modules-title',
            'icon' => '<i class="fas fa-cogs"></i>',
            'description' => 'modules-description',
            'menu' => 'admin',
        ];
        return $details;
    }

    /**
     * Returns a list of extra actions.
     *
     * @return array
     */
    public function getExtraActions()
    {
        $return = [];
        $return[] = [
            'link' => $this->url . '&action=regenerate',
            'icon' => '<i class="fas fa-redo-alt"></i>',
            'text' => 'regenerate-data',
            'type' => 'info',
        ];
        return $return;
    }

    /**
     * Returns a list of actions buttons. By default returns Read/Update/Delete actions.
     * If some needs to be replace, replace it on final class.
     *
     * @param string $id
     *
     * @return array
     */
    public function getActionButtons(string $id = '')
    {
        $actionButtons = [];
        $actionButtons['enable'] = [
            'class' => 'btn btn-success btn-sm',
            'type' => 'button',
            'link' => $this->url . '&' . constant('METHOD_CONTROLLER') . '=enable&id=' . $id,
            'icon' => '<i class="far fa-check-square"></i>',
            'text' => $this->translator->trans('enable'),
        ];
        $actionButtons['disable'] = [
            'class' => 'btn btn-warning btn-sm',
            'type' => 'button',
            'link' => $this->url . '&' . constant('METHOD_CONTROLLER') . '=disable&id=' . $id,
            'icon' => '<i class="far fa-square"></i>',
            'text' => $this->translator->trans('disable'),
        ];

        $actionButtons = array_merge($actionButtons, parent::getActionButtons($id));
        unset($actionButtons['read']);
        unset($actionButtons['update']);

        return $actionButtons;
    }
}
