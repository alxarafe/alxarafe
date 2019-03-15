<?php

namespace Alxarafe\Test\Core\Base;

use Symfony\Component\HttpFoundation\Response;

abstract class AuthPageExtendedControllerTest extends AuthPageControllerTest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testShowMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->showMethod());
    }

    public function testGetActionButtons()
    {
        $this->assertEmpty($this->object->getActionButtons());
    }

    public function testGetExtraActions()
    {
        $this->assertEmpty($this->object->getExtraActions());
    }

    public function testEditMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->editMethod());
    }

    public function testRemoveMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->removeMethod());
    }

    public function testInitialize()
    {
        $this->object->initialize();
    }

    public function testDeleteMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->deleteMethod());
    }

    public function testIndexMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->indexMethod());
    }

    public function testAddMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->addMethod());
    }

    public function testCreateMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->createMethod());
    }

    public function testAccessDenied()
    {
        $this->object->accessDenied();
    }

    public function testListData()
    {
        $this->assertInstanceOf(Response::class, $this->object->listData());
    }

    public function testReadMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->readMethod());
    }

    public function testUpdateMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->updateMethod());
    }
}
