<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\Exception\EmptyDst;
use dovbysh\PhotoSorterTdd\Exception\EmptySrc;
use dovbysh\PhotoSorterTdd\Factory;
use dovbysh\PhotoSorterTdd\Main;
use dovbysh\PhotoSorterTdd\MainProcess;
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


    public function testRunCallgetMainProcess()
    {
        $main = new Main('/tmp', '/tmp');
        $factory = $this->getMockBuilder(Factory::class)->getMockForAbstractClass();
        $main->setFactory($factory);

        $mainProcess = $this->getMockBuilder(MainProcess::class)->getMock();

        $factory->expects($this->once())->method('getMainProcess')->willReturn($mainProcess);
        $mainProcess->expects($this->once())->method('run');

        $main->run();
    }

    public function testConstructor()
    {
        $main = $this->getMockBuilder(Main::class)->setMethods(['setFactory'])->disableOriginalConstructor()->getMock();
        $factory = $this->getMockBuilder(Factory::class)->setMethods(['getSrcIterator'])->getMockForAbstractClass();

        $main->expects($this->once())->method('setFactory')->with($this->equalTo($factory));

        $reflectedClass = new \ReflectionClass(Main::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($main, '/', '/', $factory);
    }
}
