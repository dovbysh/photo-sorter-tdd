<?php

namespace dovbysh\PhotoSorterTdd;


interface Factory
{
    public function getSrcIterator(string $path): \RecursiveIterator;
}