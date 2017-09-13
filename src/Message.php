<?php

namespace dovbysh\PhotoSorterTdd;


class Message
{
    const TYPE_SKIPPED = 1;
    const TYPE_UNABLE_TO_DETERMIN_FILE_DATE = 2;
    const TYPE_FILE_EXISTS_AND_HAS_DIFFERENT_SIZE = 3;
    const TYPE_SUCCESS_COPIED = 4;
    const TYPE_FAILED_TO_COPY = 5;

    public function skipped(string $fileName)
    {
        return $this->log($fileName, self::TYPE_SKIPPED);
    }

    protected function log(string $message, int $type)
    {
        $prefix = '';
        switch ($type) {
            case self::TYPE_SKIPPED:
                $prefix = '[File skipped] ';
                break;
            case self::TYPE_UNABLE_TO_DETERMIN_FILE_DATE:
                $prefix = '[UnableToDetermineFileDate] ';
                break;
            case self::TYPE_FILE_EXISTS_AND_HAS_DIFFERENT_SIZE:
                $prefix = '[FileExistsAndHasDifferentSize] ';
                break;
            case self::TYPE_SUCCESS_COPIED:
                $prefix = '[OK] ';
                break;
            case self::TYPE_FAILED_TO_COPY:
                $prefix = '[FailedToCopy] ';
                break;
        }
        print $prefix . $message . "\n";
        return true;
    }

    public function unableToDetermineFileDate(string $fileName)
    {
        return $this->log($fileName, self::TYPE_UNABLE_TO_DETERMIN_FILE_DATE);
    }

    public function fileExistsAndHasDifferentSize(string $sourceFile, string $destinationFile, int $sourceSize, int $destinationSize)
    {
        $message = $sourceFile . ' - ' . $sourceSize . '; ' . $destinationFile . ' - ' . $destinationSize;
        return $this->log($message, self::TYPE_FILE_EXISTS_AND_HAS_DIFFERENT_SIZE);
    }

    public function successCopied(string $sourceFile, string $destinationFile)
    {
        $message = $sourceFile . ' -> ' . $destinationFile;
        return $this->log($message, self::TYPE_SUCCESS_COPIED);
    }

    public function failedToCopy(string $sourceFile, string $destinationFile)
    {
        $message = $sourceFile . ' -> ' . $destinationFile;
        return $this->log($message, self::TYPE_FAILED_TO_COPY);
    }
}