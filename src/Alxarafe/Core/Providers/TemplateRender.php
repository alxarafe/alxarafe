<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Helpers\TwigFilters;
use Alxarafe\Core\Helpers\TwigFunctions;
use Alxarafe\Core\Models\Module;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

/**
 * Class TemplateRender
 *
 * @package WebApp\Providers
 */
class TemplateRender
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Folder containing the skins.
     * Each subfolder is a skin (configuration that modifies the visual aspect
     * of the application)
     * Each template will be a folder whose name will be the one that will
     * appear in the template selector.
     */
    const SKINS_FOLDER = 'resources/skins';

    /**
     * Folder containing the different twig templates
     */
    const TEMPLATES_FOLDER = 'resources/templates';

    /**
     * Folder that contains templates common to the entire application, but
     * that can be overwritten.
     */
    const COMMON_TEMPLATES_FOLDER = 'resources/common';

    /**
     * The renderer.
     *
     * @var Twig_Environment
     */
    protected static $twig;

    /**
     * The template to use.
     *
     * @var string|null
     */
    protected static $template;

    /**
     * The skin to use.
     *
     * @var string|null
     */
    protected static $skin;

    /**
     * Indicates the folder where the files common to all the templates are located.
     * A file will be searched first in the $templatesFolder, and if it is not, it will be searched in this
     * $commonTemplatesFolder.
     *
     * @var string
     */
    protected static $commonTemplatesFolder;

    /**
     * It's the name of the skin that is being used.
     *
     * @var string
     */
    private static $currentSkin;

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
     * Contains the template vars.
     *
     * @var array
     */
    private static $templateVars;

    /**
     * TemplateRender constructor.
     */
    public function __construct()
    {
        if (!isset(self::$twig)) {
            $this->initSingleton();
            self::$template = null;
            self::$templateVars = [
                '_REQUEST' => $_REQUEST,
                '_GET' => $_GET,
                '_POST' => $_POST,
                'GLOBALS' => $GLOBALS,
            ];
            $this->setSkin($this->getConfig()['skin'] ?? 'default');
            self::$commonTemplatesFolder = $this->getTemplatesFolder();
            $loader = new Twig_Loader_Filesystem($this->getPaths());
            self::$twig = new Twig_Environment($loader, $this->getOptions());
            $this->addExtensions();
        }
    }

    /**
     * Set a skin.
     *
     * @param string $skin
     */
    public function setSkin(string $skin)
    {
        if ($skin !== self::$currentSkin) {
            DebugTool::getInstance()->addMessage('messages', 'Established skin ' . $skin);
            self::$currentSkin = $skin;
            $this->setTemplatesFolder($skin);
        }
    }

    /**
     * Establish a new template. The parameter must be only de template name, no the path!
     *
     * @param string $template
     */
    public function setTemplatesFolder(string $template)
    {
        self::$templatesFolder = self::SKINS_FOLDER . '/' . trim($template, '/');
    }

    /**
     * Return the template folder path.
     *
     * @return string
     */
    public function getTemplatesFolder(): string
    {
        return basePath(self::$templatesFolder);
        //return basePath(self::TEMPLATES_FOLDER);
    }

    /**
     * Returns a list of available paths.
     *
     * @return array
     */
    public function getPaths(): array
    {
        $usePath = [];
        $paths = [
            $this->getTemplatesFolder(),
            $this->getCommonTemplatesFolder(),
            basePath(self::TEMPLATES_FOLDER),
        ];

        $modules = (new Module())->getEnabledModules();
        foreach (array_reverse($modules) as $module) {
            $paths[] = $module->path . '/' . self::TEMPLATES_FOLDER;
        }

        // Only use really existing path
        foreach ($paths as $path) {
            if (file_exists($path)) {
                $usePath[] = $path;
            }
        }
        return $usePath;
    }

    /**
     * Return the common template folder path.
     *
     * @return string
     */
    public function getCommonTemplatesFolder(): string
    {
        return basePath(self::COMMON_TEMPLATES_FOLDER);
    }

    /**
     * Returns a list of options.
     *
     * @return array
     */
    private function getOptions(): array
    {
        $options = [];
        $options['debug'] = ((defined('DEBUG') && constant('DEBUG')) === true);
        if (defined('CACHE') && constant('CACHE') == true) {
            $options['cache'] = (basePath() ?? '') . '/cache/twig';
        }
        return $options;
    }

    /**
     * Add extensions to skin render.
     *
     * @return void
     */
    private function addExtensions(): void
    {
        // Add support for additional filters
        self::$twig->addExtension(new TwigFilters());

        // Add support for additional functions
        self::$twig->addExtension(new TwigFunctions());

        $isDebug = $this->getOptions()['debug'];
        if ($isDebug) {
            // Only available in debug mode
            self::$twig->addExtension(new Twig_Extension_Debug());
        }
    }

    /**
     * Return this instance.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Return default values
     *
     * @return array
     */
    public static function getDefaultValues(): array
    {
        return ['skin' => 'default'];
    }

    /**
     * Return the full twig environtment.
     *
     * @return Twig_Environment
     */
    public function getTwig(): Twig_Environment
    {
        return self::$twig;
    }

    /**
     * Sets a new twig environment.
     *
     * @param Twig_Environment $twig
     *
     * @return $this
     */
    public function setTwig(Twig_Environment $twig): self
    {
        self::$twig = $twig;
        return $this;
    }

    /**
     * Renders a template.
     *
     * @param array $data An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    public function render(array $data = []): string
    {
        try {
            $render = self::$twig->render($this->getTemplate() ?? 'empty.twig', $this->getTemplateVars($data));
        } catch (\Twig_Error_Loader $e) {
            $render = '';
            // When the template cannot be found
            Logger::getInstance()::exceptionHandler($e);
        } catch (\Twig_Error_Runtime $e) {
            $render = '';
            // When an error occurred during rendering
            Logger::getInstance()::exceptionHandler($e);
        } catch (\Twig_Error_Syntax $e) {
            $render = '';
            // When an error occurred during compilation
            Logger::getInstance()::exceptionHandler($e);
        }
        return $render;
    }

    /**
     * Return the assigned template to use.
     *
     * @return string|null
     */
    public function getTemplate()
    {
        return isset(self::$template) ? self::$template . '.twig' : null;
    }

    /**
     * Return a list of template vars, merged with $vars,
     *
     * @param $vars
     *
     * @return array
     */
    private function getTemplateVars(array $vars = []): array
    {
        return array_merge($vars, self::$templateVars);
    }

    /**
     * Sets the new template to use.
     *
     * @param string|null $template
     *
     * @return $this
     */
    public function setTemplate($template): self
    {
        self::$template = $template;
        return $this;
    }

    /**
     * Returns true if a template has been specified.
     *
     * @return bool
     */
    public function hasTemplate(): bool
    {
        return (self::$template !== null);
    }

    /**
     * Add vars to template vars.
     *
     * @param array $vars
     */
    public function addVars(array $vars = [])
    {
        self::$templateVars = array_merge($vars, self::$templateVars);
    }

    /**
     * Returns an array with the list of skins (folders inside the folder specified for the templates).
     *
     * @return array
     */
    public function getSkins(): array
    {
        $path = basePath(self::SKINS_FOLDER);
        if (!is_dir($path)) {
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
     * Check different possible locations for the file and return the
     * corresponding URI, if it exists.
     *
     * @param string $path
     *
     * @return string
     */
    public function getResourceUri(string $path)
    {
        $paths = [
            $this->getTemplatesFolder() . $path => $this->getTemplatesUri() . $path,
            $this->getCommonTemplatesFolder() . $path => $this->getCommonTemplatesUri() . $path,
            self::TEMPLATES_FOLDER . $path => baseUrl(self::TEMPLATES_FOLDER . $path),
            constant('VENDOR_FOLDER') . $path => constant('VENDOR_URI') . $path,
            basePath($path) => baseUrl($path),
        ];

        foreach ($paths as $fullPath => $uriPath) {
            if (file_exists($fullPath)) {
                return $uriPath;
            }
        }
        return constant('DEBUG') ? '#' . $path . '#' : '';
    }

    /**
     * Return the template folder path from uri.
     *
     * @return string
     */
    public function getTemplatesUri(): string
    {
        return baseUrl(self::$templatesFolder);
        //return baseUrl(self::TEMPLATES_FOLDER);
    }

    /**
     * Return the common template folder path from uri.
     *
     * @return string
     */
    public function getCommonTemplatesUri(): string
    {
        return baseUrl(self::COMMON_TEMPLATES_FOLDER);
    }
}
