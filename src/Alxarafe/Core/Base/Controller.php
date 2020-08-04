<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Helpers\Session;
use Alxarafe\Core\Helpers\Utils\ClassUtils;
use Alxarafe\Core\Providers\Container;
use Alxarafe\Core\Providers\DebugTool;
use Alxarafe\Core\Providers\Logger;
use Alxarafe\Core\Providers\TemplateRender;
use Alxarafe\Core\Providers\Translator;
use Monolog\Logger as MonologLogger;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 *
 * @package Alxarafe\Core\Base
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
     * The logger.
     *
     * @var MonologLogger
     */
    public $logger;

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
        $this->shortName = ClassUtils::getShortName($this, static::class);
        $this->container = Container::getInstance();
        $this->debugTool = DebugTool::getInstance();
        $this->debugTool->startTimer($this->shortName, $this->shortName . ' Controller Constructor');
        $this->request = Request::createFromGlobals();
        $this->response = new Response();
        $this->session = Session::getInstance();
        $this->renderer = TemplateRender::getInstance();
        $this->translator = Translator::getInstance();
        $this->logger = Logger::getInstance()->getLogger();
        $this->renderer->addVars(['ctrl' => $this,]);
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
        $this->logger->addDebug($this->translator->trans('redirected-from-to', $vars));
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
        $this->logger->addDebug($this->translator->trans('call-to', ['%called%' => $this->shortName . '->' . $method . '()']));
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
     * addCSS includes the CSS files to template.
     *
     * @param string $file
     *
     * @return void
     */
    public function addCSS(string $file): void
    {
        $this->addToVar('cssCode', $this->addResource($file));
    }

    /**
     * addJS includes the JS files to template.
     *
     * @param string $file
     *
     * @return void
     */
    public function addJS(string $file): void
    {
        $this->addToVar('jsCode', $this->addResource($file));
    }

    /**
     * Return body parameters $_POST values.
     *
     * @return array
     */
    public function getArrayPost(): array
    {
        return $this->request->request->all();
    }

    /**
     * Return query string parameters $_GET values.
     *
     * @return array
     */
    public function getArrayGet(): array
    {
        return $this->request->query->all();
    }

    /**
     * Return server and execution environment parameters from $_SERVER values.
     *
     * @return array
     */
    public function getArrayServer(): array
    {
        return $this->request->server->all();
    }

    /**
     * Return headers from $_SERVER header values.
     *
     * @return array
     */
    public function getArrayHeaders(): array
    {
        return $this->request->headers->all();
    }

    /**
     * Return uploaded files from $_FILES.
     *
     * @return array
     */
    public function getArrayFiles(): array
    {
        return $this->request->files->all();
    }

    /**
     * Return cookies from $_COOKIES.
     *
     * @return array
     */
    public function getArrayCookies(): array
    {
        return $this->request->files->all();
    }
}
