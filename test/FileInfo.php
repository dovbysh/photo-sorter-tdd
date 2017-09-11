<?php

namespace dovbysh\PhotoSorterTest;


class FileInfo
{
    private $file = '';
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * FileInfo constructor.
     * @param string $file
     * @param \DateTime $date
     */
    public function __construct($file, \DateTime $date)
    {
        $this->file = $file;
        $this->date = $date;
    }

    public function toArray()
    {
        return [$this->file, $this->date];
    }
}