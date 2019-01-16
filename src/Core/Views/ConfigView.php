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
 * Class Login
 *
 * @package Alxarafe\Views
 */
class ConfigView extends View
{

    /**
     * TODO: Undocumented
     *
     * @var array
     */
    public $dbEngines;

    /**
     * TODO: Undocumented
     *
     * @var mixed|string
     */
    public $dbEngineName;

    /**
     * TODO: Undocumented
     *
     * @var array
     */
    public $skins;

    /**
     * TODO: Undocumented
     *
     * @var
     */
    public $skin;

    /**
     * TODO: Undocumented
     *
     * @var
     */
    public $dbConfig;

    /**
     * Login constructor.
     *
     * @param $ctrl
     */
    public function __construct($ctrl)
    {
        Skin::setTemplate('config');

        parent::__construct($ctrl);

        $vars = Config::configFileExists() ? Config::loadConfigurationFile() : [];

        $this->dbEngines = Engine::getEngines();
        $this->skins = Skin::getSkins();

        $this->dbEngineName = $vars['dbEngineName'] ?? $this->dbEngines[0] ?? '';
        $this->setVar('skin', $vars['skin'] ?? $this->skins[0] ?? '');

        $this->dbConfig['dbUser'] = $vars['dbUser'] ?? 'root';
        $this->dbConfig['dbPass'] = $vars['dbPass'] ?? '';
        $this->dbConfig['dbName'] = $vars['dbName'] ?? 'alxarafe';
        $this->dbConfig['dbHost'] = $vars['dbHost'] ?? 'localhost';
        $this->dbConfig['dbPrefix'] = $vars['dbPrefix'] ?? '';
        $this->dbConfig['dbPort'] = $vars['dbPort'] ?? '';
    }
}
