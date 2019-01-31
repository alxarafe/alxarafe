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
 * Class View, this class is used to manage the common things in a view:
 * - User
 * - Lang
 * - CSS
 * - JS
 *
 * @package Alxarafe\Base
 */
class View
{

    /**
     * Page title.
     *
     * @var string
     */
    public $title;

    /**
     * Array that contains the variables that will be passed to the template.
     * Among others it will contain the user name, the view and the controller.
     *
     * @var array
     */
    private $vars;

    /**
     * Load the JS and CSS files and define the ctrl, view and user variables for the templates.
     *
     * @param mixed $controller
     */
    public function __construct($controller = null)
    {
        $this->vars = [];
        $this->vars['ctrl'] = $controller;
        $this->vars['view'] = $this;
        $this->vars['user'] = null;
        if ($controller !== null && isset($controller->userAuth)) {
            $this->vars['user'] = $controller->userAuth->getUserName();
        }
        $this->vars['templateuri'] = Skin::getTemplatesUri();
        $this->vars['lang'] = Config::$lang;
        $this->title = isset($controller->title) ? $controller->title : 'Default title ' . random_int(PHP_INT_MIN, PHP_INT_MAX);

        // TODO: We have twig blocks, we really needed here??
        $this->addCSS();
        $this->addJS();
    }

    /**
     * addCSS includes the common CSS files to all views templates. Also defines CSS folders templates.
     *
     * @return void
     */
    public function addCSS(): void
    {
        //$this->addToVar('cssCode', $this->addResource('/.css'));
    }

    /**
     * addJS includes the common JS files to all views templates. Also defines JS folders templates.
     *
     * @return void
     */
    public function addJS(): void
    {
        //$this->addToVar('jsCode', $this->addResource('/.js'));
    }

    /**
     * Finally render the result.
     */
    public function render()
    {
        if (!Skin::hasTemplate()) {
            Skin::setTemplate('default');
        }
        // $this->vars['errors'] = Config::getErrors();
        echo Skin::render($this->vars);
    }

    /**
     * Check different possible locations for the file and return the
     * corresponding URI, if it exists.
     *
     * @param string $path
     *
     * @return string
     */
    private function getResourceUri(string $path): string
    {
        $paths = [
            Skin::getTemplatesFolder() . '/' . $path => Skin::getTemplatesUri() . $path,
            Skin::getCommonTemplatesFolder() . '/' . $path => Skin::getCommonTemplatesUri() . $path,
            constant('DEFAULT_TEMPLATES_FOLDER') . '/' . $path => constant('DEFAULT_TEMPLATES_URI') . $path,
            constant('VENDOR_FOLDER') . '/' . $path => constant('VENDOR_URI') . $path,
        ];

//        Debug::addMessage('messages', "Looking for '$path':");
        foreach ($paths as $fullPath => $uriPath) {
            if (file_exists($fullPath)) {
                return $uriPath;
            }
//            Debug::addMessage('messages', "File '$fullPath' not found!");
        }
        return '';
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
     * @param string  $resourceName is the name of the file (with extension)
     * @param boolean $relative     set to false for use an absolute path.
     *
     * @return string the complete path of resource.
     */
    public function addResource(string $resourceName, $relative = true): string
    {
        if ($relative) {
            $uri = $this->getResourceUri($resourceName);
            if ($uri !== '') {
                return $uri;
            }
            Debug::addMessage('messages', "Relative resource '$resourceName' not found!");
        }
        if (!file_exists($resourceName)) {
            Debug::addMessage('messages', "Absolute resource '$resourceName' not found!");
            Debug::addMessage('messages', "File '$resourceName' not found!");
            return '';
        }
        return $resourceName;
    }

    /**
     * Saves a value in the array that is passed to the template.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function setVar(string $name, $value): void
    {
        $this->vars[$name] = $value;
    }

    /**
     * Add a new element to a value saved in the array that is passed to the template.
     * It is used when what we are saving is an array and we want to add a new element to that array.
     * IMPORTANT: The element only is added if is not empty.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function addToVar(string $name, $value): void
    {
        if (!empty($value)) {
            $this->vars[$name][] = $value;
        }
    }

    /**
     * Returns a previously saved value in the array that is passed to the template.
     *
     * @return array
     */
    public function getVars(): array
    {
        return $this->vars;
    }

    /**
     * Returns a previously saved value in the array that is passed to the template.
     *
     * @param $name
     *
     * @return array|string|boolean|null
     */
    public function getVar(string $name)
    {
        return isset($this->vars[$name]) ?? [];
    }

    /**
     * Makes visible Config::getErrors() from templates, using view.getErrors()
     * Config::getErrors() returns an array with the pending error messages, and empties the list.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return Config::getErrors();
    }

    /**
     * Returns the necessary html code in the header of the template, to display the debug bar.
     *
     * @return string
     */
    public function getHeader(): string
    {
        return Debug::getRenderHeader();
    }

    /**
     * Returns the necessary html code at the footer of the template, to display the debug bar.
     *
     * @return string
     */
    public function getFooter(): string
    {
        return Debug::getRenderFooter();
    }
}
