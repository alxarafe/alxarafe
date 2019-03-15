<?php

namespace Alxarafe\Test\Core\Helpers\Utils;

use Alxarafe\Core\Helpers\Utils\ClassUtils;
use Alxarafe\Core\Providers\Config;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2019-03-05 at 15:29:42.
 */
class ClassUtilsTest extends TestCase
{
    /**
     * @var ClassUtils
     */
    protected $object;

    public function __construct()
    {
        parent::__construct();
        (new Config())->loadConstants();
        $this->object = new ClassUtils;
    }

    /**
     * @use ClassUtils::defineIfNotExists
     */
    public function testDefineIfNotExists()
    {
        $test = 'TEST_DEFINE';
        $definedBefore = false;
        $definedAfter = false;
        $this->assertSame($definedBefore, $definedAfter);
        $this->object::defineIfNotExists($test, $test);
        $definedAfter = defined($test);
        $this->assertNotSame($definedBefore, $definedAfter);
    }

    /**
     * @use ClassUtils::getShortName
     */
    public function testGetShortName()
    {
        $this->assertNotEmpty($this->object::getShortName($this, 'ClassUtilsTest'));
        $this->assertNotEmpty($this->object::getShortName(null, 'ClassUtilsTest'));
        $this->assertNotEmpty($this->object::getShortName('ThisClassDoesNotExists', 'ClassUtilsTest'));
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
