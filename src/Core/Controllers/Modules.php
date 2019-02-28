<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\AuthPageExtendedController;
use Alxarafe\Base\CacheCore;
use Alxarafe\Helpers\FormatUtils;
use Alxarafe\Helpers\Utils;
use Alxarafe\Models\Module;
use Alxarafe\Providers\FlashMessages;
use Alxarafe\Providers\Translator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Modules
 *
 * @package Alxarafe\Controllers
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
        $this->modulesFolder = basePath('src/Modules');
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

        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
        switch ($action) {
            case 'regenerate':
                CacheCore::getInstance()->getEngine()->clear();
                FlashMessages::getInstance()::setInfo(Translator::getInstance()->trans('cache-cleared-successfully'));
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
            $modulesList[$module->getFileName()] = str_replace(basePath(), '', $module->getPathName());
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
            $module->getBy('name', $name);
            $module->name = $name;
            $module->path = $path;
            $module->updated_date = FormatUtils::getFormatted(FormatUtils::getFormatDateTime());
            $module->save();
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
        // TODO: Implement deleteMethod() method.
        // Require allow to delete the module folder.
        return parent::deleteMethod();
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
            'icon' => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>',
            'description' => 'modules-description',
            'menu' => 'admin',
        ];
        return $details;
    }

    /**
     * @return array
     */
    public function getNewButtons()
    {
        $return = [];
        $return[] = [
            'link' => $this->url . '&action=regenerate',
            'icon' => 'glyphicon-refresh',
            'text' => 'regenerate-data',
            'type' => 'info',
        ];
        return $return;
    }
}
