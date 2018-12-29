<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Alxarafe\Base\View;

class Skin
{

    const SKINS_FOLDER = "/views/templates";
    const COMMON_FOLDER = "/views/common";

    /**
     * It is the name of the template that is being used.
     *
     * Es el nombre de la plantilla que va a dibujarse.
     *
     * @var string
     */
    private static $currentTemplate;

    /**
     * Es el nombre del skin que se va a usar.
     *
     * @var string
     */
    private static $currentSkin;

    /**
     * By default, only the 'twig' template engine is used.
     *
     * Es el nombre del motor de plantillas (de momento sólo twig)
     *
     * @var string
     */
    private static $templatesEngine;

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
    private static $templatesFolder;

    /**
     * Indicates the folder where the files common to all the templates are located.
     * A file will be searched first in the $templatesFolder, and if it is not, it
     * will be searched in this $commonTemplatesFolder.
     *
     * Es la carpeta que contiene las plantillas comunes a todos los skins.
     * Primero se buscará en templatesFolder y si no está se buscará aquí.
     *
     * @var string
     */
    private static $commonTemplatesFolder;

    /**
     * Contains an instance of the view, or the generic view if one is not specified.
     *
     * @var View
     */
    public static $view;

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

    public static function hasTemplate(): bool
    {
        return (self::$currentTemplate != null);
    }

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

    public static function setSkin($skin)
    {
        if ($skin != self::$currentSkin) {
            self::$currentSkin = $skin;
            self::setTemplatesFolder($skin);
        }
        Debug::addMessage('messages', "Setting '$skin' skin");
    }

    public static function setTemplate($template)
    {
        self::$currentTemplate = $template;
        Debug::addMessage('messages', "Setting '$template' template");
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

    public static function getTemplatesFolder(): string
    {
        return self::$templatesFolder;
    }

    /**
     * Establish a new template. The parameter must be only de template name, no the path!
     *
     * @param string $template
     */
    public static function setTemplatesFolder(string $template)
    {
        self::$templatesFolder = BASE_PATH . self::SKINS_FOLDER . ('/' . trim($template, '/'));
        Debug::addMessage('messages', "Setting '" . self::$templatesFolder . "' templates folder");
    }

    public static function getTemplatesEngine(): string
    {
        return self::$templatesEngine;
    }

    public static function setTemplatesEngine($engine)
    {
        self::$templatesEngine = $engine;
    }

    public static function getCommonTemplatesFolder(): string
    {
        return self::$commonTemplatesFolder;
    }

    public static function setCommonTemplatesFolder(string $templatesFolder)
    {
        Debug::addMessage('messages', "Setting '$templatesFolder' common templates folder");
        self::$commonTemplatesFolder = $templatesFolder;
    }

    /**
     * TODO:
     *
     * @param array $vars
     *
     * @return string
     * @throws \DebugBar\DebugBarException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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
     * TODO:
     *
     * @param array $vars
     *
     * @return string
     * @throws \DebugBar\DebugBarException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    private static function renderIt(array $vars): string
    {
        Debug::startTimer('render', 'Rendering time');

        switch (self::$templatesEngine) {
            case 'twig' :
                $templateVars = array_merge($vars, [
                    '_REQUEST' => $_REQUEST,
                    '_GET' => $_GET,
                    '_POST' => $_POST,
                    'GLOBALS' => $GLOBALS,
                ]);

                $paths = [
                    self::$templatesFolder,
                    Config::getVar('commonTemplatesFolder') ?? BASE_PATH . self::COMMON_FOLDER,
                    DEFAULT_TEMPLATES_FOLDER,
                ];

                Debug::addMessage('messages', 'Searching:' . print_r($paths, true));

                // Only use really existing path
                $usePath = [];
                foreach ($paths as $path) {
                    if (file_exists($path)) {
                        $usePath[] = $path;
                    }
                }

                Debug::addMessage('messages', 'Using:' . print_r($usePath, true));

                $loader = new Twig_Loader_Filesystem($usePath);
                $options = defined('DEBUG') && DEBUG ? ['debug' => true] : ['cache' => BASE_PATH . '/tmp' . RANDOM_PATH_NAME . '.Twig'];

                $twig = new Twig_Environment($loader, $options);

                $template = (isset($templateVars['template']) ? $templateVars['template'] : Skin::$currentTemplate) . '.twig';
                Debug::addMessage('messages', "Using '$template' template");
                $return = $twig->render($template, $templateVars);
                break;
            default :
                $return = self::$templatesEngine . ' engine is not supported!';
        }
        Debug::stopTimer('render');
        return $return;
    }
}
