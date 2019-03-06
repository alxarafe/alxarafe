<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Helpers\TwigFilters;
use Alxarafe\Core\Helpers\TwigFunctions;
use Alxarafe\Core\Helpers\Utils;
use Alxarafe\Core\Models\Module;
use Twig_Environment;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax;
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
    public const SKINS_FOLDER = 'resources' . DIRECTORY_SEPARATOR . 'skins';

    /**
     * Folder containing the different twig templates
     */
    public const TEMPLATES_FOLDER = 'resources' . DIRECTORY_SEPARATOR . 'templates';

    /**
     * Folder that contains templates common to the entire application, but
     * that can be overwritten.
     */
    public const COMMON_TEMPLATES_FOLDER = 'resources' . DIRECTORY_SEPARATOR . 'common';

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
     * Template loader from filesystem.
     *
     * @var Twig_Loader_Filesystem
     */
    private static $loader;

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
            self::$loader = new Twig_Loader_Filesystem($this->getPaths());
        }
    }

    /**
     * Set a skin.
     *
     * @param string $skin
     */
    public function setSkin(string $skin): void
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
    public function setTemplatesFolder(string $template): void
    {
        self::$templatesFolder = self::SKINS_FOLDER . DIRECTORY_SEPARATOR . trim($template, DIRECTORY_SEPARATOR);
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
            $render = $this->getTwig()->render($this->getTemplate() ?? 'empty.twig', $this->getTemplateVars($data));
        } catch (Twig_Error_Loader $e) {
            $render = '';
            // When the template cannot be found
            Logger::getInstance()::exceptionHandler($e);
        } catch (Twig_Error_Runtime $e) {
            $render = '';
            // When an error occurred during rendering
            Logger::getInstance()::exceptionHandler($e);
        } catch (Twig_Error_Syntax $e) {
            $render = '';
            // When an error occurred during compilation
            Logger::getInstance()::exceptionHandler($e);
        }
        return $render;
    }

    /**
     * Return the full twig environtment.
     *
     * @return Twig_Environment
     */
    private function getTwig(): Twig_Environment
    {
        self::$twig = new Twig_Environment(self::$loader, $this->getOptions());
        $this->addExtensions();
        $this->loadPaths();
        return self::$twig;
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
        if (defined('CACHE') && constant('CACHE') === true) {
            $options['cache'] = basePath(DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'twig');
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
     * Load paths, including modules.
     */
    private function loadPaths(): void
    {
        // Adds without namespace
        try {
            self::$loader->addPath($this->getTemplatesFolder());
            self::$loader->addPath($this->getCommonTemplatesFolder());
            self::$loader->addPath(basePath(self::TEMPLATES_FOLDER));
            // Adds with namespace Core
            self::$loader->addPath($this->getTemplatesFolder(), 'Core');
            self::$loader->addPath($this->getCommonTemplatesFolder(), 'Core');
            self::$loader->addPath(basePath(self::TEMPLATES_FOLDER), 'Core');

            $modules = (new Module())->getEnabledModules();
            foreach (array_reverse($modules) as $module) {
                $modulePath = basePath($module->path . DIRECTORY_SEPARATOR . self::TEMPLATES_FOLDER);
                if (is_dir($modulePath)) {
                    // Adds without namespace
                    self::$loader->prependPath($modulePath);
                    // Adds with namespace Module + $modulePath
                    self::$loader->prependPath($modulePath, 'Module' . $modulePath);
                }
            }
        } catch (Twig_Error_Loader $e) {
            Logger::getInstance()::exceptionHandler($e);
        }
    }

    /**
     * Return the assigned template to use.
     *
     * @return string|null
     */
    public function getTemplate(): ?string
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
    public function addVars(array $vars = []): void
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
        $skins = Utils::scandir($path);
        $ret = [];
        foreach ($skins as $skin) {
            $ret[] = $skin->getFilename();
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
    public function getResourceUri(string $path): string
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
