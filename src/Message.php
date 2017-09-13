<?php

namespace dovbysh\PhotoSorterTdd;


class Message
{
    const TYPE_SKIPPED = 1;
    const TYPE_UNABLE_TO_DETERMIN_FILE_DATE = 2;
    const TYPE_fileExistsAndHasDifferentSize = 3;
    const TYPE_successCopied = 4;
    const TYPE_failedToCopy = 5;

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
            case self::TYPE_fileExistsAndHasDifferentSize:
                $prefix = '[FileExistsAndHasDifferentSize] ';
                break;
            case self::TYPE_successCopied:
                $prefix = '[OK] ';
                break;
            case self::TYPE_failedToCopy:
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
        return $this->log($message, self::TYPE_fileExistsAndHasDifferentSize);
    }

    public function successCopied(string $sourceFile, string $destinationFile)
    {
        $message = $sourceFile . ' -> ' . $destinationFile;
        return $this->log($message, self::TYPE_successCopied);
    }

    public function failedToCopy(string $sourceFile, string $destinationFile)
    {
        $message = $sourceFile . ' -> ' . $destinationFile;
        return $this->log($message, self::TYPE_failedToCopy);
    }
}