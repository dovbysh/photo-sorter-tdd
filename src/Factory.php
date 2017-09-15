<?php

namespace dovbysh\PhotoSorterTdd;


interface Factory
{
    public function getMainProcess(string $srcPath, string $dstPath): MainProcess;
}