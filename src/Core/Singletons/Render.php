<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Core\Singletons;

use DebugBar\DebugBarException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class Skin
 *
 * @package Alxarafe\Helpers
 */
abstract class Render
{

    /**
     * The skins folder contains any folder for each skin, which defines the css, js, html files and images that
     * provide a visual aspect to the application.
     */
    const SKINS_DIR = '/html/skins';

    /**
     * The common folder basically contains the html and js files that provide the operation of the page, they
     * could be supported by other files of the skin, to modify the visual aspect.
     *
     * The system search any file in the skin, and if it not exists, search it in common.
     */
    const COMMON_DIR = '/html/common';

    /**
     * It is the name of the template that is being used.
     *
     * The template is the name of the file to load. It will be searched first in the skin, and if it is not
     * found, then in common.
     *
     * First, search SKIN_DIR + $currentSkin + $currentTemplate
     * If not found, seach in COMMON_DIR + $currentTemplate
     *
     * @var string
     */
    private static string $currentTemplate;

    /**
     * It is the name of the skin that is being used.
     *
     * The files are searched first in SKIN_DIR + $currentSkin
     *
     * @var string
     */
    private static string $currentSkin;

    /**
     * It is the skin, that is, the folder that contains the templates.
     *
     * Es el nombre del fichero que contiene las plantillas del tema.
     * Será el primer lugar donde se buscará $currentTemplate.
     *
     * It is the folder where the different skins are located. Each skin uses a
     * folder defined by $template, which contains the templates that will be used.
     *
     * @var string
     */
    private static string $templatesFolder;

    private $debug;

    public static function load(string $index = 'main')
    {
        self::setSkin('default');
    }

    /**
     * Return the templates folder
     *
     * @return bool
     * @deprecated ¿In use?
     */
    public static function hasTemplatesFolder(): bool
    {
        return (self::$templatesFolder != null);
    }

    /**
     * TODO: Undocumented
     *
     * @return bool
     */
    public static function hasTemplate(): bool
    {
        return (self::$currentTemplate != null);
    }

    /**
     * Returns an array with the available skins.
     *
     * @return array
     */
    public static function getSkins(): array
    {
        $path = BASE_DIR . self::SKINS_DIR;
        if (!is_dir($path)) {
            FlashMessages::setError("Directory '$path' does not exists!");
            return [];
        }
        $skins = scandir($path);
        $ret = [];
        foreach ($skins as $skin) {
            if ($skin != '.' && $skin != '..') {
                $ret[] = $skin;
            }
        }
        return $ret;
    }

    /**
     * TODO: Undocumented
     */
    public static function setSkin($skin)
    {
        if (!isset(self::$currentSkin) || self::$currentSkin !== $skin) {
            self::$currentSkin = $skin;
            self::setTemplatesFolder($skin);
            Debug::message("Setting '$skin' skin");
        }
    }

    /**
     * Establish a new template. The parameter must be only de template name, no the path!
     *
     * @param string $template
     */
    public static function setTemplatesFolder(string $template)
    {
        self::$templatesFolder = self::SKINS_DIR . ('/' . trim($template, '/'));
        Debug::message("Setting '" . self::$templatesFolder . "' templates folder");
    }

    /**
     * TODO: Undocumented
     *
     * @param $template
     *
     * @throws DebugBarException
     */
    public static function setTemplate($template)
    {
        self::$currentTemplate = $template;
        Debug::message("Setting '$template' template");
    }

    /**
     * TODO: Undocumented
     *
     * @param array $vars
     *
     * @return string
     * @throws DebugBarException
     */
    public static function render(array $vars): string
    {
        Debug::message('Templates folder: ' . self::$templatesFolder);
        Debug::message('Current template: ' . self::$currentTemplate);

        return self::renderIt($vars);
    }

