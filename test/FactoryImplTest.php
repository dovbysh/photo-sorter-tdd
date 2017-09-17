<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\FactoryImpl;
use dovbysh\PhotoSorterTdd\File;
use dovbysh\PhotoSorterTdd\MainProcess;
use dovbysh\PhotoSorterTdd\Match;
use dovbysh\PhotoSorterTdd\MediaDestinationPath;
use dovbysh\PhotoSorterTdd\MediaFileDateConcrete\Exif;
use dovbysh\PhotoSorterTdd\MediaFileDateConcrete\MediaInfo;
use dovbysh\PhotoSorterTdd\MediaFileDateImpl;
use dovbysh\PhotoSorterTdd\Message;
use dovbysh\PhotoSorterTdd\TimeShift;
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

        $regExp = $this->getPrivatePropertyValue($skip, 'regExp');
        $this->assertEquals(['~.+\.int~i', '~.+\.bnp~i', '~.+\.bin~i', '~.+\.inp~i', '~IndexerVolumeGuid~', '~WPSettings.dat~', '~SONYCARD.IND~'], $regExp);
    }

    public function testMediaDestinationPath()
    {
        $mediaDestinationPath = $this->getMainProcessPropertyValue('mediaDestinationPath');
        $dstPath = $this->getPrivatePropertyValue($mediaDestinationPath, 'dstPath');

        $this->assertEquals('/tmp/xxx', $dstPath);
    }

    public function testMockedMainProcess()
    {
        $mainProcess = $this->getMockBuilder(MainProcess::class)->getMock();
        $factory = new FactoryImplStub();
        $factory->mainProcessStub = $mainProcess;

        $mainProcess->expects($this->once())->method('setSrcIterator')->with($this->isInstanceOf(\RecursiveIteratorIterator::class));
        $mainProcess->expects($this->once())->method('setMediaFileDate')->with($this->isInstanceOf(MediaFileDateImpl::class));
        $mainProcess->expects($this->once())->method('setSkip')->with($this->isInstanceOf(Match::class));
        $mainProcess->expects($this->once())->method('setTimeShift')->with($this->isInstanceOf(TimeShift::class));
        $mainProcess->expects($this->once())->method('setMediaDestinationPath')->with($this->isInstanceOf(MediaDestinationPath::class));
        $mainProcess->expects($this->once())->method('setFile')->with($this->isInstanceOf(File::class));
        $mainProcess->expects($this->once())->method('setMessage')->with($this->isInstanceOf(Message::class));
        $mainProcessActual = $factory->getMainProcess('/tmp', '/tmp');
        $this->assertSame($mainProcess, $mainProcessActual);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->factoryImpl = new FactoryImpl();
        $this->mainProcess = $this->factoryImpl->getMainProcess('/tmp', '/tmp/xxx');
        $this->reflection = new \ReflectionObject($this->mainProcess);
    }
}
