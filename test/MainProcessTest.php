<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\MainProcess;
use PHPUnit\Framework\TestCase;

class MainProcessTest extends TestCase
{
    public function testSrcIterator()
    {
        $mainProcess = new MainProcess();
        $spy = $this->getMockBuilder(\OuterIterator::class)->getMockForAbstractClass();
        //$mainProcess->setSrcIterator(new \RecursiveIteratorIterator(new \RecursiveArrayIterator(['zzz', 'zzx'=>['zzzz','zzzz2']])));
        $mainProcess->setSrcIterator($spy);
        $spy->expects($this->once())->method('rewind');
        $mainProcess->run();
    }
}