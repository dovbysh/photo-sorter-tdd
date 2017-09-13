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
     * @var File
     */
    private $file;

    /**
     * @var TimeShift
     */
    private $timeShift;
    /**
     * @var Message
     */
    private $message;

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

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

    /**
     * @param Message $message
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
    }

    public function run()
    {
        foreach ($this->srcIterator as $sourceFilePath) {
            if ($this->skip->match($sourceFilePath)) {
                $this->message->skipped($sourceFilePath);
            } else {
                try {
                    $date = $this->mediaFileDate->getDate($sourceFilePath);
                    $destinationFile = $this->getDestinationFilePath($date, $sourceFilePath);
                    if ($this->file->exists($destinationFile)) {
                        $sourceSize = $this->file->size($sourceFilePath);
                        $destinationSize = $this->file->size($destinationFile);
                        if ($sourceSize !== $destinationSize) {
                            $this->message->fileExistsAndHasDifferentSize($sourceFilePath, $destinationFile, $sourceSize, $destinationSize);
                        }
                    } else {
                        $this->file->copy($sourceFilePath, $destinationFile);
                        if ($this->file->exists($destinationFile)) {
                            $this->message->successCopied($sourceFilePath, $destinationFile);
                        } else {
                            $this->message->failedToCopy($sourceFilePath, $destinationFile);
                        }
                    }
                } catch (UnableToDetermineFileDate $e) {
                    $this->message->unableToDetermineFileDate($sourceFilePath);
                }
            }
        }
    }

    private function getDestinationFilePath(\DateTime $date, string $sourceFilePath)
    {
        $path = $this->mediaDestinationPath->getPath($date);
        if ($this->timeShift->check($sourceFilePath)) {
            $destinationFile = $path . $this->timeShift->getPartOfPath() . basename($sourceFilePath);
        } else {
            $destinationFile = $path . DIRECTORY_SEPARATOR . basename($sourceFilePath);
        }
        return $destinationFile;
    }

    /**
     * @param TimeShift $timeShift
     */
    public function setTimeShift(TimeShift $timeShift)
    {
        $this->timeShift = $timeShift;
    }
}