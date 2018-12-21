<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;
use Alxarafe\Helpers\Debug;

class View
{

    private $vars;
    protected $css;
    protected $js;

    public function __construct($controller = null)
    {
        Skin::setTemplatesEngine($config['templatesEngine'] ?? 'twig');

        $this->vars = [];
        $this->vars['ctrl'] = $controller;
        $this->vars['view'] = $this;
        $this->css = [];
        $this->js = [];
        $this->addCSS();
        $this->addJS();
    }

    /**
     * Check if the resource is in the application's resource folder (for example, in the css or js folders
     * of the skin folder). It's a specific file.
     *
     * If it can not be found, check if it is in the templates folder (for example in the css or
     * js folders of the templates folder). It's a common file.
     *
     * If it is not in either of the two, no route is specified (it will surely give loading error).
     *
     * @param string  $resourceName      , is the name of the file (without extension)
     * @param string  $resourceExtension , is the extension (type) of the resource (js or css)
     * @param boolean $relative          , set to false for use an absolute path.
     *
     * @return string the complete path of resource.
     */
    protected function addResource(string $resourceName, string $resourceExtension = 'css', $relative = true): string
    {
        $absPath = $resourceName . '.' . $resourceExtension;
        if ($relative) {
            $path = Skin::getTemplatesFolder() . $absPath;
            Debug::addMessage('messages', "Exists resource '$path'?");
            if (file_exists($path)) {
                Debug::addMessage('messages', "Using resource $path");
                return $path;
            }
            $path = Config::getVar('commonTemplatesFolder') . $absPath;
            Debug::addMessage('messages', "Exists resource '$path'?");
            if (file_exists($path)) {
                Debug::addMessage('messages', "Using resource $path");
                return $path;
            }
            $path = DEFAULT_TEMPLATES_FOLDER . $absPath;
            Debug::addMessage('messages', "Exists resource '$path'?");
            if (file_exists($path)) {
                Debug::addMessage('messages', "Using resource $path");
                return $path;
            }
            $path = VENDOR_FOLDER . $absPath;
            Debug::addMessage('messages', "Exists resource '$path'?");
            if (file_exists($path)) {
                Debug::addMessage('messages', "Using resource $path");
                return $path;
            }
        }
        Debug::addMessage('messages', "Adding absolute resource $absPath");
        return $absPath;
    }

    /**
     * addCSS includes the common CSS files to all views templates. Also defines CSS folders templates.
     *
     * @return void
     */
    public function addCSS()
    {
        $this->css[] = $this->addResource(VENDOR_FOLDER . 'twbs/bootstrap/dist/css/bootstrap.min', 'css', false);
        $this->css[] = $this->addResource('css/alxarafe', 'css');
    }

    /**
     * addJS includes the common JS files to all views templates. Also defines JS folders templates.
     *
     * @return void
     */
    public function addJS()
    {
        $this->js[] = $this->addResource(VENDOR_FOLDER . 'components/jquery/jquery.min', 'js', false);
        $this->js[] = $this->addResource(VENDOR_FOLDER . 'twbs/bootstrap/dist/css/bootstrap.min', 'js', false);
        $this->js[] = $this->addResource('js/alxarafe', 'js');
    }

    public function getHeader()
    {
        return Debug::getRenderHeader();
    }

    public function getFooter()
    {
        return Debug::getRenderFooter();
    }

    public function getVar($name)
    {
        return isset($this->vars[$name]) ?? [];
    }

    public function setVar($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function run(array $data = [])
    {
        if (!Skin::hasTemplate()) {
            Skin::setTemplate('default');
        }
        $this->vars = \array_merge($this->vars, $data);
        $this->vars['cssCode'] = $this->css;
        $this->vars['jsCode'] = $this->js;
        $this->vars['errors'] = Config::getErrors();
        echo Skin::render($this->vars);

        return true;
    }
}
