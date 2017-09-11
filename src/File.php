<?php

namespace dovbysh\PhotoSorterTdd;


class File
{
    public function exists(string $file)
    {
        return file_exists($file);
    }

    public function size(string $file)
    {
        return filesize($file);
    }

    public function copy(string $source, string $destination)
    {
        $destinationDir = dirname($destination);
        if (!file_exists($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }
        copy($source, $destination);
    }

}