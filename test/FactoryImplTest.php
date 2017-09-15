<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\FactoryImpl;
use dovbysh\PhotoSorterTdd\Match;
use dovbysh\PhotoSorterTdd\MediaFileDateConcrete\Exif;
use dovbysh\PhotoSorterTdd\MediaFileDateConcrete\MediaInfo;
use dovbysh\PhotoSorterTdd\MediaFileDateImpl;
use dovbysh\PhotoSorterTest\Helpers\TestFiles;
use PHPUnit\Framework\TestCase;

class FactoryImplTest extends TestCase
{
    private $reflection;
    private $mainProcess;
    /**
     * @var FactoryImpl
     */
    private $factoryImpl;

    /**
     * @var TestFiles
     */
    private $testFiles;

    public function testSrcIterator()
    {
        /* @var RecursiveIteratorIterator */
        $srcIterator = $this->getMainProcessPropertyValue('srcIterator');
        $this->assertInstanceOf(\RecursiveIteratorIterator::class, $srcIterator);
        $this->assertInstanceOf(\RecursiveDirectoryIterator::class, $srcIterator->getInnerIterator());
        $this->assertInstanceOf(\FilesystemIterator::class, $srcIterator->getInnerIterator());
        $this->assertEquals('/tmp', $srcIterator->getPath());
    }

    private function getMainProcessPropertyValue($name)
    {
        $property = $this->reflection->getProperty($name);
        $property->setAccessible(true);

        return $property->getValue($this->mainProcess);

    }

    public function testMediaFileDate()
    {
        $mediaFileDate = $this->getMainProcessPropertyValue('mediaFileDate');

        $simpleMediaFileDateObjects = $this->getPrivatePropertyValue($mediaFileDate, 'simpleMediaFileDateObjects');

        $this->assertInstanceOf(MediaFileDateImpl::class, $mediaFileDate);
        $this->assertEquals([new Exif(), new MediaInfo()], $simpleMediaFileDateObjects);
    }

    private function getPrivatePropertyValue($o, string $name)
    {
        $property = (new \ReflectionObject($o))->getProperty($name);
        $property->setAccessible(true);

        return $property->getValue($o);
    }

    public function testSkip()
    {
        $skip = $this->getMainProcessPropertyValue('skip');
        $this->assertInstanceOf(Match::class, $skip);

        $regExp = $this->getPrivatePropertyValue($skip, 'regExp');
        $this->assertEquals(['~.+\.int~i', '~.+\.bnp~i', '~.+\.bin~i', '~.+\.inp~i', '~IndexerVolumeGuid~', '~WPSettings.dat~', '~SONYCARD.IND~'], $regExp);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->factoryImpl = new FactoryImpl();
        $this->mainProcess = $this->factoryImpl->getMainProcess('/tmp', '/tmp');
        $this->reflection = new \ReflectionObject($this->mainProcess);
    }
}
