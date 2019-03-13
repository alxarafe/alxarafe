<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\CreateConfig;
use PHPUnit\Framework\TestCase;

class CreateConfigTest extends TestCase
{
    /**
     * @var CreateConfig
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CreateConfig();
    }

    public function testIndexMethod()
    {
        $this->assertIsObject($this->object->indexMethod());
    }

    public function testPageDetails()
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }

    public function testGenerateMethod()
    {
        $this->assertIsObject($this->object->generateMethod());
    }

    public function testGetTimezoneList()
    {
        $this->assertIsArray($this->object->getTimezoneList());
    }
}
