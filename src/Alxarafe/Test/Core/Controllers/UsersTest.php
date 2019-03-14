<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Users;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;

class UsersTest extends AuthPageExtendedControllerTest
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Users();
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
     * @use Users::pageDetails
     */
    public function testPageDetails()
    {

    }

    /**
     * @use Users::__construct
     */
    public function test__construct()
    {

    }
}
