<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Tables;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;

class TablesTest extends AuthPageExtendedControllerTest
{
    public function __construct()
    {
        parent::__construct();
        $this->object = new Tables();
    }

    /**
     * @use Tables::pageDetails
     */
    public function testPageDetails()
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }
}
