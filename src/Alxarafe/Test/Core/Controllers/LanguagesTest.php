<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Languages;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;

class LanguagesTest extends AuthPageExtendedControllerTest
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Languages();
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
     * @use Languages::pageDetails
     */
    public function testPageDetails()
    {

    }

    /**
     * @use Languages::indexMethod
     */
    public function testIndexMethod()
    {

    }

    /**
     * @use Languages::getExtraActions
     */
    public function testGetExtraActions()
    {

    }

    /**
     * @use Languages::__construct
     */
    public function test__construct()
    {

    }
}
