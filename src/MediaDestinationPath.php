<?php

namespace dovbysh\PhotoSorterTdd;


class MediaDestinationPath
{
    private $dstPath = '';

    /**
     * MediaDestinationPath constructor.
     * @param string $dstPath
     */
    public function __construct($dstPath)
    {
        $this->dstPath = rtrim($dstPath, DIRECTORY_SEPARATOR);
    }

    public function getPath(\DateTime $dateTime)
    {
        return $this->dstPath . '/' . $dateTime->format('Y-m-d');
    }
}