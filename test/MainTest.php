<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\Exception\EmptyDst;
use dovbysh\PhotoSorterTdd\Exception\EmptySrc;
use dovbysh\PhotoSorterTdd\Factory;
use dovbysh\PhotoSorterTdd\Main;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testRunEmptySrc()
    {
        $main = new Main('', '');

        $this->expectException(EmptySrc::class);

        $main->run();
    }

    public function testRunEmptyDst()
    {
        $main = new Main('/tmp', '');

        $this->expectException(EmptyDst::class);

        $main->run();
    }


    public function testRunCallGetSrcIterator()
    {
        $main = new Main('/tmp', '/tmp');
        $factory = $this->getMockBuilder(Factory::class)->setMethods(['getSrcIterator'])->getMockForAbstractClass();
        $main->setFactory($factory);

        $factory->expects($this->once())->method('getSrcIterator')->with($this->equalTo('/tmp'));

        $main->run();
    }
}
