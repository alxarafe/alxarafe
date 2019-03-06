<?php

namespace Alxarafe\Test\Core\Helpers\Utils;

use Alxarafe\Core\Helpers\Utils\ClassUtils;
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

    /**
     * @use ClassUtils::defineIfNotExists
     */
    public function testDefineIfNotExists()
    {
        $test = 'TEST_DEFINE';
        $definedBefore = false;
        $definedAfter = false;
        if (defined($test)) {
            $definedBefore = true;
            $definedAfter = true;
        }
        $this->object::defineIfNotExists($test, $test);
        if (defined($test)) {
            $definedAfter = !$definedAfter;
        }
        $this->assertNotSame($definedBefore, $definedAfter);
    }

    /**
     * @use ClassUtils::getShortName
     */
    public function testGetShortName()
    {
        $this->assertNotEmpty($this->object::getShortName($this, 'UtilsTest'));
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ClassUtils;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}
