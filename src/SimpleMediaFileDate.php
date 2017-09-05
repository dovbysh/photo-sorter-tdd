<?php

namespace dovbysh\PhotoSorterTdd;


abstract class SimpleMediaFileDate implements MediaFileDate
{
    abstract public function getDate(string $filename): \DateTime;
}