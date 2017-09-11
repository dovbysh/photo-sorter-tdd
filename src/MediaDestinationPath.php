<?php

namespace dovbysh\PhotoSorterTdd;


class MediaDestinationPath
{
    private $dstDir = '';

    /**
     * MediaDestinationPath constructor.
     * @param string $dstDir
     */
    public function __construct($dstDir)
    {
        $this->dstDir = rtrim($dstDir, DIRECTORY_SEPARATOR);
    }

    public function getPath(\DateTime $dateTime)
    {
        return $this->dstDir . '/' . $dateTime->format('Y-m-d');
    }
}