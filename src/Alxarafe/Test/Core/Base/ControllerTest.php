<?php

namespace Alxarafe\Test\Core\Base;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ControllerTest extends TestCase
{
    public $object;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @use Controller::addResource
     */
    public function testAddResource()
    {
        $this->assertNotEmpty($this->object->addResource('resources/common/index.twig', true));
    }

    /**
     * @use Controller::getArrayPost
     */
    public function testGetArrayPost()
    {
        $this->assertEmpty($this->object->getArrayPost());
    }

    /**
     * @use Controller::sendResponse
     */
    public function testSendResponse()
    {
        $this->assertInstanceOf(Response::class, $this->object->sendResponse(''));
    }

    /**
     * @use Controller::sendResponseTemplate
     */
    public function testSendResponseTemplate()
    {
        $this->assertInstanceOf(Response::class, $this->object->sendResponseTemplate());
    }

    /**
     * @use Controller::getArrayCookies
     */
    public function testGetArrayCookies()
    {
        $this->assertEmpty($this->object->getArrayCookies());
    }

    /**
     * @use Controller::runMethod
     */
    public function testRunMethod()
    {
        // Remove the following lines when you implement this test.
        //$this->markTestIncomplete(
        //    'This test has not been implemented yet.'
        //);
    }

    /**
     * @use Controller::addCSS
     */
    public function testAddCSS()
    {
        $this->object->addCSS('/css/alxarafe.css');
    }

    /**
     * @use Controller::addToVar
     */
    public function testAddToVar()
    {
        $this->object->addToVar('cssCode', '/css/alxarafe.css');
        $this->object->addToVar('jsCode', '/js/alxarafe.js');
    }

    /**
     * @use Controller::getArrayServer
     */
    public function testGetArrayServer()
    {
        $this->assertNotEmpty($this->object->getArrayServer());
    }

    /**
     * @use Controller::getArrayHeaders
     */
    public function testGetArrayHeaders()
    {
        $this->assertEmpty($this->object->getArrayHeaders());
    }

    /**
     * @use Controller::getArrayGet
     */
    public function testGetArrayGet()
    {
        $this->assertEmpty($this->object->getArrayGet());
    }

    /**
     * @use Controller::redirect
     */
    public function testRedirect()
    {
        $this->assertInstanceOf(RedirectResponse::class, $this->object->redirect());
    }

    /**
     * @use Controller::addJS
     */
    public function testAddJS()
    {
        $this->object->addJS('/js/alxarafe.js');
    }

    /**
     * @use Controller::getArrayFiles
     */
    public function testGetArrayFiles()
    {
        $this->assertEmpty($this->object->getArrayFiles());
    }
}
