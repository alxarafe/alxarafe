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
use Alxarafe\Providers\TemplateRender;
use Alxarafe\Providers\Translator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 *
 * @package Alxarafe\Base
 */
class SimpleController
{
    /**
     * TODO: Undocumented
     *
     * @var null
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
     * SimpleController constructor.
     */
    public function __construct()
    {
        $this->shortName = Utils::getShortName($this, get_called_class());
        $this->container = Container::getInstance();
        $this->debugTool = DebugTool::getInstance();
        $this->debugTool->startTimer($this->shortName, $this->shortName . ' Controller Constructor');
        $this->request = $this->container::get('request');
        $this->response = $this->container::get('response');
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
     * Start point
     *
     * @return void
     */
    public function index(): void
    {
    }

    /**
     * Add new vars to render, render the template and send the Response.
     *
     * @param array $data
     */
    public function sendTemplateResponse(array $data = [])
    {
        $data = array_merge($data, ['ctrl' => $this]);
        $this->sendResponse($this->renderer->render($data));
    }

    /**
     * Send the Response with data received.
     *
     * @param $reply
     */
    public function sendResponse($reply)
    {
        $this->response->setContent($reply);
        $this->response->send();
    }
}
