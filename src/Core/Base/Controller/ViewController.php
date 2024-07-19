<?php

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Base\Controller;

use Alxarafe\Base\Config;
use Alxarafe\Base\Controller\Trait\ViewTrait;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class ViewController. The views controller adds support for views to the generic controller.
 *
 * @package Alxarafe\Base
 */
abstract class ViewController extends GenericController
{
    use ViewTrait;

    public $config = null;
    public $debug = true;

    public function __construct()
    {
        parent::__construct();
        $this->config = Config::getConfig();

        Trans::setLang($this->config->main->language ?? Trans::FALLBACK_LANG);
    }

    public function getRenderHeader(): string
    {
        if (!$this->debug) {
            return "\n<!-- getRenderHeader is disabled -->\n";
        }
        return Debug::getRenderHeader();
    }

    public function getRenderFooter(): string
    {
        if (!$this->debug) {
            return "\n<!-- getRenderFooter is disabled -->\n";
        }
        return Debug::getRenderFooter();
    }
}
