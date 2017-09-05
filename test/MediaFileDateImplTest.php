<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;
use dovbysh\PhotoSorterTdd\MediaFileDateImpl;
use dovbysh\PhotoSorterTdd\SimpleMediaFileDate;
use PHPUnit\Framework\TestCase;

class MediaFileDateImplTest extends TestCase
{
    /**
     * @var MediaFileDateImpl
     */
    private $mediaFileDateImpl;

    public function testOneMediaFileFired()
    {
        $simpleMediaFile = $this->createAndAssignMediafileMock();

        $simpleMediaFile->expects($this->once())->method('getDate')->willReturn(new \DateTime())->with($this->equalTo('zzz.txt'));

        $this->mediaFileDateImpl->getDate('zzz.txt');
    }

    public function testTwoMediaFileFired_FirstUnableDetermineFileDate()
    {
        $firstMediaFile = $this->createAndAssignMediafileMock();
        $secondMediaFile = $this->createAndAssignMediafileMock();

        $firstMediaFile->expects($this->once())->method('getDate')->willThrowException(new UnableToDetermineFileDate())->with($this->equalTo('zzz.txt'));
        $secondMediaFile->expects($this->once())->method('getDate')->willReturn(new \DateTime())->with($this->equalTo('zzz.txt'));

        $this->mediaFileDateImpl->getDate('zzz.txt');
    }

    public function testManyMediaFile_AllOfThem_UnableToDetermineFileDate()
    {
        for ($i = 0; $i < 5; $i++) {
            $mediaFile = $this->createAndAssignMediafileMock();
            $mediaFile->expects($this->once())->method('getDate')->willThrowException(new UnableToDetermineFileDate())->with($this->equalTo('zzz.txt'));
        }

        $this->expectException(UnableToDetermineFileDate::class);

        $this->mediaFileDateImpl->getDate('zzz.txt');
    }

    public function testConstructor()
    {
        $simpleMediaFileDateObjects = [];
        for ($i = 0; $i < 5; $i++) {
            $mediaFile = $this->getMediafile();
            $mediaFile->expects($this->once())->method('getDate')->willThrowException(new UnableToDetermineFileDate())->with($this->equalTo('zzz.txt'));
            $simpleMediaFileDateObjects[] = $mediaFile;
        }
        $mediaFileDateImpl = new MediaFileDateImpl($simpleMediaFileDateObjects);

        $this->expectException(UnableToDetermineFileDate::class);

        $mediaFileDateImpl->getDate('zzz.txt');
    }

    private function createAndAssignMediafileMock()
    {
        $mediaFile = $this->getMediafile();
        $this->mediaFileDateImpl->addSimpleMediaFileDate($mediaFile);
        return $mediaFile;
    }

    private function getMediafile() {
        return $this->getMockBuilder(SimpleMediaFileDate::class)->getMockForAbstractClass();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->mediaFileDateImpl = new MediaFileDateImpl();
    }
}