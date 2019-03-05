<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Alxarafe\Core\Models\Language;
use Alxarafe\Core\PreProcessors\Languages as PreLanguages;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Languages
 *
 * @package Alxarafe\Core\Controllers
 */
class Languages extends AuthPageExtendedController
{
    /**
     * Languages constructor.
     */
    public function __construct()
    {
        parent::__construct(new Language());
    }

    /**
     * Main is invoked if method is not specified. Check if you have to save changes or just exit.
     *
     * @return Response
     */
    public function indexMethod(): Response
    {
        switch ($this->request->request->get('action')) {
            case 'export':
                $this->exportAction();
                break;
        }
        return parent::indexMethod();
    }

    /**
     * Export language files with all strings for each language.
     */
    private function exportAction()
    {
        PreLanguages::exportLanguages();
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
            'link' => $this->url . '&action=export',
            'icon' => '<i class="fas fa-redo-alt"></i>',
            'text' => 'export-data',
            'type' => 'info',
        ];
        return $return;
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-languages-title',
            'icon' => '<i class="fas fa-globe"></i>',
            'description' => 'controller-languages-description',
            'menu' => 'regional-info',
        ];
        return $details;
    }
}
