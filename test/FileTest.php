<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\File;
use dovbysh\PhotoSorterTest\Helpers\TestFiles;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /**
     * @var TestFiles
     */
    private static $testFiles;

    /**
     * @var File
     */
    private $file;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$testFiles = new TestFiles();
    }

    public function testNotExists()
    {
        $this->assertFalse($this->file->exists('/file_dose_not_exists'));
    }

    public function testExists()
    {
        $this->assertTrue($this->file->exists(self::$testFiles->getThmFile()));
    }

    public function testFileSize()
    {
        $this->assertEquals(3373, $this->file->size(self::$testFiles->getThmFile()));
    }

    public function testCopy()
    {
        $source = self::$testFiles->getThmFile();
        $destination = self::$testFiles->getDestinationDir() . DIRECTORY_SEPARATOR . 'zzz' . DIRECTORY_SEPARATOR . 'zz21z' . DIRECTORY_SEPARATOR . basename($source);

        $this->file->copy($source, $destination);

        $this->assertTrue($this->file->exists($destination));
        $this->assertEquals($this->file->size($source), $this->file->size($destination));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->file = new File();
    }
}
