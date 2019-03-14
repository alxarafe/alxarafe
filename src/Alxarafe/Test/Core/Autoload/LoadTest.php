<?php

namespace Alxarafe\Test\Core\Autoload;

use Alxarafe\Core\Autoload\Load;
use Modules\Sample\Models\Country;
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
        $this->object = new Load();
    }

    /**
     * @use Load::init
     */
    public function testInit()
    {
        $dirs = realpath(
            constant('BASE_PATH') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Alxarafe'
        );
        $this->object::init($dirs);
    }

    public function testAddDirs()
    {
        $dirs = [
            realpath(
                constant('BASE_PATH') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Modules'
            ),
        ];

        $this->object::addDirs($dirs);
    }

    /**
     * @use Load::autoload
     */
    public function testAutoLoad()
    {
        $this->object::autoLoad('\Modules\Sample\Models\Country');
        $this->object::autoLoad('Modules\Sample\Models\Country');
        $this->object::autoLoad(Country::class);
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
        $this->object = null;
    }
}
