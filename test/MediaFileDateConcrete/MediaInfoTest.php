<?php

namespace dovbysh\PhotoSorterTest\MediaFileDateConcrete;

use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;
use dovbysh\PhotoSorterTdd\MediaFileDateConcrete\MediaInfo;
use dovbysh\PhotoSorterTest\TestDirectoryCreator;
use PHPUnit\Framework\TestCase;

class MediaInfoTest extends TestCase
{
    /**
     * @var TestDirectoryCreator
     */
    private static $testFiles;

    /**
     * @var MediaInfo
     */
    private $mediaInfo;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::initTestFilesIfNecessary();
    }

    public static function initTestFilesIfNecessary()
    {
        if (is_null(self::$testFiles)) {
            self::$testFiles = new TestDirectoryCreator();
            self::$testFiles->setUpVideo();
        }
    }

    public function testError()
    {
        $this->expectException(UnableToDetermineFileDate::class);

        $this->mediaInfo->getDate('file_not_found.txt');
    }

    public function testIfWePassJpegThanError()
    {
        $this->expectException(UnableToDetermineFileDate::class);

        $this->mediaInfo->getDate(self::$testFiles->getJpegFileWithSpecificDate());
    }

    /**
     * @dataProvider dataProviderForSampleVideos
     */
    public function testGetDateFromSampleVideos($videoFile, $expectedDate)
    {
        $actualDate = $this->mediaInfo->getDate($videoFile);
        $this->assertEquals($expectedDate, $actualDate);
    }

    public function dataProviderForSampleVideos()
    {
        self::initTestFilesIfNecessary();
        $videoFiles = self::$testFiles->getSourceVideoFiles();
        $data = [];
        foreach ($videoFiles as $videoFile) {
            $data[] = [$videoFile, new \DateTime('2017-09-05 15:32:38')];
        }
        return $data;
    }

    protected function setUp()
    {
        parent::setUp();
        $this->mediaInfo = new MediaInfo();
    }

}