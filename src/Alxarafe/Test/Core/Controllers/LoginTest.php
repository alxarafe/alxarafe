<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Login;
use Alxarafe\Test\Core\Base\ControllerTest;

class LoginTest extends ControllerTest
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Login();
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
     * @use Login::getCookieUser
     */
    public function testGetCookieUser()
    {

    }

    /**
     * @use Login::setUser
     */
    public function testSetUser()
    {

    }

    /**
     * @use Login::logoutMethod
     */
    public function testLogoutMethod()
    {

    }

    /**
     * @use Login::pageDetails
     */
    public function testPageDetails()
    {

    }

    /**
     * @use Login::getUser
     */
    public function testGetUser()
    {

    }

    /**
     * @use Login::indexMethod
     */
    public function testIndexMethod()
    {

    }

    /**
     * @use Login::getUserName
     */
    public function testGetUserName()
    {

    }
}