    /**
     * TODO: Undocumented
     *
     * @param array $vars
     *
     * @return string
     * @throws DebugBarException
     */
    private static function renderIt(array $vars): string
    {
        Debug::startTimer('render', 'Rendering time');

        $templateVars = array_merge($vars, [
            '_REQUEST' => $_REQUEST,
            '_GET' => $_GET,
            '_POST' => $_POST,
            'GLOBALS' => $GLOBALS,
        ]);

        $usePath = self::getPaths();

        Debug::message('Using:' . print_r($usePath, true));

        //                $loader = new Twig_Loader_Filesystem($usePath);
        $loader = new FilesystemLoader($usePath);
        // TODO: Would not it be better to use a random constant instead of twig.Twig?
        $options = defined('DEBUG') && DEBUG ? ['debug' => true] : ['cache' => (BASE_DIR ?? '') . '/tmp/twig.Twig'];

        //                $twig = new Twig_Environment($loader, $options);
        $twig = new Environment($loader, $options);

        $template = ($templateVars['template'] ?? self::$currentTemplate) . '.twig';
        Debug::message("Using '$template' template");
        try {
            $return = $twig->render($template, $templateVars);
        } catch (LoaderError $e) {
            dump($e);
            die('LoaderError');
        } catch (RuntimeError $e) {
            dump($e);
            die('RuntimeError');
        } catch (SyntaxError $e) {
            dump($e);
            die('SyntaxError');
        }

        //        Debug::stopTimer('render');
        return $return;
    }

    private static function getPaths(): array
    {
        // Only use really existing path
        $usePath = [];
        $paths = [
            BASE_DIR . self::SKINS_DIR,
            self::getTemplatesFolder(),
            self::getCommonTemplatesFolder(),
            //            DEFAULT_TEMPLATES_DIR,
            //            ALXARAFE_TEMPLATES_DIR,
        ];
        foreach ($paths as $path) {
            if (file_exists($path)) {
                $usePath[] = $path;
            }
        }
        return $usePath;
    }

    /**
     * TODO: Undocumented
     *
     * @return string
     */
    public static function getTemplatesFolder(): string
    {
        return constant('BASE_DIR') . self::$templatesFolder;
    }

    /**
     * TODO: Undocumented
     *
     * @return string
     */
    public static function getCommonTemplatesFolder(): string
    {
        return BASE_DIR . self::COMMON_DIR;
    }

    /**
     * ¿In use?
     *
     * @param string $string
     *
     * @return string
     */
    public function getResource(string $string): string
    {
        foreach ($this->getPathsUri() as $path) {
            if (file_exists($path['path'] . $string)) {
                Debug::message('Return: ' . $path['uri'] . $string);
                return $path['uri'] . $string;
            }
        }

        Debug::message('Not found: ' . $string);
        return $string;
    }

    /**
     * ¿In use?
     *
     * @return array
     */
    private function getPathsUri(): array
    {
        // Only use really existing path
        $usePath = [];
        if (file_exists($this->getTemplatesFolder())) {
            $usePath[] = ['path' => $this->getTemplatesFolder(), 'uri' => $this->getTemplatesUri()];
        }
        if (file_exists($this->getCommonTemplatesFolder())) {
            $usePath[] = ['path' => $this->getCommonTemplatesFolder(), 'uri' => $this->getCommonTemplatesUri()];
        }
        //        if (file_exists(DEFAULT_TEMPLATES_DIR)) {
        //            $usePath[] = ['path' => DEFAULT_TEMPLATES_DIR, 'uri' => DEFAULT_TEMPLATES_URI];
        //        }
        //        if (file_exists(ALXARAFE_TEMPLATES_DIR)) {
        //            $usePath[] = ['path' => ALXARAFE_TEMPLATES_DIR, 'uri' => ALXARAFE_TEMPLATES_URI];
        //        }
        return $usePath;
    }

    /**
     * Returns the URI of the templates folder.
     * Search any file, first at this location.
     *
     * @return string
     */
    public static function getTemplatesUri(): string
    {
        return BASE_URI . self::$templatesFolder;
    }

    /**
     * Returns the URI of the common templates folder.
     * If a file does not exist in templates folder, search it in this folder.
     *
     * @return string
     */
    public function getCommonTemplatesUri(): string
    {
        return BASE_URI . self::COMMON_DIR;
    }
}
