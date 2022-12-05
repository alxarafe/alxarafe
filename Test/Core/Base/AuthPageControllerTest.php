<?php

namespace Alxarafe\Test\Core\Base;

use Symfony\Component\HttpFoundation\Response;

abstract class AuthPageControllerTest extends AuthControllerTest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testReadMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->readMethod());
    }

    public function testDeleteMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->deleteMethod());
    }

    public function testUpdateMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->updateMethod());
    }

    public function testRunMethod(): void
    {
        // Remove the following lines when you implement this test.
        //$this->markTestIncomplete(
        //    'This test has not been implemented yet.'
        //);

        $methods = [
            'index',
            'ajaxSearch',
            'ajaxTableData',
            'add',
            'create',
            'show',
            'read',
            'edit',
            'update',
            'remove',
            'delete',
        ];

        foreach ($methods as $method) {
            $this->assertIsObject($this->object->runMethod($method));
        }
    }

    public function testGetUserMenu(): void
    {
        $this->assertNotEmpty($this->object->getUserMenu());
    }

    /**
     * AuthPageController::pageDetails
     */
    public function testPageDetails(): void
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testCreateMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->createMethod());
    }

    public function testIndexMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->indexMethod());
    }
}
