<?php

namespace dovbysh\PhotoSorterTdd;

use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;

class MediaFileDateImpl implements MediaFileDate
{
    /**
     * @var array
     */
    private $simpleMediaFileDateObjects = [];

    /**
     * MediaFileDateImpl constructor.
     * @param array $simpleMediaFileDateObjects
     */
    public function __construct(array $simpleMediaFileDateObjects = [])
    {
        foreach ($simpleMediaFileDateObjects as $simpleMediaFileDateObject) {
            $this->addSimpleMediaFileDate($simpleMediaFileDateObject);
        }
    }

    /**
     * @param SimpleMediaFileDate $simpleMediaFileDateObject
     */
    public function addSimpleMediaFileDate(SimpleMediaFileDate $simpleMediaFileDateObject)
    {
        $this->simpleMediaFileDateObjects[] = $simpleMediaFileDateObject;
    }

    /**
     * @param string $filename
     * @return \DateTime
     * @throws UnableToDetermineFileDate
     */
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