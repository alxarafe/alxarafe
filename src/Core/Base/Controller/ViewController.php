<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Alxarafe\Base\Controller;

use Alxarafe\Base\Config;
use Alxarafe\Base\Controller\Trait\ViewTrait;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;

/**
 * Class ViewController.
 * Adds view and template support to the generic controller.
 *
 * @package Alxarafe\Base
 */
abstract class ViewController extends GenericController
{
    use ViewTrait;

    /**
     * Configuration object.
     */
    public ?object $config = null;

    /**
     * Debug mode flag.
     */
    public bool $debug = true;

    /**
     * Initializes templates, configuration, and language settings.
     */
    public function __construct(?string $action = null, mixed $data = null)
    {
        parent::__construct($action, $data);

        $this->setDefaultTemplate();
        $this->config = Config::getConfig();

        // Nullsafe operator to prevent errors if config is missing
        Trans::setLang($this->config?->main?->language ?? Trans::FALLBACK_LANG);
    }

    /**
     * Renders the debug header if enabled.
     */
    public function getRenderHeader(): string
    {
        if (!$this->debug) {
            return "\n\n";
        }
        return Debug::getRenderHeader();
    }

    /**
     * Renders the debug footer if enabled.
     */
    public function getRenderFooter(): string
    {
        if (!$this->debug) {
            return "\n\n";
        }
        return Debug::getRenderFooter();
    }
}