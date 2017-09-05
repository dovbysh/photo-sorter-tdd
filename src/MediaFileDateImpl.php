<?php

namespace dovbysh\PhotoSorterTdd;

use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;

class MediaFileDateImpl implements MediaFileDate
{
    private $simpleMediaFileDateObjects = [];

    public function __construct(array $simpleMediaFileDateObjects = [])
    {
        foreach ($simpleMediaFileDateObjects as $simpleMediaFileDateObject) {
            $this->addSimpleMediaFileDate($simpleMediaFileDateObject);
        }
    }

    public function addSimpleMediaFileDate(SimpleMediaFileDate $simpleMediaFileDateObject)
    {
        $this->simpleMediaFileDateObjects[] = $simpleMediaFileDateObject;
    }

    public function getDate(string $filename): \DateTime
    {
        foreach ($this->simpleMediaFileDateObjects as $mediaFileDate) {
            try {
                $date = $mediaFileDate->getDate($filename);
                return $date;
            } catch (UnableToDetermineFileDate $e) {

            }
        }
        $e = new UnableToDetermineFileDate($filename);
        $e->filename = $filename;
        throw $e;
    }


}