<?php

namespace dovbysh\PhotoSorterTdd;


class Message
{
    const TYPE_SKIPPED = 1;
    const TYPE_UnableToDetermineFileDate = 2;
    const TYPE_fileExistsAndHasDifferentSize = 3;
    const TYPE_successCopied = 4;

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
            case self::TYPE_UnableToDetermineFileDate:
                $prefix = '[UnableToDetermineFileDate] ';
                break;
            case self::TYPE_fileExistsAndHasDifferentSize:
                $prefix = '[FileExistsAndHasDifferentSize] ';
                break;
            case self::TYPE_successCopied:
                $prefix = '[OK] ';
                break;
        }
        print $prefix . $message . "\n";
        return true;
    }

    public function unableToDetermineFileDate(string $fileName)
    {
        return $this->log($fileName, self::TYPE_UnableToDetermineFileDate);
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
}