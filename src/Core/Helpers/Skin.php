<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Base\View;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class Skin
 *
 * @package Alxarafe\Helpers
 */
class Skin
{

    /**
     * Default: It is the folder that includes the templates.
     * Each template will be a folder whose name will be the one that will
     * appear in the template selector.
     */
    const SKINS_FOLDER = "/html/templates";

    /**
     * Default: Folder of the common code.
     * It is where the common files will be placed to all the templates. If a
     * file is not found in the template, then it will be searched in COMMON_FOLDER.
     */
    const COMMON_FOLDER = "/html/common";
    /**
     * Contains an instance of the view, or the generic view if one is not specified.
     *
     * @var View
     */
    public static $view;
    /**
     * It is the name of the template that is being used.
     *
     * @var string
     */
    private static $currentTemplate;
    /**
     * It's the name of the skin that is being used.
     *
     * @var string
     */
    private static $currentSkin;
    /**
     * It's the name of the template engine.
     * For now, only the 'twig' template engine is used.
     *
     * @var string
     */
    private static $templatesEngine;
    /**
     * It is the skin, that is, the folder that contains the templates.
     *
     * It is the folder where the different skins are located. Each skin uses a
     * folder defined by $template, which contains the templates that will be used.
     *
     * @var string
     */
    private static $templatesFolder;
    /**
     * Indicates the folder where the files common to all the templates are located.
     * A file will be searched first in the $templatesFolder, and if it is not, it
     * will be searched in this $commonTemplatesFolder.
     *
     * @var string
     */
    private static $commonTemplatesFolder;

    /**
     * Sets the view class that will be used
     *
     * @param View $view
     */
    public static function setView(View $view)
    {
        self::$view = $view;
        if (!self::hasTemplatesFolder()) {
            self::setTemplatesFolder('default');
        }
    }

    /**
     * Return the templates folder
     *
     * @return bool
     */
    public static function hasTemplatesFolder(): bool
    {
        return (self::$templatesFolder != null);
    }

    /**
     * Returns true if a template has been specified
     *
     * @return bool
     */
    public static function hasTemplate(): bool
    {
        return (self::$currentTemplate != null);
    }

    /**
     * Returns an array with the list of skins (folders inside the folder
     * specified for the templates)
     *
     * TODO: Possible misuse of constant and variable to specify the
     * template folder.
     *
     * @return array
     */
    public static function getSkins(): array
    {
        $path = BASE_PATH . self::SKINS_FOLDER;
        if (!is_dir($path)) {
            Config::setError("Directory '$path' does not exists!");
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
     *
     * @param $skin
     */
    public static function setSkin($skin)
    {
        if ($skin != self::$currentSkin) {
            self::$currentSkin = $skin;
            self::setTemplatesFolder($skin);
        }
        Debug::addMessage('messages', "Setting '$skin' skin");
    }

    /**
     * TODO: Undocumented
     *
     * @param $template
     */
    public static function setTemplate($template)
    {
        self::$currentTemplate = $template;
        Debug::addMessage('messages', "Setting '$template' template");
    }

    /**
     * TODO: Undocumented
     *
     * @return string
     */
    public static function getTemplatesUri(): string
    {
        return BASE_URI . self::$templatesFolder;
    }

    /**
     * TODO: Undocumented
     *
     * @return string
     */
    public static function getTemplatesEngine(): string
    {
        return self::$templatesEngine;
    }

    /**
     * TODO: Undocumented
     *
     * @param $engine
     */
    public static function setTemplatesEngine($engine)
    {
        self::$templatesEngine = $engine;
    }

    /**
     * TODO: Undocumented
     *
     * @return string
     */
    public static function getCommonTemplatesUri(): string
    {
        return BASE_URI . self::$commonTemplatesFolder;
    }

    /**
     * TODO: Undocumented
     *
     * @param array $vars
     *
     * @return string
     */
    public static function render(array $vars): string
    {
        Debug::addMessage('messages', 'Templates engine: ' . self::$templatesEngine);
        Debug::addMessage('messages', 'Templates folder: ' . self::$templatesFolder);
        Debug::addMessage('messages', 'Templates common folder: ' . self::$commonTemplatesFolder);
        Debug::addMessage('messages', 'Current template: ' . self::$currentTemplate);

        return self::renderIt($vars);
    }

    /**
     * TODO: Undocumented
     *
     * @param array $vars
     *
     * @return string
     */
    private static function renderIt(array $vars): string
    {
        $return = null;
        Debug::startTimer('render', 'Rendering time');

        switch (self::$templatesEngine) {
            case 'twig' :
                $templateVars = array_merge($vars, [
                    '_REQUEST' => $_REQUEST,
                    '_GET' => $_GET,
                    '_POST' => $_POST,
                    'GLOBALS' => $GLOBALS,
                ]);

                // Only use really existing path
                $usePath = [];
                if (file_exists(self::getTemplatesFolder())) {
                    $usePath[] = self::getTemplatesFolder();
                }
                if (file_exists(self::getCommonTemplatesFolder())) {
                    $usePath[] = self::getCommonTemplatesFolder();
                }
                if (file_exists(DEFAULT_TEMPLATES_FOLDER)) {
                    $usePath[] = DEFAULT_TEMPLATES_FOLDER;
                }

                Debug::addMessage('messages', 'Using:' . print_r($usePath, true));

                $loader = new Twig_Loader_Filesystem($usePath);
                // TODO: Would not it be better to use a random constant instead of twig.Twig?
                $options = defined('DEBUG') && DEBUG ? ['debug' => true] : ['cache' => (BASE_PATH ?? '') . '/tmp/twig.Twig'];

                $twig = new Twig_Environment($loader, $options);

                $template = (isset($templateVars['template']) ? $templateVars['template'] : Skin::$currentTemplate) . '.twig';
                Debug::addMessage('messages', "Using '$template' template");
                try {
                    $return = $twig->render($template, $templateVars);
                } catch (\Twig_Error_Loader $e) {
                    Debug::addException($e);
                } catch (\Twig_Error_Runtime $e) {
                    Debug::addException($e);
                } catch (\Twig_Error_Syntax $e) {
                    Debug::addException($e);
                }
                break;
            default :
                $return = self::$templatesEngine . ' engine is not supported!';
        }
        Debug::stopTimer('render');
        return $return;
    }

    /**
     * TODO: Undocumented
     *
     * @return string
     */
    public static function getTemplatesFolder(): string
    {
        return BASE_PATH . self::$templatesFolder;
    }

    /**
     * Establish a new template. The parameter must be only de template name, no the path!
     *
     * @param string $template
     */
    public static function setTemplatesFolder(string $template)
    {
        self::$templatesFolder = self::SKINS_FOLDER . '/' . trim($template, '/');
        Debug::addMessage('messages', "Setting '" . self::$templatesFolder . "' templates folder");
    }

    /**
     * TODO: Undocumented
     *
     * @return string
     */
    public static function getCommonTemplatesFolder(): string
    {
        return BASE_PATH . self::$commonTemplatesFolder;
    }

    /**
     * TODO: Undocumented
     *
     * @param string $templatesFolder
     */
    public static function setCommonTemplatesFolder(string $templatesFolder)
    {
        Debug::addMessage('messages', "Setting '$templatesFolder' common templates folder");
        self::$commonTemplatesFolder = $templatesFolder;
    }
}
