<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Login;
use Alxarafe\Core\Models\User;
use Alxarafe\Test\Core\Base\ControllerTest;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends ControllerTest
{

    public function __construct()
    {
        parent::__construct();
        $this->object = new Login();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown(): void
    {
        $this->object = null;
    }

    /**
     * @use Login::getCookieUser
     */
    public function testGetCookieUser(): void
    {
        $userName = 'admin';
        $user = new User();
        if ($user->getBy('username', $userName)) {
            $this->object->request->cookies->set('user', $userName);
            $this->object->request->cookies->set('logkey', $user->logkey);
            $this->assertEquals($userName, $this->object->getCookieUser(0));
        }
    }

    /**
     * @use Login::setUser
     */
    public function testSetUser(): void
    {
        $this->assertTrue($this->object->setUser('admin', 'admin', 0));
    }

    /**
     * @use Login::logoutMethod
     */
    public function testLogoutMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->logoutMethod());
    }

    /**
     * @use Login::pageDetails
     */
    public function testPageDetails(): void
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }

    /**
     * @use Login::getUser
     */
    public function testGetUser(): void
    {
        $this->assertNull($this->object->getUser());
        $this->testSetUser();
        $this->assertInstanceOf(User::class, $this->object->getUser());
    }

    /**
     * @use Login::indexMethod
     */
    public function testIndexMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->indexMethod());
    }

    /**
     * @use Login::getUserName
     */
    public function testGetUserName(): void
    {
        $this->assertFalse($this->object->setUser('admin', 'bad-pass', 0));
        $this->assertNull($this->object->getUserName());
        $this->testGetCookieUser();
        $this->assertEquals('admin', $this->object->getUserName());
    }
}
