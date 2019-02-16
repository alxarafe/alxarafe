<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Debug;
use Alxarafe\Helpers\Lang;
use Alxarafe\Helpers\Session;
use Alxarafe\Providers\Container;
use Alxarafe\Providers\TemplateRender;
use ReflectionClass;

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
     * Contains dependencies.
     *
     * @var Container|null
     */
    protected $container;

    /**
     * @var Lang
     */
    protected $translator;

    /**
     * SimpleController constructor.
     *
     * @param Container|null $container
     */
    public function __construct(Container $container = null)
    {
        $this->container = $container;
        $this->session = $this->container->get('session');
        $this->renderer = $this->container->get('render');
        $this->translator = $this->container->get('translator');
        $this->renderer->addVars([
            'ctrl' => $this,
            'lang' => $this->translator,
        ]);
        $this->shortName = (new ReflectionClass($this))->getShortName();
        $this->renderer->setTemplate(strtolower($this->shortName));
        Debug::startTimer($this->shortName, $this->shortName . ' Controller Constructor');
        $this->username = null;
        Debug::stopTimer($this->shortName);
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
