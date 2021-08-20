<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\DebugTool;
use Alxarafe\Core\Singletons\FlashMessages;
use Alxarafe\Core\Singletons\TemplateRender;
use Alxarafe\Core\Utils\ClassUtils;
use DebugBar\DebugBarException;

/**
 * Class View
 *
 * @package Alxarafe\Base
 */
abstract class View extends Globals
{
    /**
     * Error messages to show
     *
     * @var string[]
     */
    public array $errors;

    /**
     * Dolibarr requires a body ID.
     *
     * @var string
     */
    public string $bodyId = 'mainbody';

    /**
     * Title of the HTML page
     *
     * @var string
     */
    public string $title;

    /**
     * Contiene el nombre de la plantilla a utilizar.
     *
     * @var ?string
     */
    public ?string $template = null;

    /**
     * Array that contains the variables that will be passed to the template.
     * Among others it will contain the user name, the view and the controller.
     *
     * @var array
     */
    private array $vars;

    /**
     * Load the JS and CSS files and define the ctrl, view and user variables
     * for the templates.
     *
     * @param Controller $controller
     *
     * @throws DebugBarException
     */
    public function __construct(Controller $controller)
    {
        parent::__construct();

        $title = ClassUtils::getShortName($controller, $controller);
        $this->title = $this->trans(strtolower($title)) . ' - ' . self::APP_NAME . ' ' . self::APP_VERSION;

        $this->setTemplate();
        $this->render->setTemplate($this->template);
        $this->vars = [];
        $this->vars['ctrl'] = $controller;
        $this->vars['view'] = $this;
        $this->vars['user'] = Config::getInstance()->getUsername();
        $this->vars['templateuri'] = $this->render->getTemplatesUri();
        $this->addCSS();
        $this->addJS();
        $this->getMenus();
    }

    /**
     * Method to assign the template to the view.
     */
    abstract function setTemplate(): void;

    /**
     * addCSS includes the common CSS files to all views templates. Also defines CSS folders templates.
     *
     * @return void
     * @throws DebugBarException
     */
    public function addCSS()
    {
        $this->addToVar('cssCode', $this->addResource('/bower_modules/bootstrap/dist/css/bootstrap.min', 'css'));
        $this->addToVar('cssCode', $this->addResource('/css/alxarafe', 'css'));
    }

    /**
     * Add a new element to a value saved in the array that is passed to the
     * template.
     * It is used when what we are saving is an array and we want to add a
     * new element to that array.
     *
     * @param $name
     * @param $value
     *
     * @return void
     */
    public function addToVar(string $name, string $value)
    {
        $this->vars[$name][] = $value;
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
     * @throws DebugBarException
     */
    public function addResource(string $resourceName, string $resourceExtension = 'css', $relative = true): string
    {
        $path = $resourceName . '.' . $resourceExtension;
        if ($relative) {
            if (file_exists($this->render->getTemplatesFolder() . $path)) {
                return $this->render->getTemplatesUri() . $path;
            }
            if (file_exists($this->render->getCommonTemplatesFolder() . $path)) {
                return $this->render->getCommonTemplatesUri() . $path;
            }
            if (file_exists(BASE_FOLDER . $path)) {
                return BASE_URI . $path;
            }
            $this->debug->addMessage('messages', "Relative resource '$path' not found!");
        }
        if (!file_exists($path)) {
            $this->debug->addMessage('messages', "Absolute resource '$path' not found!");
        }
        return $path;
    }

    /**
     * addJS includes the common JS files to all views templates. Also defines JS folders templates.
     *
     * @return void
     * @throws DebugBarException
     */
    public function addJS()
    {
        $this->addToVar('jsCode', $this->addResource('/bower_modules/jquery/dist/jquery.min', 'js'));
        $this->addToVar('jsCode', $this->addResource('/bower_modules/bootstrap/dist/js/bootstrap.min', 'js'));
        $this->addToVar('jsCode', $this->addResource('/js/alxarafe', 'js'));
    }

    private function getMenus()
    {
        $this->menu = [];
        $this->menu[] = $this->addItem('home', $this->trans('home'), '/dolibarr/htdocs/index.php?mainmenu=home&amp;leftmenu=home', true);
        $this->menu[] = $this->addItem('companies', $this->trans('companies'), '/dolibarr/htdocs/societe/index.php?mainmenu=companies&amp;leftmenu=');
        $this->menu[] = $this->addItem('commercial', $this->trans('commercial'), '/dolibarr/htdocs/fourn/commande/index.php?mainmenu=commercial&amp;leftmenu=');
        $this->menu[] = $this->addItem('billing', $this->trans('billing'), '/dolibarr/htdocs/compta/index.php?mainmenu=billing&amp;leftmenu=');
        $this->menu[] = $this->addItem('tools', $this->trans('tools'), '/dolibarr/htdocs/portfolio/portfolioindex.php?idmenu=1&mainmenu=portfolio&amp;leftmenu=');
        $this->menu[] = $this->addItem('portfolio', $this->trans('portfolio'), '/dolibarr/htdocs/portfolio/portfolioindex.php?idmenu=1&mainmenu=portfolio&amp;leftmenu=');
    }

    private function addItem($id, $title, $href, $active = false)
    {
        return [
            'id' => $id,
            'title' => $title,
            'href' => $href,
            'active' => $active,
        ];
    }

    /**
     * Finally render the result.
     *
     * @throws DebugBarException
     */
    public function __destruct()
    {
        if (!$this->render->hasTemplate()) {
            $this->render->setTemplate('default');
        }
        echo $this->render->render($this->vars);
    }

    /**
     * Saves a value in the array that is passed to the template.
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function setVar(string $name, string $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * Returns a previously saved value in the array that is passed to the
     * template.
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
     * Returns the necessary html code in the header of the template, to
     * display the debug bar.
     */
    public function getHeader(): string
    {
        return DebugTool::getRenderHeader();
    }

    /**
     * Returns the necessary html code at the footer of the template, to
     * display the debug bar.
     */
    public function getFooter(): string
    {
        return DebugTool::getRenderFooter();
    }

    /**
     * Obtains an array with all errors messages in the stack
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->flashMessages->getContainer();
    }

}
