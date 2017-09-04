<?php

namespace dovbysh\PhotoSorterTdd;


class FactoryImpl implements Factory
{
    public function getSrcIterator(string $path): \RecursiveIterator
    {
        return new \RecursiveDirectoryIterator($path);
    }
}