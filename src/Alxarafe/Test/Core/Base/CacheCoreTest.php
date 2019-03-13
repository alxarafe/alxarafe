<?php

namespace Alxarafe\Test\Core\Base;

use Alxarafe\Core\Base\CacheCore;
use PHPUnit\Framework\TestCase;

class CacheCoreTest extends TestCase
{
    /**
     * @var CacheCore
     */
    protected $object;

    /**
     * @use CacheCore::getInstance
     */
    public function testGetInstance()
    {
        $this->assertIsObject($this->object::getInstance());
    }

    /**
     * @use CacheCore::getEngine
     */
    public function testGetEngine()
    {
        $this->assertIsObject($this->object->getEngine());
    }

    /**
     * @use CacheCore::getDefaultValues
     */
    public function testGetDefaultValues()
    {
        $this->assertEmpty($this->object::getDefaultValues());
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CacheCore();
    }
}
