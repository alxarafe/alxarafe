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
    public function testIndexMethod(): void
    {
        $this->assertIsObject($this->object->indexMethod());
    }

    /**
     * @use CreateConfig::pageDetails
     */
    public function testPageDetails(): void
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }

    /**
     * @use CreateConfig::generateMethod
     */
    public function testGenerateMethod(): void
    {
        $this->assertIsObject($this->object->generateMethod());
    }

    /**
     * @use CreateConfig::getTimezoneList
     */
    public function testGetTimezoneList(): void
    {
        $this->assertIsArray($this->object->getTimezoneList());
    }
}
