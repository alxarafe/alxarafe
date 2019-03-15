<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\CreateConfig;
use Alxarafe\Test\Core\Base\ControllerTest;

class CreateConfigTest extends ControllerTest
{
    public function __construct()
    {
        parent::__construct();
        $this->object = new CreateConfig();
    }

    /**
     * @use CreateConfig::indexMethod
     */
    public function testIndexMethod()
    {
        $this->assertIsObject($this->object->indexMethod());
    }

    /**
     * @use CreateConfig::pageDetails
     */
    public function testPageDetails()
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }

    /**
     * @use CreateConfig::generateMethod
     */
    public function testGenerateMethod()
    {
        $this->assertIsObject($this->object->generateMethod());
    }

    /**
     * @use CreateConfig::getTimezoneList
     */
    public function testGetTimezoneList()
    {
        $this->assertIsArray($this->object->getTimezoneList());
    }
}
