<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Roles;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;

class RolesTest extends AuthPageExtendedControllerTest
{

    public function __construct()
    {
        parent::__construct();
        $this->object = new Roles();
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
     * @use Roles::pageDetails
     */
    public function testPageDetails(): void
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }
}
