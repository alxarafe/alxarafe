<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use Alxarafe\Helpers\Skin;

/**
 * Class View
 *
 * @package Alxarafe\Base
 */
class View
{

    /**
     * TODO: Undocumented
     *
     * @var array
     */
    private $vars;

    /**
     * Load the JS and CSS files and define the ctrl, view and user variables
     * for the templates.
     *
     * @param mixed $controller
     */
    public function __construct($controller = null)
    {
        // echo "<p>Constructor de View</p>";
        // Throw Exception('X');

        $this->vars = [];
        $this->vars['ctrl'] = $controller;
        $this->vars['view'] = $this;
        $this->vars['user'] = Config::$username;
        $this->addCSS();
        $this->addJS();
    }

    /**
     * Finally render the result.
     */
    public function __destruct()
    {
        if (!Skin::hasTemplate()) {
            Skin::setTemplate('default');
        }
        $this->vars['errors'] = Config::getErrors();

        echo Skin::render($this->vars);
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
            // Debug::addMessage('messages', "Exists resource '$path'?");
            if (file_exists($path)) {
                Debug::addMessage('messages', "Using skin resource $path");
                return Skin::getTemplatesUri() . $absPath;
            }
            $path = Skin::getCommonTemplatesFolder() . $absPath;
            // Debug::addMessage('messages', "Exists resource '$path'?");
            if (file_exists($path)) {
                Debug::addMessage('messages', "Using common resource $path");
                return Skin::getCommonTemplatesUri() . $absPath;
            }
            $path = DEFAULT_TEMPLATES_FOLDER . $absPath;
            // Debug::addMessage('messages', "Exists resource '$path'?");
            if (file_exists($path)) {
                Debug::addMessage('messages', "Using default resource $path");
                return DEFAULT_TEMPLATES_URI . $absPath;
            }
            $path = VENDOR_FOLDER . $absPath;
            // Debug::addMessage('messages', "Exists resource '$path'?");
            if (file_exists($path)) {
                Debug::addMessage('messages', "Using package resource $path");
                return VENDOR_URI . $absPath;
            }
        }
        Debug::addMessage('messages', "Using absolute resource $absPath");
        return $absPath;
    }

    /**
     * TODO: Undocumented
     *
     * @param $name
     * @param $value
     */
    public function setVar($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * TODO: Undocumented
     *
     * @param $name
     * @param $value
     */
    public function addToVar($name, $value)
    {
        $this->vars[$name][] = $value;
    }

    /**
     * TODO: Undocumented
     *
     * @param $name
     *
     * @return array|bool
     */
    public function getVar($name)
    {
        return isset($this->vars[$name]) ?? [];
    }

    /**
     * addCSS includes the common CSS files to all views templates. Also defines CSS folders templates.
     *
     * @return void
     */
    public function addCSS()
    {
        $this->addToVar('cssCode', $this->addResource('/twbs/bootstrap/dist/css/bootstrap.min', 'css'));
        $this->addToVar('cssCode', $this->addResource('/css/alxarafe', 'css'));
    }

    /**
     * addJS includes the common JS files to all views templates. Also defines JS folders templates.
     *
     * @return void
     */
    public function addJS()
    {
        $this->addToVar('jsCode', $this->addResource('/components/jquery/jquery.min', 'js'));
        $this->addToVar('jsCode', $this->addResource('/twbs/bootstrap/dist/js/bootstrap.min', 'js'));
        $this->addToVar('jsCode', $this->addResource('/js/alxarafe', 'js'));
    }

    /**
     * Makes visible Config::getErrors() from templates, using view.getErrors()
     * Config::getErrors() returns an array with the pending error messages,
     * and empties the list.
     *
     * @return array
     */
    public function getErrors()
    {
        return Config::getErrors();
    }

    /**
     * Returns the necessary html code in the header of the template, to
     * display the debug bar.
     *
     * @return string
     */
    public function getHeader()
    {
        return Debug::getRenderHeader();
    }

    /**
     * Returns the necessary html code at the footer of the template, to
     * display the debug bar.
     *
     * @return string
     */
    public function getFooter()
    {
        return Debug::getRenderFooter();
    }
}
