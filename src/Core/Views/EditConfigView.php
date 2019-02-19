<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Views;

use Alxarafe\Base\View;
use Alxarafe\Database\Engine;
use Alxarafe\Helpers\Skin;
use Alxarafe\Providers\Database;
use Alxarafe\Providers\TemplateRender;
use Alxarafe\Providers\Translator;

/**
 * Class EditConfigView
 *
 * @package Alxarafe\Views
 */
class EditConfigView extends View
{

    /**
     * List of engines available.
     *
     * @var array
     */
    public $dbEngines;

    /**
     * Engine in use.
     *
     * @var mixed|string
     */
    public $dbEngineName;

    /**
     * List of skins available.
     *
     * @var array
     */
    public $skins;

    /**
     * Skin in use.
     *
     * @var
     */
    public $skin;

    /**
     * List of available languages
     *
     * @var array
     */
    public $languages;

    /**
     * Selected language
     *
     * @var string
     */
    public $language;

    /**
     * Database config values.
     *
     * @var array
     */
    public $dbConfig;

    /**
     * Login constructor.
     *
     * @param $ctrl
     */
    public function __construct($ctrl)
    {
        parent::__construct($ctrl);
        Skin::setTemplate('editconfig');
        $this->setDefaultData();
    }

    /**
     * Sets default data values
     */
    private function setDefaultData()
    {
        $langConfig = Translator::getInstance()->getConfig();
        $skinConfig = TemplateRender::getInstance()->getConfig();
        $dbConfig = Database::getInstance()->getConfig();

        $this->dbEngines = Engine::getEngines();
        $this->skins = TemplateRender::getInstance()->getSkins();
        $this->skin = $skinConfig['skin'] ?? $this->skins[0] ?? '';
        $this->languages = Translator::getInstance()->getAvailableLanguages();
        $this->language = $langConfig['language'] ?? $this->languages[0] ?? '';

        $this->dbEngineName = $dbConfig['dbEngineName'] ?? $this->dbEngines[0] ?? '';
        $this->dbConfig['dbUser'] = $dbConfig['dbUser'] ?? 'root';
        $this->dbConfig['dbPass'] = $dbConfig['dbPass'] ?? '';
        $this->dbConfig['dbName'] = $dbConfig['dbName'] ?? 'alxarafe';
        $this->dbConfig['dbHost'] = $dbConfig['dbHost'] ?? 'localhost';
        $this->dbConfig['dbPrefix'] = $dbConfig['dbPrefix'] ?? '';
        $this->dbConfig['dbPort'] = $dbConfig['dbPort'] ?? '';
    }
}
