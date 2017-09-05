<?php

namespace dovbysh\PhotoSorterTdd;

interface MediaFileDate
{
    public function getDate(string $filename): \DateTime;
}