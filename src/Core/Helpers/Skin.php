<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Base\View;
use Twig_Environment;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax;
use Twig_Extension_Debug;
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
        return (self::$templatesFolder != null);
    }

    /**
     * Returns true if a template has been specified.
     *
     * @return bool
     */
    public static function hasTemplate(): bool
    {
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
        $path = constant('BASE_PATH') . self::SKINS_FOLDER;
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
     * Set a skin.
     *
     * @param $skin
     */
    public static function setSkin($skin): void
    {
        if ($skin != self::$currentSkin) {
            self::$currentSkin = $skin;
            self::setTemplatesFolder($skin);
        }
        Debug::addMessage('messages', "Setting '$skin' skin");
    }

    /**
     * Set a template.
     *
     * @param $template
     */
    public static function setTemplate($template): void
    {
        self::$currentTemplate = $template;
        Debug::addMessage('messages', "Setting '$template' template");
    }

    /**
     * Return the template uri path.
     *
     * @return string
     */
    public static function getTemplatesUri(): string
    {
        return constant('BASE_URI') . self::$templatesFolder;
    }

    /**
     * Return the template engine.
     *
     * @return string
     */
    public static function getTemplatesEngine(): string
    {
        return self::$templatesEngine;
    }

    /**
     * Set another template engine.
     *
     * @param $engine
     */
    public static function setTemplatesEngine($engine): void
    {
        self::$templatesEngine = $engine;
    }

    /**
     * Returns the common template uri path.
     *
     * @return string
     */
    public static function getCommonTemplatesUri(): string
    {
        return constant('BASE_URI') . self::$commonTemplatesFolder;
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
        $details = [
            'Templates engine: ' . self::$templatesEngine,
            'Templates folder: ' . self::$templatesFolder,
            'Templates common folder: ' . self::$commonTemplatesFolder,
            'Current template: ' . self::$currentTemplate,
        ];
        Debug::addMessage('messages', '<pre>' . var_export($details, true) . '</pre>');

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
        $return = null;
        Debug::startTimer('render', 'Rendering time');

        switch (self::$templatesEngine) {
            case 'twig':
                $templateVars = self::getTemplateVars($vars);
                $loader = new Twig_Loader_Filesystem(self::getPaths());
                $twig = new Twig_Environment($loader, self::getOptions());
                self::addSkinExtensions($twig);
                try {
                    $return = $twig->render(self::getTemplate(), $templateVars);
                } catch (Twig_Error_Loader $e) {
                    self::errorDetails($e);
                } catch (Twig_Error_Runtime $e) {
                    self::errorDetails($e);
                } catch (Twig_Error_Syntax $e) {
                    self::errorDetails($e);
                }
                break;
            default:
                $return = self::$templatesEngine . ' engine is not supported!';
        }

        Debug::stopTimer('render');
        return $return;
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

    /**
     * Add extensions to skin render.
     *
     * @param Twig_Environment $twig
     *
     * @return void
     */
    private static function addSkinExtensions($twig): void
    {
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
        $template = (self::getTemplateVars()['template'] ?? Skin::$currentTemplate) . '.twig';
        Debug::addMessage('messages', "Using '$template' template");
        return $template;
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
        return array_merge($vars, [
            '_REQUEST' => $_REQUEST,
            '_GET' => $_GET,
            '_POST' => $_POST,
            'GLOBALS' => $GLOBALS,
        ]);
    }

    /**
     * Returns a list of options.
     *
     * @return array
     */
    private static function getOptions(): array
    {
        $options = [];
        $options['debug'] = (defined('DEBUG') && constant('DEBUG') == true);
        if (defined('CACHE') && constant('CACHE') == true) {
            $options['cache'] = (constant('BASE_PATH') ?? '') . '/cache/twig';
        }
        return $options;
    }

    /**
     * Returns a list of available paths.
     *
     * @return array
     */
    private static function getPaths(): array
    {
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
        Debug::addMessage('messages', 'Using: <pre>' . print_r($usePath, true) . '</pre>');
        return $usePath;
    }

    /**
     * Return the template folder path.
     *
     * @return string
     */
    public static function getTemplatesFolder(): string
    {
        return constant('BASE_PATH') . self::$templatesFolder;
    }

    /**
     * Establish a new template. The parameter must be only de template name, no the path!
     *
     * @param string $template
     */
    public static function setTemplatesFolder(string $template): void
    {
        self::$templatesFolder = self::SKINS_FOLDER . '/' . trim($template, '/');
        Debug::addMessage('messages', "Setting '" . self::$templatesFolder . "' templates folder");
    }

    /**
     * Return the common template folder path.
     *
     * @return string
     */
    public static function getCommonTemplatesFolder(): string
    {
        return constant('BASE_PATH') . self::$commonTemplatesFolder;
    }

    /**
     * Sets the common templates folder.
     *
     * @param string $templatesFolder
     */
    public static function setCommonTemplatesFolder(string $templatesFolder): void
    {
        Debug::addMessage('messages', "Setting '$templatesFolder' common templates folder");
        self::$commonTemplatesFolder = $templatesFolder;
    }
}
