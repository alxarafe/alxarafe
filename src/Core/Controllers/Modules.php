<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\AuthPageExtendedController;
use Alxarafe\Helpers\FormatUtils;
use Alxarafe\Models\Module;
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
        return parent::indexMethod();
    }

    /**
     * Default create method for new registers.
     *
     * @return Response
     */
    public function createMethod(): Response
    {
        // TODO: Implement createMethod() method.
        return $this->response;
    }

    /**
     * Default show method for show an individual register.
     *
     * @return Response
     */
    public function showMethod(): Response
    {
        // TODO: Implement showMethod() method.
        return $this->response;
    }

    /**
     * Default update method for update an individual register.
     *
     * @return Response
     */
    public function updateMethod(): Response
    {
        // TODO: Implement updateMethod() method.
        return $this->response;
    }

    /**
     * Default delete method for delete an individual register.
     *
     * @return Response
     */
    public function deleteMethod(): Response
    {
        // TODO: Implement deleteMethod() method.
        return $this->response;
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
}
