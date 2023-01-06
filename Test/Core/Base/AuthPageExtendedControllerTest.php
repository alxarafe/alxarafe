<?php

namespace Test\Core\Base;

use Symfony\Component\HttpFoundation\Response;

abstract class AuthPageExtendedControllerTest extends AuthPageControllerTest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testShowMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->showMethod());
    }

    public function testGetActionButtons(): void
    {
        $this->assertEmpty($this->object->getActionButtons());
    }

    public function testGetExtraActions(): void
    {
        $this->assertEmpty($this->object->getExtraActions());
    }

    public function testGetStatus(): void
    {
        // $this->assertNull($this->object->getStatus);
    }

    public function testEditMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->editMethod());
    }

    public function testRemoveMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->removeMethod());
    }

    public function testInitialize(): void
    {
        $this->object->initialize();
    }

    public function testDeleteMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->deleteMethod());
    }

    public function testIndexMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->indexMethod());
    }

    public function testAddMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->addMethod());
    }

    public function testCreateMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->createMethod());
    }

    public function testAccessDenied(): void
    {
        $this->object->accessDenied();
    }

    public function testListData(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->listData());
    }

    public function testReadMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->readMethod());
    }

    public function testUpdateMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->updateMethod());
    }
}
