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
use Alxarafe\Lib\Messages;
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
    /**
     * Debug mode flag.
     */
    public bool $debug = true;

    /**
     * Page title.
     */
    public string $title = '';

    /**
     * Alerts/Messages to display.
     */
    /**
     * Alerts/Messages to display.
     */
    public array $alerts = [];

    /**
     * Initializes templates, configuration, and language settings.
     */
    public function __construct(?string $action = null, mixed $data = null)
    {
        parent::__construct($action, $data);

        $this->config = Config::getConfig();

        // Register templates path
        if (defined('APP_PATH')) {
            $appPath = constant('APP_PATH');

            // 1. App specific templates
            $this->addTemplatesPath($appPath . '/templates');

            // 2. Active Theme templates (Highest priority)
            $theme = Config::getConfig()?->main->theme ?? 'default';
            if ($theme !== 'default') {
                $themePath = $appPath . '/themes/' . $theme . '/templates';
                if (is_dir($themePath)) {
                    $this->addTemplatesPath($themePath);
                }
            }
        }

        // 3. Framework base templates (Fallback)
        if (defined('ALX_PATH')) {
            $alxPath = constant('ALX_PATH');
            $baseTplPath = $alxPath . '/templates';
            if (!is_dir($baseTplPath) && defined('APP_PATH')) {
                $baseTplPath = constant('APP_PATH') . '/templates';
            }
            if (is_dir($baseTplPath)) {
                $this->addTemplatesPath($baseTplPath);
            }
        }

        // Initialize language only if not already set by dispatcher
        if (!\Alxarafe\Lib\Trans::wasSet()) {
            \Alxarafe\Lib\Trans::setLang($this->config->main->language ?? \Alxarafe\Lib\Trans::FALLBACK_LANG);
        }

        // Inject $me as the controller itself, preserving property access
        $this->addVariable('me', $this);

        $this->title = static::getModuleName() . ' - ' . static::getControllerName();

        // Inject menus - MenuManager handles visibility (Auth/Guest)
        // Inject menus - MenuManager handles visibility (Auth/Guest)
        $this->addVariable('main_menu', \CoreModules\Admin\Service\MenuManager::get('main_menu'));
        $this->addVariable('user_menu', \CoreModules\Admin\Service\MenuManager::get('user_menu'));
    }

    /**
     * Proxy for translation method to allow $me::_() or $this::_() in templates
     */
    public static function _(string $key, array $replace = [], ?string $domain = null): string
    {
        return Trans::_($key, $replace, $domain);
    }

    /**
     * Proxy for instance calls $me->_()
     */
    public function __call($name, $arguments)
    {
        if ($name === '_') {
            return self::_($arguments[0], $arguments[1] ?? [], $arguments[2] ?? null);
        }
        return null;
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

    /**
     * Hook executed after the main action.
     */
    #[\Override]
    public function afterAction(): bool
    {
        // Load messages before rendering
        $this->alerts = Messages::getMessages();

        // Automatically render the default template if one is set
        echo $this->render();
        return true;
    }
}
