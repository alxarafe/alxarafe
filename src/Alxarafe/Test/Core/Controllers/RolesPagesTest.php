<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\RolesPages;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;

class RolesPagesTest extends AuthPageExtendedControllerTest
{

    public function __construct()
    {
        parent::__construct();
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
        $this->assertNotEmpty($this->object->pageDetails());
    }
}
