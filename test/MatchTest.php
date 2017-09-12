<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\Exception\InvalidRegExp;
use dovbysh\PhotoSorterTdd\Exception\NotFound;
use dovbysh\PhotoSorterTdd\Match;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    public function testMatchSimpleValue()
    {
        $matcher = new Match('/^zzz$/');

        $result = $matcher->match('zzz');

        $this->assertTrue($result);
    }

    public function testDontMatchSimpleValue()
    {
        $matcher = new Match('/^zzz$/');

        $result = $matcher->match('zz');

        $this->assertFalse($result);
    }

    public function testInvalidRegexp()
    {
        $this->expectException(InvalidRegExp::class);

        new Match(new \stdClass());
    }

    public function testMatchOneFromPatterns()
    {
        $matcher = new Match(['/^zzz$/', '~(/TIMESHIFT/\d+/)~', '~xxx~']);

        $result = $matcher->match('/tmp/TIMESHIFT/584724398/zzz');

        $this->assertTrue($result);
    }

    public function testMatchNothingFromPatterns()
    {
        $matcher = new Match(['/^zzz$/', '~(/TIMESHIFT/\d+/)~', '~xxx~']);

        $result = $matcher->match('/tmp/Ttttt/584724398/zzz');

        $this->assertFalse($result);
    }

    public function testMatchNothingFromPatterns_getMatchedCall()
    {
        $matcher = new Match(['/^zzz$/', '~(/TIMESHIFT/\d+/)~', '~xxx~']);
        $matcher->match('/tmp/Ttttt/584724398/zzz');

        $this->expectException(NotFound::class);

        $matcher->getMatched();
    }

    public function testMatchTimeShiftFileFromPatterns()
    {
        $matcher = new Match('~(/TIMESHIFT/\d+/)~');

        $result = $matcher->match('/tmp/TIMESHIFT/584724398/zzz.jpg');
        $matched = $matcher->getMatched()[1];

        $this->assertTrue($result);
        $this->assertEquals('/TIMESHIFT/584724398/', $matched);
    }
}