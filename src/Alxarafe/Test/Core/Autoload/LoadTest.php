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

    public function __construct()
    {
        parent::__construct();
        $this->object = new Load();
    }

    /**
     * @use Load::getInstance
     */
    public function testGetInstance(): void
    {
        $this->assertSame($this->object::getInstance(), $this->object);
    }

    /**
     * @use Load::init
     */
    public function testInit(): void
    {
        $dirs = realpath(
            constant('BASE_PATH') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Alxarafe'
        );
        $this->object::init($dirs);
    }

    public function testAddDirs(): void
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
    public function testAutoLoad(): void
    {
        $this->object::autoLoad('\Modules\Sample\Models\Country');
        $this->object::autoLoad('Modules\Sample\Models\Country');
        $this->object::autoLoad(Country::class);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        $this->object = null;
    }
}
