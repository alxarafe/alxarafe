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
            'ctrl' => $this,
            'lang' => $this->translator,
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
        Logger::getInstance()->getLogger()->addDebug('Redirected to ' . $destiny);
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
        Logger::getInstance()->getLogger()->addDebug('Call to ' . $this->shortName . '->' . $method . '()');
        if (method_exists($this, 'checkAuth') && !$this->checkAuth($methodName)) {
            Logger::getInstance()->getLogger()->addDebug('Not authoriced to ' . $this->shortName . '->' . $method . '()');
            return $this->response->setStatusCode(HTTP_METHOD_NOT_ALLOWED);
        }
        return $this->{$method}();
    }
}
