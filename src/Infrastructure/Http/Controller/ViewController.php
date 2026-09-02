<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
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

namespace Alxarafe\Infrastructure\Http\Controller;

use Alxarafe\Infrastructure\Persistence\Config;
use Alxarafe\Infrastructure\Http\Controller\Trait\ViewTrait;
use Alxarafe\Infrastructure\Lib\Messages;
use Alxarafe\Infrastructure\Lib\Trans;
use Alxarafe\Infrastructure\Tools\Debug;

/**
 * Class ViewController.
 * Adds view and template support to the generic controller.
 *
 * @package Alxarafe\Infrastructure\Persistence
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
     * Page title.
     */
    public string $title = '';

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

        // Register templates paths in priority order.
        // Theme templates (App and Package) take precedence over generic templates,
        // so a theme can override the general layout without app-level duplicates.
        if (defined('APP_PATH')) {
            $appPath = constant('APP_PATH');
        } else {
            $appPath = null;
        }
        $alxPath = defined('ALX_PATH') ? constant('ALX_PATH') : null;

        // 1. Active Theme templates (Highest priority)
        // Convention: {base}/templates/themes/{theme}/ (Blade layout/partials override)
        $theme = Config::getConfig()?->main->theme ?? 'default';
        if ($theme !== 'default') {
            if ($appPath !== null && is_dir($appPath . '/templates/themes/' . $theme)) {
                $this->addTemplatesPath($appPath . '/templates/themes/' . $theme);
            }
            if ($alxPath !== null && is_dir($alxPath . '/templates/themes/' . $theme)) {
                $this->addTemplatesPath($alxPath . '/templates/themes/' . $theme);
            }
        }

        // 2. App specific templates
        if ($appPath !== null) {
            $this->addTemplatesPath($appPath . '/templates');
        }

        // 3. Framework base templates (Fallback)
        if ($alxPath !== null) {
            $baseTplPath = $alxPath . '/templates';
            if (!is_dir($baseTplPath) && $appPath !== null) {
                $baseTplPath = $appPath . '/templates';
            }
            if (is_dir($baseTplPath)) {
                $this->addTemplatesPath($baseTplPath);
            }
        }

        // Initialize language only if not already set by dispatcher
        if (!Trans::wasSet()) {
            Trans::setLang($this->config->main->language ?? Trans::FALLBACK_LANG);
        }

        // Inject $me as the controller itself, preserving property access
        $this->addVariable('me', $this);

        $moduleKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $this->getModuleName()));
        $translatedModule = Trans::_($moduleKey);
        if ($translatedModule === $moduleKey) {
            $translatedModule = $this->getModuleName();
        }

        $controllerKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $this->getControllerName()));
        $translatedController = Trans::_($controllerKey);
        if ($translatedController === $controllerKey) {
            $translatedController = $this->getControllerName();
        }

        $this->title = $translatedModule . ' - ' . $translatedController;

        // Inject menus - MenuManager handles visibility (Auth/Guest)
        if (class_exists('\Modules\Admin\Service\MenuManager')) {
            $this->addVariable('main_menu', \Modules\Admin\Service\MenuManager::get('main_menu'));
            $this->addVariable('user_menu', \Modules\Admin\Service\MenuManager::get('user_menu'));
        }
    }

    /**
     * Helper for translations in templates using $me->trans().
     */
    public function trans(string $key, array $replace = [], ?string $domain = null): string
    {
        return Trans::_($key, $replace, $domain);
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
    public function afterAction(): bool
    {
        // Load messages before rendering
        $this->alerts = Messages::getMessages();

        // Automatically render the default template if one is set
        echo $this->render();
        return true;
    }
}
