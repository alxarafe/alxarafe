<?php

namespace Alxarafe\Test\Core\Base;

use Symfony\Component\HttpFoundation\Response;

abstract class AuthPageControllerTest extends AuthControllerTest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testReadMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->readMethod());
    }

    public function testDeleteMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->deleteMethod());
    }

    public function testUpdateMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->updateMethod());
    }

    public function testRunMethod()
    {
        // Remove the following lines when you implement this test.
        //$this->markTestIncomplete(
        //    'This test has not been implemented yet.'
        //);
    }

    public function testGetUserMenu()
    {
        $this->assertNotEmpty($this->object->getUserMenu());
    }

    /**
     * AuthPageController::pageDetails
     */
    public function testPageDetails()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testCreateMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->createMethod());
    }

    public function testIndexMethod()
    {
        $this->assertInstanceOf(Response::class, $this->object->indexMethod());
    }
}
