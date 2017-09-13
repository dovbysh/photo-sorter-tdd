<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;
use dovbysh\PhotoSorterTdd\File;
use dovbysh\PhotoSorterTdd\MainProcess;
use dovbysh\PhotoSorterTdd\Match;
use dovbysh\PhotoSorterTdd\MediaDestinationPath;
use dovbysh\PhotoSorterTdd\MediaFileDate;
use dovbysh\PhotoSorterTdd\Message;
use dovbysh\PhotoSorterTdd\TimeShift;
use PHPUnit\Framework\TestCase;

class MainProcessTest extends TestCase
{
    /**
     * @var MainProcess
     */
    private $mainProcess;

    private $srcIterator;
    private $mediaFileDate;
    private $skip;
    private $mediaDestinationPath;
    private $file;
    private $timeShift;

    public function testSkipReturnsTrue()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(true);
        $this->message->expects($this->once())->method('skipped');
        $this->mediaDestinationPath->expects($this->never())->method('getPath');

        $this->mainProcess->run();
    }

    private function commonSrcIterator()
    {
        $this->srcIterator->expects($this->once())->method('rewind');
        $this->srcIterator->expects($this->exactly(2))->method('valid')->willReturn(true, false);
        $this->srcIterator->expects($this->once())->method('next');
        $this->srcIterator->expects($this->once())->method('current')->willReturn('/z.jpg');
    }

    public function testUnableToDetermineFileDate()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(false);
        $this->message->expects($this->never())->method('skipped');

        $this->mediaFileDate->expects($this->once())->method('getDate')->willThrowException(new UnableToDetermineFileDate());
        $this->mediaDestinationPath->expects($this->never())->method('getPath');
        $this->timeShift->expects($this->never())->method('check');
        $this->message->expects($this->once())->method('unableToDetermineFileDate');

        $this->mainProcess->run();
    }

    public function testGetDateWillReturn_DestinationFileExistsAndHasDifferentSize()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(false);
        $this->message->expects($this->never())->method('skipped');

        $this->mediaFileDate->expects($this->once())->method('getDate')->willReturn(new \DateTime('2017-01-01 00:00:00'));
        $this->message->expects($this->never())->method('unableToDetermineFileDate');
        $this->mediaDestinationPath->expects($this->once())->method('getPath')->willReturn('/2017-01-01');
        $this->timeShift->expects($this->once())->method('check')->willReturn(false);
        $this->timeShift->expects($this->never())->method('getPartOfPath');
        $this->file->expects($this->once())->method('exists')->willReturn(true);
        $this->file->expects($this->exactly(2))->method('size')->willReturn(123, 456);
        $this->message->expects($this->once())->method('fileExistsAndHasDifferentSize');

        $this->mainProcess->run();
    }

    public function testGetDateWillReturn_DestinationFileExistsAndHasSameSize()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(false);
        $this->message->expects($this->never())->method('skipped');

        $this->mediaFileDate->expects($this->once())->method('getDate')->willReturn(new \DateTime('2017-01-01 00:00:00'));
        $this->message->expects($this->never())->method('unableToDetermineFileDate');
        $this->mediaDestinationPath->expects($this->once())->method('getPath')->willReturn('/2017-01-01');
        $this->timeShift->expects($this->once())->method('check')->willReturn(false);
        $this->timeShift->expects($this->never())->method('getPartOfPath');
        $this->file->expects($this->once())->method('exists')->willReturn(true);
        $this->file->expects($this->exactly(2))->method('size')->willReturn(123, 123);
        $this->message->expects($this->never())->method('fileExistsAndHasDifferentSize');
        $this->file->expects($this->never())->method('copy');

        $this->mainProcess->run();
    }

    public function testSuccessCopied()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(false);
        $this->message->expects($this->never())->method('skipped');

        $this->mediaFileDate->expects($this->once())->method('getDate')->willReturn(new \DateTime('2017-01-01 00:00:00'));
        $this->message->expects($this->never())->method('unableToDetermineFileDate');
        $this->mediaDestinationPath->expects($this->once())->method('getPath')->willReturn('/2017-01-01');
        $this->timeShift->expects($this->once())->method('check')->willReturn(false);
        $this->timeShift->expects($this->never())->method('getPartOfPath');
        $this->file->expects($this->exactly(2))->method('exists')->willReturn(false, true);
        $this->file->expects($this->never())->method('size');
        $this->file->expects($this->once())->method('copy');
        $this->message->expects($this->once())->method('successCopied');

        $this->mainProcess->run();
    }

    public function testFailedToCopy()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(false);
        $this->message->expects($this->never())->method('skipped');

        $this->mediaFileDate->expects($this->once())->method('getDate')->willReturn(new \DateTime('2017-01-01 00:00:00'));
        $this->message->expects($this->never())->method('unableToDetermineFileDate');
        $this->mediaDestinationPath->expects($this->once())->method('getPath')->willReturn('/2017-01-01');
        $this->timeShift->expects($this->once())->method('check')->willReturn(false);
        $this->timeShift->expects($this->never())->method('getPartOfPath');
        $this->file->expects($this->exactly(2))->method('exists')->willReturn(false, false);
        $this->file->expects($this->never())->method('size');
        $this->file->expects($this->once())->method('copy');
        $this->message->expects($this->never())->method('successCopied');
        $this->message->expects($this->once())->method('failedToCopy');

        $this->mainProcess->run();
    }

    public function testTimeShiftReturn_DestinationFileDoseNotExist()
    {
        $this->commonSrcIterator();

        $this->skip->expects($this->once())->method('match')->willReturn(false);
        $this->message->expects($this->never())->method('skipped');

        $this->mediaFileDate->expects($this->once())->method('getDate')->willReturn(new \DateTime('2017-01-01 00:00:00'));
        $this->message->expects($this->never())->method('unableToDetermineFileDate');
        $this->mediaDestinationPath->expects($this->once())->method('getPath')->willReturn('/2017-01-01');
        $this->timeShift->expects($this->once())->method('check')->willReturn(true);
        $this->timeShift->expects($this->once())->method('getPartOfPath')->willReturn('/timeshift/123/');
        $this->file->expects($this->exactly(2))->method('exists')->willReturn(false, true);
        $this->file->expects($this->never())->method('size');
        $this->file->expects($this->once())->method('copy');
        $this->message->expects($this->once())->method('successCopied');

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

        $this->timeShift = $this->getMockBuilder(TimeShift::class)->disableOriginalConstructor()->getMock();
        $this->mainProcess->setTimeShift($this->timeShift);

        $this->mediaDestinationPath = $this->getMockBuilder(MediaDestinationPath::class)->disableOriginalConstructor()->getMock();
        $this->mainProcess->setMediaDestinationPath($this->mediaDestinationPath);

        $this->file = $this->getMockBuilder(File::class)->getMock();
        $this->mainProcess->setFile($this->file);

        $this->message = $this->getMockBuilder(Message::class)->getMock();
        $this->mainProcess->setMessage($this->message);
    }
}