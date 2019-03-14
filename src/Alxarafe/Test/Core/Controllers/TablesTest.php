<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Tables;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;

class TablesTest extends AuthPageExtendedControllerTest
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Tables();
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
     * @use Tables::pageDetails
     */
    public function testPageDetails()
    {

    }

    /**
     * @use Tables::__construct
     */
    public function test__construct()
    {

    }
}
