<?php

namespace Alxarafe\Test\Core\Helpers\Utils;

use Alxarafe\Core\Helpers\Utils\FileSystemUtils;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2019-03-05 at 15:29:42.
 */
class FileSystemUtilsTest extends TestCase
{
    /**
     * @var FileSystemUtils
     */
    protected $object;

    /**
     * @use    FileSystemUtils::scandir
     */
    public function testScandir()
    {
        // Remove the following lines when you implement this test.
        $this->assertNotEmpty($this->object::scandir(__DIR__));
    }

    /**
     * @use FileSystemUtils::mkdir
     */
    public function testMkdir()
    {
        $folder = 'test';
        $this->assertDirectoryNotExists($folder);
        FileSystemUtils:: mkdir($folder);
        $this->assertDirectoryExists($folder);
    }

    /**
     * @use FileSystemUtils::rrmdir
     */
    public function testRrmdir()
    {
        $folder = 'test';
        $this->assertDirectoryExists($folder);
        $this->assertTrue(FileSystemUtils:: rrmdir($folder));
        $this->assertDirectoryNotExists($folder);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new FileSystemUtils;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}
