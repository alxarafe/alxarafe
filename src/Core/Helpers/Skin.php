<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Base\View;
use Alxarafe\Providers\DebugTool;
use Alxarafe\Providers\FlashMessages;
use Alxarafe\Providers\Logger;
use Twig_Environment;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

/**
 * Class Skin
 *
 * @package Alxarafe\Helpers
 */
class Skin
{

    /**
     * Default: It is the folder that includes the templates.
     * Each template will be a folder whose name will be the one that will appear in the template selector.
     */
    const SKINS_FOLDER = "/html/templates";

    /**
     * Default: Folder of the common code.
     * It is where the common files will be placed to all the templates. If a file is not found in the template, then
     * it will be searched in COMMON_FOLDER.
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
     * It is the folder where the different skins are located. Each skin uses a folder defined by $template, which
     * contains the templates that will be used.
     *
     * @var string
     */
    private static $templatesFolder;

    /**
     * Indicates the folder where the files common to all the templates are located.
     * A file will be searched first in the $templatesFolder, and if it is not, it will be searched in this
     * $commonTemplatesFolder.
     *
     * @var string
     */
    private static $commonTemplatesFolder;

    /**
     * Sets the view class that will be used.
     *
     * @param View $view
     */
    public static function setView(View $view): void
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        self::$view = $view;
        if (!self::hasTemplatesFolder()) {
            self::setTemplatesFolder('default');
        }
    }

    /**
     * Return the templates folder.
     *
     * @return bool
     */
    public static function hasTemplatesFolder(): bool
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        return (self::$templatesFolder != null);
    }

    /**
     * Returns true if a template has been specified.
     *
     * @return bool
     */
    public static function hasTemplate(): bool
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        return (self::$currentTemplate != null);
    }

    /**
     * Returns an array with the list of skins (folders inside the folder specified for the templates).
     *
     * TODO: Possible misuse of constant and variable to specify the template folder.
     *
     * @return array
     */
    public static function getSkins(): array
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        $path = constant('BASE_PATH') . self::SKINS_FOLDER;
        if (!is_dir($path)) {
            FlashMessages::getInstance()::setError("Directory '$path' does not exists!");
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
     * Set a skin.
     *
     * @param $skin
     */
    public static function setSkin($skin): void
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        if ($skin != self::$currentSkin) {
            self::$currentSkin = $skin;
            self::setTemplatesFolder($skin);
        }
        DebugTool::getInstance()->addMessage('messages', "Setting '$skin' skin");
    }

    /**
     * Set a template.
     *
     * @param $template
     */
    public static function setTemplate($template): void
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        self::$currentTemplate = $template;
        DebugTool::getInstance()->addMessage('messages', "Setting '$template' template");
    }

    /**
     * Return the template uri path.
     *
     * @return string
     */
    public static function getTemplatesUri(): string
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        return baseUrl(self::$templatesFolder);
    }

    /**
     * Return the template engine.
     *
     * @return string
     */
    public static function getTemplatesEngine(): string
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        return self::$templatesEngine;
    }

    /**
     * Set another template engine.
     *
     * @param $engine
     */
    public static function setTemplatesEngine($engine): void
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        self::$templatesEngine = $engine;
    }

    /**
     * Returns the common template uri path.
     *
     * @return string
     */
    public static function getCommonTemplatesUri(): string
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        return baseUrl(self::$commonTemplatesFolder);
    }

    /**
     * Render the page.
     *
     * @param array $vars
     *
     * @return string
     */
    public static function render(array $vars): string
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        $details = [
            'Templates engine: ' . self::$templatesEngine,
            'Templates folder: ' . self::$templatesFolder,
            'Templates common folder: ' . self::$commonTemplatesFolder,
            'Current template: ' . self::$currentTemplate,
        ];
        DebugTool::getInstance()->addMessage('messages', '<pre>' . var_export($details, true) . '</pre>');

        return self::renderIt($vars);
    }

    /**
     * Render the page.
     *
     * @param array $vars
     *
     * @return string
     */
    private static function renderIt(array $vars): string
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        $return = null;
        DebugTool::getInstance()->startTimer('renderer', 'Rendering time');

        switch (self::$templatesEngine) {
            case 'twig':
                $templateVars = self::getTemplateVars($vars);
                $loader = new Twig_Loader_Filesystem(self::getPaths());
                $twig = new Twig_Environment($loader, self::getOptions());

                // Add support for additional filters
                // Is instanciated because maybe need to set something on construct
                $twigFilters = new Twig_SimpleFilter('TwigFilters', function ($method, $params = []) {
                    return (new TwigFilters)->$method($params);
                });
                $twig->addFilter($twigFilters);

                // Add support for additional functions
                // Is instanciated because maybe need to set something on construct
                $twigFunctions = new Twig_SimpleFunction('TwigFunctions', function ($method, $params = []) {
                    return (new TwigFunctions)->$method($params);
                });
                $twig->addFunction($twigFunctions);

                self::addSkinExtensions($twig);
                try {
                    $return = $twig->render(self::getTemplate(), $templateVars);
                } catch (Twig_Error_Loader $e) {
                    Logger::getInstance()::exceptionHandler($e);
                    self::errorDetails($e);
                } catch (Twig_Error_Runtime $e) {
                    Logger::getInstance()::exceptionHandler($e);
                    self::errorDetails($e);
                } catch (Twig_Error_Syntax $e) {
                    Logger::getInstance()::exceptionHandler($e);
                    self::errorDetails($e);
                }
                break;
            default:
                $return = self::$templatesEngine . ' engine is not supported!';
        }

        DebugTool::getInstance()->stopTimer('renderer');
        return $return;
    }

    /**
     * Return a list of template vars, merged with $vars,
     *
     * @param $vars
     *
     * @return array
     */
    private static function getTemplateVars(array $vars = []): array
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        return array_merge($vars, [
            '_REQUEST' => $_REQUEST,
            '_GET' => $_GET,
            '_POST' => $_POST,
            'GLOBALS' => $GLOBALS,
        ]);
    }

    /**
     * Returns a list of available paths.
     *
     * @return array
     */
    private static function getPaths(): array
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        $usePath = [];
        $paths = [
            self::getTemplatesFolder(),
            self::getCommonTemplatesFolder(),
            constant('DEFAULT_TEMPLATES_FOLDER'),
        ];
        // Only use really existing path
        foreach ($paths as $path) {
            if (file_exists($path)) {
                $usePath[] = $path;
            }
        }
        DebugTool::getInstance()->addMessage('messages', 'Using: <pre>' . print_r($usePath, true) . '</pre>');
        return $usePath;
    }

    /**
     * Return the template folder path.
     *
     * @return string
     */
    public static function getTemplatesFolder(): string
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        return constant('BASE_PATH') . self::$templatesFolder;
    }

    /**
     * Establish a new template. The parameter must be only de template name, no the path!
     *
     * @param string $template
     */
    public static function setTemplatesFolder(string $template): void
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        self::$templatesFolder = self::SKINS_FOLDER . '/' . trim($template, '/');
        DebugTool::getInstance()->addMessage('messages', "Setting '" . self::$templatesFolder . "' templates folder");
    }

    /**
     * Return the common template folder path.
     *
     * @return string
     */
    public static function getCommonTemplatesFolder(): string
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        return constant('BASE_PATH') . self::$commonTemplatesFolder;
    }

    /**
     * Sets the common templates folder.
     *
     * @param string $templatesFolder
     */
    public static function setCommonTemplatesFolder(string $templatesFolder): void
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        DebugTool::getInstance()->addMessage('messages', "Setting '$templatesFolder' common templates folder");
        self::$commonTemplatesFolder = $templatesFolder;
    }

    /**
     * Returns a list of options.
     *
     * @return array
     */
    private static function getOptions(): array
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        $options = [];
        $options['debug'] = (defined('DEBUG') && constant('DEBUG') == true);
        if (defined('CACHE') && constant('CACHE') == true) {
            $options['cache'] = (constant('BASE_PATH') ?? '') . '/cache/twig';
        }
        return $options;
    }

    /**
     * Add extensions to skin render.
     *
     * @param Twig_Environment $twig
     *
     * @return void
     */
    private static function addSkinExtensions($twig): void
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        if (self::getOptions()['debug']) {
            // Only available in debug mode
            $twig->addExtension(new Twig_Extension_Debug());
        }
        // Always available
    }

    /**
     * Returns the template file name.
     *
     * @return string
     */
    private static function getTemplate(): string
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        $template = (self::getTemplateVars()['template'] ?? Skin::$currentTemplate) . '.twig';
        DebugTool::getInstance()->addMessage('messages', "Using '$template' template");
        return $template;
    }

    /**
     * Dump details on fail.
     *
     * @param      $e
     * @param bool $return
     *
     * @return string|void
     */
    private static function errorDetails($e, $return = false)
    {
        trigger_error("Replace this use with TemplateRender class", E_DEPRECATED);
        $msg = '<h3>Fatal error</h3>';
        $msg .= '<b>File:</b> ' . $e->getFile() . '<br/>';
        $msg .= '<b>Line:</b> ' . $e->getLine() . '<br/>';
        $msg .= '<b>Message:</b> ' . $e->getMessage() . '<br/>';

        if ($return) {
            return $msg;
        } else {
            echo $msg;
        }
    }
}
