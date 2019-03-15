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

    public function __construct()
    {
        parent::__construct();
        $this->object = new CacheCore();
    }

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
}
