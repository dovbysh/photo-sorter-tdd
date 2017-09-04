<?php

namespace dovbysh\PhotoSorterTdd;


class FactoryImpl implements Factory
{
    public function getSrcIterator(string $path): \OuterIterator
    {
        return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
    }
}