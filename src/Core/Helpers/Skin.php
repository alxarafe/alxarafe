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
    const SKINS_FOLDER = "views/templates/";
    const COMMON_FOLDER = "views/common/";

    /**
     * It is the name of the template that is being used.
     * It corresponds to the folder that is inside self::$templateFolders.
     * By default, $templateFolders contains 'Views/Templates/', and self::$default
     * contains 'Default', so the templates used by default will be found
     * in 'Views/Templates/Default'.
     *
     * @var string
     */
    private static $template;

    /**
     * By default, only the 'Twig' template engine is used.
     *
     * @var string
     */
    private static $templatesEngine;

    /**
     * It is the folder where the different skins are located. Each skin uses a
     * folder defined by $ template, which contains the templates that will be used.
     *
     * @var string
     */
    private static $templatesFolder;

    /**
     * Indicates the folder where the files common to all the templates are located.
     * A file will be searched first in the template folder, and if it is not, it
     * will be searched in this folder.
     *
     * @var string
     */
    private static $commonTemplatesFolder;

    /**
     * Skin constructor.
     */
    public function __construct()
    {
        self::$templatesEngine = 'twig';
        self::$template = self::$template ?? 'default';
        self::$templatesFolder = SKINS_FOLDER . self::$template . '/';
    }

    /**
     * Returns the name of the template that is being used.
     *
     * @return string
     */
    public static function getTemplate(): string
    {
        return self::$template;
    }

    /**
     * Establish a new template.
     *
     * @param string $template
     */
    public static function setTemplate(string $template)
    {
        Debug::addMessage('messages', "Setting '$template' template");
        self::$template = $template;
    }
    /**
     * TODO:
     *
     * @return string
     */
    public static function getTemplatesEngine(): string
    {
        return self::$templatesEngine;
    }

    /**
     * TODO:
     *
     * @param string $templatesEngine
     */
    public static function setTemplatesEngine(string $templatesEngine)
    {
        Debug::addMessage('messages', "Setting '$templatesEngine' templates engine");
        self::$templatesEngine = $templatesEngine;
    }

    /**
     * TODO:
     *
     * @return string
     */
    public static function getTemplatesFolder(): string
    {
        return self::$templatesFolder . self::$template . '/';
    }

    public static function getCommonTemplatesFolder(): string
    {
        return self::$commonTemplatesFolder;
    }

    /**
     * TODO:
     *
     * @param string $templateFolder
     */
    public static function setTemplatesFolder(string $templatesFolder)
    {
        Debug::addMessage('messages', "Setting '$templatesFolder' templates folder");
        self::$templatesFolder = $templatesFolder;
    }

    public static function setCommonTemplatesFolder(string $templatesFolder)
    {
        Debug::addMessage('messages', "Setting '$templatesFolder' templates folder");
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
                    'view' => Config::$view,
                    '_REQUEST' => $_REQUEST,
                    '_GET' => $_GET,
                    '_POST' => $_POST,
                    'GLOBALS' => $GLOBALS,
                ]);

                $paths = [
                    self::$templatesFolder,
                    Config::getVar('commonTemplatesFolder') ?? BASE_PATH . COMMON_FOLDER,
                ];
                // Only use really existing path
                $usePath = [];
                foreach ($paths as $path) {
                    if (file_exists($path)) {
                        $usePath[] = $path;
                    }
                }

                $loader = new Twig_Loader_Filesystem($usePath);
                if (!defined('RANDOM_NAME')) {
                    define('RANDOM_NAME', 'ADFASDFASD');
                }
                $options = defined('DEBUG') && DEBUG ? ['debug' => true] : ['cache' => BASE_PATH . '/tmp/' . RANDOM_NAME . '.Twig'];

                $twig = new Twig_Environment($loader, $options);

                $template = (isset($templateVars['template']) ? $templateVars['template'] : Skin::$template) . '.twig';
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
