<?php

namespace dovbysh\PhotoSorterTdd;


use dovbysh\PhotoSorterTdd\MediaFileDateConcrete\Exif;
use dovbysh\PhotoSorterTdd\MediaFileDateConcrete\MediaInfo;

class FactoryImpl implements Factory
{
    private $skipFilter = ['~.+\.int~i', '~.+\.bnp~i', '~.+\.bin~i', '~.+\.inp~i', '~IndexerVolumeGuid~', '~WPSettings.dat~', '~SONYCARD.IND~'];

    public function getMainProcess(string $srcPath, string $dstPath): MainProcess
    {
        $mainProcess = $this->createMainProcess();
        $mainProcess->setSrcIterator($this->getSrcIterator($srcPath));
        $mainProcess->setMediaFileDate($this->getMediaFileDate());
        $mainProcess->setSkip(new Match($this->skipFilter));
        $mainProcess->setTimeShift(new TimeShift());
        $mainProcess->setMediaDestinationPath(new MediaDestinationPath($dstPath));
        $mainProcess->setFile(new File());
        $mainProcess->setMessage(new Message());
        return $mainProcess;

    }

    protected function createMainProcess(): MainProcess
    {
        return new MainProcess();
    }

    private function getSrcIterator(string $path): \OuterIterator
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
    }

    private function getMediaFileDate(): MediaFileDateImpl
    {
        return new MediaFileDateImpl([new Exif(), new MediaInfo()]);
    }
}