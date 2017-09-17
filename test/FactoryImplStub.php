<?php

namespace dovbysh\PhotoSorterTest;


use dovbysh\PhotoSorterTdd\FactoryImpl;
use dovbysh\PhotoSorterTdd\MainProcess;

class FactoryImplStub extends FactoryImpl
{
    /**
     * @var MainProcess
     */
    public $mainProcessStub;

    protected function createMainProcess(): MainProcess
    {
        return $this->mainProcessStub;
    }

}