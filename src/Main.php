<?php

namespace dovbysh\PhotoSorterTdd;

use dovbysh\PhotoSorterTdd\Exception\EmptyDstException;
use dovbysh\PhotoSorterTdd\Exception\EmptySrcException;

class Main
{

    private $srcPath = '';
    private $dstPath = '';

    /**
     * @var Factory
     */
    private $factory;

    /**
     * @param Factory $factory
     */
    public function setFactory(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Main constructor.
     * @param string $srcPath
     * @param string $dstPath
     */
    public function __construct(string $srcPath, string $dstPath)
    {
        $this->srcPath = $srcPath;
        $this->dstPath = $dstPath;
    }

    public function run()
    {
        $this->checkConfigured();
        $srcDirectoryIterator = $this->getSrcIterator();
    }

    protected function getSrcIterator(): \OuterIterator
    {
        return $this->factory->getSrcIterator($this->srcPath);
    }

    /**
     * @throws EmptyDstException
     * @throws EmptySrcException
     */
    private function checkConfigured()
    {
        if (empty($this->srcPath)) {
            throw new EmptySrcException('Empty srcPath');
        }
        if (empty($this->dstPath)) {
            throw new EmptyDstException('Empty dstPath');
        }
    }
}