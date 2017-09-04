<?php

namespace dovbysh\PhotoSorterTdd;


class MainProcess
{
    /**
     * @var \OuterIterator
     */
    private $srcIterator;

    /**
     * @param OuterIterator $srcIterator
     */
    public function setSrcIterator(\OuterIterator $srcIterator)
    {
        $this->srcIterator = $srcIterator;
    }

    public function run(){
        foreach ($this->srcIterator as $fileName) {

        }
    }
}