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

    public function __construct()
    {
        parent::__construct();
        $this->object = new FileSystemUtils;
    }

    /**
     * @use    FileSystemUtils::scandir
     */
    public function testScandir(): void
    {
        // Remove the following lines when you implement this test.
        $this->assertNotEmpty($this->object::scandir(__DIR__));
    }

    /**
     * @use FileSystemUtils::mkdir
     */
    public function testMkdir(): void
    {
        $folder = 'test';
        $this->assertDirectoryNotExists($folder);
        FileSystemUtils:: mkdir($folder);
        $this->assertDirectoryExists($folder);
    }

    /**
     * @use FileSystemUtils::rrmdir
     */
    public function testRrmdir(): void
    {
        $folder = 'test';
        $this->assertDirectoryExists($folder);
        $this->assertTrue(FileSystemUtils:: rrmdir($folder));
        $this->assertDirectoryNotExists($folder);
    }

    /**
     * @use FileSystemUtils::locate
     */
    public function testLocate(): void
    {
        $subfolder = 'Models';
        $file = 'Language';

        $path = FileSystemUtils::locate($subfolder, $file, false);
        $this->assertStringEndsWith($subfolder . DIRECTORY_SEPARATOR . $file . '.php', $path, '');

        $fqcn = FileSystemUtils::locate($subfolder, $file, true);
        $this->assertStringEndsWith($subfolder . '\\' . $file, $fqcn, '');
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
