<?php

namespace dovbysh\PhotoSorterTest;


use dovbysh\PhotoSorterTdd\Exception\NotFound;
use dovbysh\PhotoSorterTdd\Match;
use dovbysh\PhotoSorterTdd\TimeShift;
use PHPUnit\Framework\TestCase;

class TimeShiftTest extends TestCase
{
    /**
     * @var TimeShift
     */
    private $timeShift;

    public function testCheckIsTrue()
    {
        $this->assertTrue($this->timeShift->check('/sss/TIMESHIFT/201701010000000/123.jpg'));
        $this->assertEquals('/TIMESHIFT/201701010000000/', $this->timeShift->getPartOfPath());
    }

    public function testCheckIsFalse()
    {
        $this->assertFalse($this->timeShift->check('/sss/zzz/201701010000000/123.jpg'));

        $this->expectException(NotFound::class);
        $this->assertEquals('', $this->timeShift->getPartOfPath());
    }

    public function testConstructor()
    {
        $match = $this->getMockBuilder(Match::class)->disableOriginalConstructor()->getMock();


        $match->expects($this->once())->method('setRegExp');
        $match->expects($this->once())->method('match')->willReturn(true);
        $match->expects($this->once())->method('getMatched')->willReturn('/TIMESHIFT/201701010000000/');

        $timeShift = new TimeShift($match, 'zzz');
        $timeShift->check('/sss/TIMESHIFT/201701010000000/123.jpg');
        $timeShift->getPartOfPath();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->timeShift = new TimeShift();
    }
}