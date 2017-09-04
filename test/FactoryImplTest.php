<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\FactoryImpl;
use PHPUnit\Framework\TestCase;

class FactoryImplTest extends TestCase
{
    public function testGetSrcIterator_returns_InstanceOfRecursiveIterator()
    {
        $f = new FactoryImpl();

        $iterator = $f->getSrcIterator('/tmp');

        $this->assertInstanceOf(\RecursiveIterator::class, $iterator);
    }

    public function testGetSrcIterator_UnexpectedValueException()
    {
        $f = new FactoryImpl();

        $this->expectException(\UnexpectedValueException::class);

        $f->getSrcIterator('/path_not_found');
    }
}
