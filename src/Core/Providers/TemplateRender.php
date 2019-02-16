<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Alxarafe\Helpers\TwigFilters;
use Alxarafe\Helpers\TwigFunctions;
use Kint\Kint;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

/**
 * Class TemplateRender
 *
 * @package WebApp\Providers
 */
class TemplateRender
{
    /**
     * Default: It is the folder that includes the templates.
     * Each template will be a folder whose name will be the one that will appear in the template selector.
     */
    const SKINS_FOLDER = "/resources/skins";

    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var string|null
     */
    protected $template;

    /**
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
     * @var Container
     */
    private $container;

    /**
     * Contains the template vars.
     *
     * @var array
     */
    private $templateVars;

    /**
     * View constructor.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
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

        $this->addExtensions();
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
     * Return the template folder path.
     *
     * @return string
     */
    private function getTemplatesFolder(): string
    {
        return basePath('resources/templates');
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
     * Add extensions to skin render.
     *
     * @return void
     */
    private function addExtensions(): void
    {
        // Add support for additional filters
        $twigFilters = new Twig_SimpleFilter('TwigFilters', function ($method, $params = []) {
            return TwigFilters::$method($params);
        });
        $this->twig->addFilter($twigFilters);

        // Add support for additional functions
        $twigFunctions = new Twig_SimpleFunction('TwigFunctions', function ($method, $params = []) {
            $twigFunctionsClass = new TwigFunctions($this->container);
            return $twigFunctionsClass->$method($params);
        });
        $this->twig->addFunction($twigFunctions);

        $isDebug = $this->getOptions()['debug'];
        if ($isDebug) {
            // Only available in debug mode
            $this->twig->addExtension(new Twig_Extension_Debug());
        }
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
    public function render(array $data = [])
    {
        $render = null;
        try {
            $render = $this->twig->render($this->getTemplate() ?? 'empty.twig', $this->getTemplateVars($data));
        } catch (\Twig_Error_Loader $e) {
            Kint::dump($e->getMessage());
        } catch (\Twig_Error_Runtime $e) {
            Kint::dump($e->getMessage());
        } catch (\Twig_Error_Syntax $e) {
            Kint::dump($e->getMessage());
        }
        echo $render;
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
     * Establish a new template. The parameter must be only de template name, no the path!
     *
     * @param string $template
     */
    public function setTemplatesFolder(string $template)
    {
        $this->templatesFolder = basePath(self::SKINS_FOLDER) . '/' . trim($template, '/');
    }
}
