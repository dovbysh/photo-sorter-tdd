<?php

namespace dovbysh\PhotoSorterTdd;

use dovbysh\PhotoSorterTdd\Exception\EmptyDst;
use dovbysh\PhotoSorterTdd\Exception\EmptySrc;

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
    public function __construct(string $srcPath, string $dstPath, Factory $factory = null)
    {
        $this->srcPath = $srcPath;
        $this->dstPath = $dstPath;
        if ($factory instanceof Factory) {
            $this->setFactory($factory);
        }
    }

    public function run()
    {
        $this->checkConfigured();
        $mainProcess = $this->factory->getMainProcess($this->srcPath, $this->dstPath);
        $mainProcess->run();
    }

    /**
     * @throws EmptyDst
     * @throws EmptySrc
     */
    private function checkConfigured()
    {
        if (empty($this->srcPath)) {
            throw new EmptySrc('Empty srcPath');
        }
        if (empty($this->dstPath)) {
            throw new EmptyDst('Empty dstPath');
        }
    }
}