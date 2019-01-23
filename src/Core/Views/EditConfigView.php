<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Views;

use Alxarafe\Base\View;
use Alxarafe\Database\Engine;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;

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
        Skin::setTemplate('editconfig');

        parent::__construct($ctrl);

        $vars = Config::configFileExists() ? Config::loadConfigurationFile() : [];

        $this->dbEngines = Engine::getEngines();
        $this->skins = Skin::getSkins();
        $this->skin = $vars['skin'] ?? $this->skins[0] ?? '';

        $this->dbEngineName = $vars['dbEngineName'] ?? $this->dbEngines[0] ?? '';

        $this->dbConfig['dbUser'] = $vars['dbUser'] ?? 'root';
        $this->dbConfig['dbPass'] = $vars['dbPass'] ?? '';
        $this->dbConfig['dbName'] = $vars['dbName'] ?? 'alxarafe';
        $this->dbConfig['dbHost'] = $vars['dbHost'] ?? 'localhost';
        $this->dbConfig['dbPrefix'] = $vars['dbPrefix'] ?? '';
        $this->dbConfig['dbPort'] = $vars['dbPort'] ?? '';
    }
}
