<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Pages;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;

class PagesTest extends AuthPageExtendedControllerTest
{

    public function __construct()
    {
        parent::__construct();
        $this->object = new Pages();
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
     * @use Pages::pageDetails
     */
    public function testPageDetails()
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }
}
