<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\RolesPages;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;

class RolesPagesTest extends AuthPageExtendedControllerTest
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new RolesPages();
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
     * @use RolesPages::pageDetails
     */
    public function testPageDetails()
    {

    }

    /**
     * @use RolesPages::__construct
     */
    public function test__construct()
    {

    }
}
