<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\FactoryImpl;
use PHPUnit\Framework\TestCase;

class FactoryImplTest extends TestCase
{
    public function testNothing()
    {
        $f = new FactoryImpl();

        $iterator = $f->getSrcIterator('/tmp');

        $this->assertInstanceOf(\RecursiveIterator::class, $iterator);
    }
}
