<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\FactoryImpl;
use dovbysh\PhotoSorterTest\Helpers\TestFiles;
use PHPUnit\Framework\TestCase;

class FactoryImplTest extends TestCase
{
    /**
     * @var FactoryImpl
     */
    private $factoryImpl;

    /**
     * @var TestFiles
     */
    private $testFiles;

    protected function setUp()
    {
        parent::setUp();
        $this->factoryImpl = new FactoryImpl();
    }


    public function testGetSrcIterator_returns_InstanceOfRecursiveIterator()
    {
        $iterator = $this->factoryImpl->getSrcIterator('/tmp');

        $this->assertInstanceOf(\OuterIterator::class, $iterator);
    }

    public function testGetSrcIterator_UnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->factoryImpl->getSrcIterator('/path_not_found');
    }

    public function testSrcIterator_iterateSomthing()
    {
        $this->testFiles = new TestFiles();
        $iterator = $this->factoryImpl->getSrcIterator($this->testFiles->getSourceDir());

        $files = [];
        foreach ($iterator as $fileName) {
            if (is_file($fileName)){
                $files[] = (string) $fileName;
            }
        }
        $expectedFiles = $this->testFiles->getSourceJpegFiles();
        sort($files);
        sort($expectedFiles);

        $this->assertEquals($expectedFiles, $files);
    }
}
