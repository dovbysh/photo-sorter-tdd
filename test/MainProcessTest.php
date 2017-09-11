<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;
use dovbysh\PhotoSorterTdd\MainProcess;
use dovbysh\PhotoSorterTdd\Match;
use dovbysh\PhotoSorterTdd\MediaDestinationPath;
use dovbysh\PhotoSorterTdd\MediaFileDate;
use PHPUnit\Framework\TestCase;

class MainProcessTest extends TestCase
{
    /**
     * @var MainProcess
     */
    private $mainProcess;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $srcIterator;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $mediaFileDate;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $skip;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $mediaDestinationPath;

    public function testSkipReturnsTrue()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(true);
        $this->mediaDestinationPath->expects($this->never())->method('getPath');

        $this->mainProcess->run();
    }

    private function commonSrcIterator()
    {
        $this->srcIterator->expects($this->once())->method('rewind');
        $this->srcIterator->expects($this->exactly(2))->method('valid')->willReturn(true, false);
        $this->srcIterator->expects($this->once())->method('next');
        $this->srcIterator->expects($this->once())->method('current')->willReturn('');
    }

    public function testUnableToDetermineFileDate()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(false);

        $this->mediaFileDate->expects($this->once())->method('getDate')->willThrowException(new UnableToDetermineFileDate());
        $this->mediaDestinationPath->expects($this->never())->method('getPath');;

        $this->mainProcess->run();
    }

    public function testGetDateWillReturn()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(false);

        $this->mediaFileDate->expects($this->once())->method('getDate')->willReturn(new \DateTime('2017-01-01 00:00:00'));
        $this->mediaDestinationPath->expects($this->once())->method('getPath')->willReturn('/2017-01-01');

        $this->mainProcess->run();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->mainProcess = new MainProcess();

        $this->srcIterator = $this->getMockBuilder(\OuterIterator::class)->getMockForAbstractClass();
        $this->mainProcess->setSrcIterator($this->srcIterator);

        $this->mediaFileDate = $this->getMockBuilder(MediaFileDate::class)->getMockForAbstractClass();
        $this->mainProcess->setMediaFileDate($this->mediaFileDate);

        $this->skip = $this->getMockBuilder(Match::class)->disableOriginalConstructor()->getMock();
        $this->mainProcess->setSkip($this->skip);

        $this->mediaDestinationPath = $this->getMockBuilder(MediaDestinationPath::class)->disableOriginalConstructor()->getMock();
        $this->mainProcess->setMediaDestinationPath($this->mediaDestinationPath);

    }
}