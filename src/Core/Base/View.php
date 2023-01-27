<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Helpers\Auth;
use Alxarafe\Core\Helpers\Globals;
use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Core\Singletons\FlashMessages;
use Alxarafe\Core\Singletons\Render;
use Alxarafe\Core\Singletons\Translator;
use Alxarafe\Core\Utils\ClassUtils;
use Alxarafe\Models\Menu;

/**
 * Class View
 *
 * @package Alxarafe\Base
 */
abstract class View
{
    /**
     * Error messages to show
     *
     * @var string[]
     */
    public array $errors;

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
     * Contains an array with the main menu options. (top menu)
     *
     * @var array
     */
    public array $menu;

    /**
     * Contains an array with the submenu options. (left menu)
     *
     * @var array
     */
    public array $submenu;

    public bool $hasMenu = false;

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
    public function __construct(BasicController $controller)
    {
        $title = ClassUtils::getShortName($controller, $controller);
        $this->title = Translator::trans(strtolower($title)) . ' - ' . Globals::APP_NAME . ' ' . Globals::APP_VERSION;

        $this->setTemplate();
        Render::setTemplate($this->template);
        $this->vars = [];
        $this->vars['ctrl'] = $controller;
        $this->vars['view'] = $this;
        $this->vars['user'] = Auth::getUser();
        $this->vars['templateuri'] = Render::getTemplatesUri();
        $this->addCSS();
        $this->addJS();
        $this->hasMenu = $controller->hasMenu;
        if ($this->hasMenu) {
            $this->getMenu();
            $this->getSubmenu();
        }
    }

    public function trans($text)
    {
        return Translator::trans($text);
    }

    /**
     * Method to assign the template to the view.
     */
    abstract public function setTemplate(): void;

    /**
     * addCSS includes the common CSS files to all views templates. Also defines CSS folders templates.
     *
     * @return void
     * @throws DebugBarException
     */
    public function addCSS()
    {
        //        $this->addToVar('cssCode', $this->addResource('/bower_modules/bootstrap/dist/css/bootstrap.min', 'css'));
        //        $this->addToVar('cssCode', $this->addResource('/css/alxarafe', 'css'));
    }

    /**
     * addJS includes the common JS files to all views templates. Also defines JS folders templates.
     *
     * @return void
     * @throws DebugBarException
     */
    public function addJS()
    {
        //        $this->addToVar('jsCode', $this->addResource('/bower_modules/jquery/dist/jquery.min', 'js'));
        //        $this->addToVar('jsCode', $this->addResource('/bower_modules/bootstrap/dist/js/bootstrap.min', 'js'));
        //        $this->addToVar('jsCode', $this->addResource('/js/alxarafe', 'js'));
    }

    /**
     * The menu options in Dolibarr are defined in eldy.lib.php in the print_eldy_menu function.
     * In the case of using the Auguria template, change eldy to auguria.
     *
     * TODO: The options not allowed for the user should be disabled
     * TODO: Soon, this information will be in a template yaml file
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version sept. 2021
     *
     */
    private function getMenu()
    {
        $module = strtolower(filter_input(INPUT_GET, 'module'));
        $this->menu = [];
        $this->menu[] = $this->addItem(
            'portfolio',
            Translator::trans('portfolio'),
            '?module=Portfolio&controller=Index',
            $module === 'portfolio'
        );
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
     * The left menu options in Dolibarr are defined in eldy.lib.php in the print_left_eldy_menu function.
     * In the case of using the Auguria template, change eldy to auguria.
     *
     * TODO: The options not allowed for the user should be disabled
     * TODO: The initial implementation is very basic. Needs improvements.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version sept. 2021
     *
     */
    private function getSubmenu()
    {
        $module = strtolower(filter_input(INPUT_GET, 'module'));
        $menu = new Menu();
        $this->submenu = $menu->getSubmenu($module);
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
            if (file_exists(BASE_DIR . '/vendor/almasaeed2010/adminlte/' . $path)) {
                return BASE_URI . '/vendor/almasaeed2010/adminlte/' . $path;
            }
            if (file_exists(Render::getTemplatesFolder() . $path)) {
                return Render::getTemplatesUri() . $path;
            }
            if (file_exists(Render::getCommonTemplatesFolder() . $path)) {
                return Render::getCommonTemplatesUri() . $path;
            }
            if (file_exists(BASE_DIR . $path)) {
                return BASE_URI . $path;
            }
            Debug::message("Relative resource '$path' not found!");
        }
        if (!file_exists($path)) {
            Debug::message("Absolute resource '$path' not found!");
        }
        return $path;
    }

    /**
     * Finally render the result.
     *
     * @throws DebugBarException
     */
    public function __destruct()
    {
        if (!Render::hasTemplate()) {
            Render::setTemplate('default');
        }
        echo Render::render($this->vars);
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
        return Debug::getRenderHeader();
    }

    /**
     * Returns the necessary html code at the footer of the template, to
     * display the debug bar.
     */
    public function getFooter(): string
    {
        return Debug::getRenderFooter();
    }

    /**
     * Obtiene todos los errores que quedan pendientes de mostrar
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return array
     */
    public function getErrors(): array
    {
        return FlashMessages::getContainer();
    }
}
