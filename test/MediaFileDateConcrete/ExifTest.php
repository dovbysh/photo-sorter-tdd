<?php

namespace dovbysh\PhotoSorterTest\MediaFileDateConcrete;

use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;
use dovbysh\PhotoSorterTdd\MediaFileDateConcrete\Exif;
use dovbysh\PhotoSorterTest\TestDirectoryCreator;
use PHPUnit\Framework\TestCase;

class ExifTest extends TestCase
{
    /**
     * @var TestDirectoryCreator
     */
    private static $testFiles;

    /**
     * @var Exif
     */
    private $exif;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$testFiles = new TestDirectoryCreator();
    }

    public function testJpegFileWithSpecificDate()
    {
        $jpegDate = $this->exif->getDate(self::$testFiles->getJpegFileWithSpecificDate());
        $jpegExpectedDate = self::$testFiles->getJpegSpecificDate();

        $this->assertEquals($jpegExpectedDate, $jpegDate);
    }

    public function testError()
    {
        $this->expectException(UnableToDetermineFileDate::class);

        $this->exif->getDate('file_not_found.txt');
    }

    public function testJpegWithoutDateTimeTag()
    {
        self::$testFiles->createJpegWithoutDateTimeTag();
        $jpegDate = $this->exif->getDate(self::$testFiles->getJpegWithoutDateTimeTag());
        $jpegExpectedDate = self::$testFiles->getJpegSpecificDate();

        $this->assertEquals($jpegExpectedDate, $jpegDate);
    }

    public function testJpegWithoutDateTimeOriginalTag()
    {
        self::$testFiles->createJpegWithout_DateTime_and_DateTimeOriginal_Tag();
        $jpegDate = $this->exif->getDate(self::$testFiles->getJpegWithoutDateTimeOriginalTag());
        $jpegExpectedDate = self::$testFiles->getJpegSpecificDate();

        $this->assertEquals($jpegExpectedDate, $jpegDate);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->exif = new Exif();
    }
}