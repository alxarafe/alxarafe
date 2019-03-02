<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Base;

use Alxarafe\Helpers\Session;
use Alxarafe\Helpers\Utils;
use Alxarafe\Providers\Container;
use Alxarafe\Providers\DebugTool;
use Alxarafe\Providers\Logger;
use Alxarafe\Providers\TemplateRender;
use Alxarafe\Providers\Translator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 *
 * @package Alxarafe\Base
 */
abstract class Controller
{

    /**
     * Contains the user's name or null
     *
     * @var string|null
     */
    public $username;

    /**
     * Class short name.
     *
     * @var string
     */
    public $shortName;

    /**
     * To manage PHP Sessions.
     *
     * @var Session
     */
    public $session;

    /**
     * Manage the renderer.
     *
     * @var TemplateRender
     */
    public $renderer;

    /**
     * Request from client.
     *
     * @var Request
     */
    public $request;

    /**
     * Response to client.
     *
     * @var Response
     */
    public $response;

    /**
     * The debug tool used.
     *
     * @var DebugTool
     */
    public $debugTool;

    /**
     * Contains dependencies.
     *
     * @var Container|null
     */
    protected $container;

    /**
     * The translator manager.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Array that contains the variables that will be passed to the template.
     * Among others it will contain the user name, the view and the controller.
     *
     * @var array
     */
    private $vars;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->shortName = Utils::getShortName($this, get_called_class());
        $this->container = Container::getInstance();
        $this->debugTool = DebugTool::getInstance();
        $this->debugTool->startTimer($this->shortName, $this->shortName . ' Controller Constructor');
        $this->request = $this->container::get('request');
        $this->response = new Response();
        $this->session = Session::getInstance();
        $this->renderer = TemplateRender::getInstance();
        $this->translator = Translator::getInstance();
        $this->renderer->addVars([
            'ctrl' => $this
        ]);
        $this->renderer->setTemplate(strtolower($this->shortName));
        $this->username = null;
        $this->debugTool->stopTimer($this->shortName);
    }

    /**
     * Add new vars to render, render the template and send the Response.
     *
     * @param array $data
     *
     * @return Response
     */
    public function sendResponseTemplate(array $data = []): Response
    {
        $data = array_merge($data, ['ctrl' => $this]);
        return $this->sendResponse($this->renderer->render($data));
    }

    /**
     * Send the Response with data received.
     *
     * @param string $reply
     * @param int    $status
     *
     * @return Response
     */
    public function sendResponse(string $reply, $status = Response::HTTP_OK): Response
    {
        $this->response->setStatusCode($status);
        $this->response->setContent($reply);
        return $this->response;
    }

    /**
     * Send a RedirectResponse to destiny receive.
     *
     * @param string $destiny
     *
     * @return RedirectResponse
     */
    public function redirect(string $destiny = ''): RedirectResponse
    {
        if (empty($destiny)) {
            $destiny = baseUrl('index.php');
        }
        $vars = ['%from%' => $this->shortName, '%to%' => $destiny];
        Logger::getInstance()->getLogger()->addDebug($this->translator->trans('redirected-from-to', $vars));
        return new RedirectResponse($destiny);
    }

    /**
     * @param string $methodName
     *
     * @return Response
     */
    public function runMethod(string $methodName): Response
    {
        $method = $methodName . 'Method';
        Logger::getInstance()->getLogger()->addDebug($this->translator->trans('call-to', ['%called%' => $this->shortName . '->' . $method . '()']));
        return $this->{$method}();
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
            $uri = $this->renderer->getResourceUri($resourceName);
            if ($uri !== '') {
                return $uri;
            }
            $this->debugTool->addMessage('messages', "Relative resource '$resourceName' not found!");
        }
        if (!file_exists($resourceName)) {
            $this->debugTool->addMessage('messages', "Absolute resource '$resourceName' not found!");
            $this->debugTool->addMessage('messages', "File '$resourceName' not found!");
            return '';
        }
        return $resourceName;
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
}
