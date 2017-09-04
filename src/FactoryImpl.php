<?php

namespace dovbysh\PhotoSorterTdd;


class FactoryImpl implements Factory
{
    public function getSrcIterator(string $path): \OuterIterator
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
    }
}