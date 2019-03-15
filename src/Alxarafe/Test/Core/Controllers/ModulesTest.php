<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Modules;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;
use Symfony\Component\HttpFoundation\Response;

class ModulesTest extends AuthPageExtendedControllerTest
{

    public function __construct()
    {
        parent::__construct();
        $this->object = new Modules();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
        $this->object = null;
    }

    /**
     * @use Modules::readMethod
     */
    public function testReadMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->readMethod());
    }

    /**
     * @use Modules::disableMethod
     */
    public function testDisableMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->disableMethod());
    }

    /**
     * @use Modules::deleteMethod
     */
    public function testDeleteMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->deleteMethod());
    }

    /**
     * @use Modules::getActionButtons
     */
    public function testGetActionButtons()
    {
        $this->assertNotEmpty($this->object->getActionButtons());
    }

    /**
     * @use Modules::indexMethod
     */
    public function testIndexMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->indexMethod());
    }

    /**
     * @use Modules::createMethod
     */
    public function testCreateMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->createMethod());
    }

    /**
     * @use Modules::updateMethod
     */
    public function testUpdateMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->updateMethod());
    }

    /**
     * @use Modules::pageDetails
     */
    public function testPageDetails()
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }

    /**
     * @use Modules::enableMethod
     */
    public function testEnableMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->enableMethod());
    }
}
