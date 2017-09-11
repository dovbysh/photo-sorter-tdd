<?php

namespace dovbysh\PhotoSorterTdd;


use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;

class MainProcess
{
    /**
     * @var \OuterIterator
     */
    private $srcIterator;

    /**
     * @var MediaFileDate
     */
    private $mediaFileDate;

    /**
     * @var Match
     */
    private $skip;

    /**
     * @var MediaDestinationPath
     */
    private $mediaDestinationPath;

    /**
     * @param MediaDestinationPath $mediaDestinationPath
     */
    public function setMediaDestinationPath(MediaDestinationPath $mediaDestinationPath)
    {
        $this->mediaDestinationPath = $mediaDestinationPath;
    }

    /**
     * @param Match $skip
     */
    public function setSkip(Match $skip)
    {
        $this->skip = $skip;
    }

    /**
     * @param mixed $mediaFileDate
     */
    public function setMediaFileDate(MediaFileDate $mediaFileDate)
    {
        $this->mediaFileDate = $mediaFileDate;
    }

    /**
     * @param OuterIterator $srcIterator
     */
    public function setSrcIterator(\OuterIterator $srcIterator)
    {
        $this->srcIterator = $srcIterator;
    }

    public function run()
    {
        foreach ($this->srcIterator as $fileName) {
            if ($this->skip->match($fileName)) {

            } else {
                try {
                    $date = $this->mediaFileDate->getDate($fileName);
                    $this->mediaDestinationPath->getPath($date);
                } catch (UnableToDetermineFileDate $e) {

                }
            }
        }
    }
}