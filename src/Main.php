<?php

namespace dovbysh\PhotoSorterTdd;


class Main
{

    private $srcPath = '';
    private $dstPath = '';

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
        $srcDirectoryIterator = $this->getSrcIterator();
    }

    protected function getSrcIterator(): \RecursiveDirectoryIterator
    {
        return new \DirectoryIterator($this->srcPath);
    }
}