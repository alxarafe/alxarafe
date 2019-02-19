<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Session;
use Alxarafe\Providers\Container;
use Alxarafe\Providers\DebugTool;
use Alxarafe\Providers\TemplateRender;
use Alxarafe\Providers\Translator;
use ReflectionClass;
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
     * Manage the render.
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
     * Contains dependencies.
     *
     * @var Container|null
     */
    protected $container;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * SimpleController constructor.
     */
    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->request = $this->container::get('request');
        $this->response = $this->container::get('response');
        $this->session = $this->container::get('session');
        $this->renderer = $this->container::get('renderer');
        $this->translator = $this->container::get('translator');
        $this->renderer->addVars([
            'ctrl' => $this,
            'lang' => $this->translator,
        ]);
        $this->shortName = (new ReflectionClass($this))->getShortName();
        $this->renderer->setTemplate(strtolower($this->shortName));
        DebugTool::getInstance()->startTimer($this->shortName, $this->shortName . ' Controller Constructor');
        $this->username = null;
        DebugTool::getInstance()->stopTimer($this->shortName);
    }

    /**
     * Start point
     *
     * @return void
     */
    public function index(): void
    {
    }
}
