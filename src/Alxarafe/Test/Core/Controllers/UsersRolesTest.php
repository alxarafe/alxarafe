<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\UsersRoles;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;

class UsersRolesTest extends AuthPageExtendedControllerTest
{

    public function __construct()
    {
        parent::__construct();
        $this->object = new UsersRoles();
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
     * @use UsersRoles::pageDetails
     */
    public function testPageDetails(): void
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }
}
