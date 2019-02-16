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
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $viewName;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->viewName = null;
        $loader = new Twig_Loader_Filesystem(basePath('/templates'));
        $this->twig = new Twig_Environment($loader);

        // Add support for additional filters
        $twigFilters = new Twig_SimpleFilter('TwigFilters', function ($method, $params = []) {
            return TwigFilters::$method($params);
        });
        $this->twig->addFilter($twigFilters);

        // Add support for additional functions
        $twigFunctions = new Twig_SimpleFunction('TwigFunctions', function ($method, $params = []) {
            return TwigFunctions::$method($params);
        });
        $this->twig->addFunction($twigFunctions);
    }

    /**
     * @return Twig_Environment
     */
    public function getTwig(): Twig_Environment
    {
        return $this->twig;
    }

    /**
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
     * @return string
     */
    public function getViewName(): string
    {
        return $this->viewName;
    }

    /**
     * @param string $viewName
     *
     * @return $this
     */
    public function setViewName(string $viewName): self
    {
        $this->viewName = $viewName;
        return $this;
    }

    /**
     * Renders a template.
     *
     * @param string $viewName The template name
     * @param array  $data     An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    public function render(string $viewName, array $data = [])
    {
        try {
            return $this->twig->render($viewName, $data);
        } catch (\Twig_Error_Loader $e) {
            Kint::dump($e->getMessage());
        } catch (\Twig_Error_Runtime $e) {
            Kint::dump($e->getMessage());
        } catch (\Twig_Error_Syntax $e) {
            Kint::dump($e->getMessage());
        }
    }
}
