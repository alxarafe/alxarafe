<?php

namespace Alxarafe\Test\Core\Autoload;

use Alxarafe\Core\Autoload\Load;
use PHPUnit\Framework\TestCase;

class LoadTest extends TestCase
{
    /**
     * @var Load
     */
    protected $object;

    /**
     * @use Load::getInstance
     */
    public function testGetInstance()
    {
        $this->assertSame($this->object::getInstance(), $this->object);
    }

    /**
     * @use Load::__construct
     */
    public function test__construct()
    {

    }

    /**
     * @use Load::init
     */
    public function testInit()
    {

    }

    /**
     * @use Load::autoload
     */
    public function testAutoLoad()
    {

    }

    public function testAddDirs()
    {

    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Load();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}
