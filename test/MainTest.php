<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\Exception\EmptyDstException;
use dovbysh\PhotoSorterTdd\Exception\EmptySrcException;
use dovbysh\PhotoSorterTdd\Factory;
use dovbysh\PhotoSorterTdd\Main;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testRunEmptySrc()
    {
        $main = new Main('', '');

        $this->expectException(EmptySrcException::class);

        $main->run();
    }

    public function testRunEmptyDst()
    {
        $main = new Main('/tmp', '');

        $this->expectException(EmptyDstException::class);

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
