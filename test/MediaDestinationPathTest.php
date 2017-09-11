<?php

namespace dovbysh\PhotoSorterTest;

use dovbysh\PhotoSorterTdd\MediaDestinationPath;
use PHPUnit\Framework\TestCase;

class MediaDestinationPathTest extends TestCase
{
    public function testGetPathFromRoot()
    {
        $m = new MediaDestinationPath(DIRECTORY_SEPARATOR);
        $this->assertEquals(DIRECTORY_SEPARATOR . '2017-01-01', $m->getPath(new \DateTime('2017-01-01 00:00:00')));
    }

    public function testGetPathFromNonRoot()
    {
        $m = new MediaDestinationPath(DIRECTORY_SEPARATOR . 'somedir');
        $this->assertEquals(DIRECTORY_SEPARATOR . 'somedir' . DIRECTORY_SEPARATOR . '2017-01-01', $m->getPath(new \DateTime('2017-01-01 00:00:00')));
    }

    public function testGetPathFromNonRoot2Levels()
    {
        $m = new MediaDestinationPath(DIRECTORY_SEPARATOR . 'somedir' . DIRECTORY_SEPARATOR . 'zzz');
        $this->assertEquals(DIRECTORY_SEPARATOR . 'somedir' . DIRECTORY_SEPARATOR . 'zzz' . DIRECTORY_SEPARATOR . '2017-01-01', $m->getPath(new \DateTime('2017-01-01 00:00:00')));
    }

    public function testGetPathFromNonRootWithSlashLeading()
    {
        $m = new MediaDestinationPath(DIRECTORY_SEPARATOR . 'somedir' . DIRECTORY_SEPARATOR);
        $this->assertEquals(DIRECTORY_SEPARATOR . 'somedir' . DIRECTORY_SEPARATOR . '2017-01-01', $m->getPath(new \DateTime('2017-01-01 00:00:00')));
    }
}