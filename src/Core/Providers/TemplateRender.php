<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Alxarafe\Helpers\TwigFilters;
use Alxarafe\Helpers\TwigFunctions;
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
     * Default: It is the folder that includes the templates.
     * Each template will be a folder whose name will be the one that will appear in the template selector.
     */
    const SKINS_FOLDER = "/resources/skins";

    /**
     * The renderer.
     *
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * The template to use.
     *
     * @var string|null
     */
    protected $template;

    /**
     * The skin to use.
     *
     * @var string|null
     */
    protected $skin;

    /**
     * Indicates the folder where the files common to all the templates are located.
     * A file will be searched first in the $templatesFolder, and if it is not, it will be searched in this
     * $commonTemplatesFolder.
     *
     * @var string
     */
    protected $commonTemplatesFolder;

    /**
     * It's the name of the skin that is being used.
     *
     * @var string
     */
    private $currentSkin;

    /**
     * It is the skin, that is, the folder that contains the templates.
     *
     * It is the folder where the different skins are located. Each skin uses a folder defined by $template, which
     * contains the templates that will be used.
     *
     * @var string
     */
    private $templatesFolder;

    /**
     * Contains the template vars.
     *
     * @var array
     */
    private $templateVars;

    /**
     * TemplateRender constructor.
     */
    public function __construct()
    {
        if (!isset($this->twig)) {
            $this->initSingleton();
            $this->template = null;
            $this->templateVars = [
                '_REQUEST' => $_REQUEST,
                '_GET' => $_GET,
                '_POST' => $_POST,
                'GLOBALS' => $GLOBALS,
            ];
            $this->commonTemplatesFolder = $this->getTemplatesFolder();
            $loader = new Twig_Loader_Filesystem($this->getPaths());
            $this->twig = new Twig_Environment($loader, $this->getOptions());
        }
    }

    /**
     * Return the template folder path.
     *
     * @return string
     */
    public function getTemplatesFolder(): string
    {
        return basePath('resources/templates');
    }

    /**
     * Establish a new template. The parameter must be only de template name, no the path!
     *
     * @param string $template
     */
    public function setTemplatesFolder(string $template)
    {
        $this->templatesFolder = basePath(self::SKINS_FOLDER) . '/' . trim($template, '/');
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
            constant('DEFAULT_TEMPLATES_FOLDER'),
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
        return basePath($this->commonTemplatesFolder);
    }

    /**
     * Sets the common templates folder.
     *
     * @param string $templatesFolder
     */
    public function setCommonTemplatesFolder(string $templatesFolder): void
    {
        $this->commonTemplatesFolder = $templatesFolder;
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
            $options['cache'] = (constant('BASE_PATH') ?? '') . '/cache/twig';
        }
        return $options;
    }

    /**
     * Return the full twig environtment.
     *
     * @return Twig_Environment
     */
    public function getTwig(): Twig_Environment
    {
        return $this->twig;
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
        $this->twig = $twig;
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
        $this->addExtensions();
        try {
            $render = $this->twig->render($this->getTemplate() ?? 'empty.twig', $this->getTemplateVars($data));
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
     * Add extensions to skin render.
     *
     * @return void
     */
    private function addExtensions(): void
    {
        // Add support for additional filters
        $this->twig->addExtension(new TwigFilters());

        // Add support for additional functions
        $this->twig->addExtension(new TwigFunctions());

        $isDebug = $this->getOptions()['debug'];
        if ($isDebug) {
            // Only available in debug mode
            $this->twig->addExtension(new Twig_Extension_Debug());
        }
    }

    /**
     * Return the assigned template to use.
     *
     * @return string|null
     */
    public function getTemplate()
    {
        return isset($this->template) ? $this->template . '.twig' : null;
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
        $this->template = $template;
        return $this;
    }

    /**
     * Returns true if a template has been specified.
     *
     * @return bool
     */
    public function hasTemplate(): bool
    {
        return ($this->template != null);
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
        return array_merge($vars, $this->templateVars);
    }

    /**
     * Add vars to template vars.
     *
     * @param array $vars
     */
    public function addVars(array $vars = [])
    {
        $this->templateVars = array_merge($vars, $this->templateVars);
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
     * Set a skin.
     *
     * @param string $skin
     */
    public function setSkin(string $skin)
    {
        if ($skin != $this->currentSkin) {
            $this->currentSkin = $skin;
            $this->setTemplatesFolder($skin);
        }
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
            constant('DEFAULT_TEMPLATES_FOLDER') . $path => constant('DEFAULT_TEMPLATES_URI') . $path,
            constant('VENDOR_FOLDER') . $path => constant('VENDOR_URI') . $path,
            constant('BASE_PATH') . $path => constant('BASE_URI') . $path,
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
        return baseUrl('resources/templates');
    }

    /**
     * Return the common template folder path from uri.
     *
     * @return string
     */
    public function getCommonTemplatesUri(): string
    {
        return baseUrl($this->commonTemplatesFolder);
    }

    /**
     * Return this instance.
     *
     * @return TemplateRender
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }
}
