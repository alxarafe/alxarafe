<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\AuthPageController;
use Alxarafe\Helpers\Schema;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for editing database and skin settings
 *
 * @package Alxarafe\Controllers
 */
class ExportStructure extends AuthPageController
{

    /**
     * ExportStructure constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Main is invoked if method is not specified. Check if you have to save changes or just exit
     *
     * @return Response
     */
    public function indexMethod(): Response
    {
        switch (filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING)) {
            case 'export-all':
                Schema::saveStructure();
                break;
            case 'export-selected':
                $tables = filter_input(INPUT_POST, 'tables', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
                foreach ($tables as $table) {
                    Schema::saveTableStructure($table);
                }
                break;
            case 'cancel':
                return $this->redirect(baseUrl('index.php'));
        }
        return $this->sendResponseTemplate();
    }

    /**.
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'export-db-estructure',
            'icon' => '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>',
            'description' => 'export-db-estructure-description',
            'menu' => 'dev-tools',
        ];
        return $details;
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
}
