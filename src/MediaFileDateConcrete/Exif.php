<?php

namespace dovbysh\PhotoSorterTdd\MediaFileDateConcrete;


use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;
use dovbysh\PhotoSorterTdd\SimpleMediaFileDate;

class Exif extends SimpleMediaFileDate
{
    public function getDate(string $filename): \DateTime
    {
        if (file_exists($filename)) {
            if (is_dir($filename)) {
                $e = new UnableToDetermineFileDate($filename . ' is directory');
                $e->filename = $filename;
                throw $e;
            }
            @$exif = exif_read_data($filename);
            $fileTimeStamp = -1;
            if ($exif !== false) {
                if (array_key_exists('DateTimeOriginal', $exif) && strtotime($exif['DateTimeOriginal']) > 0) {
                    $fileTimeStamp = strtotime($exif['DateTimeOriginal']);
                } else if (array_key_exists('DateTimeDigitized', $exif) && strtotime($exif['DateTimeDigitized']) > 0) {
                    $fileTimeStamp = strtotime($exif['DateTimeDigitized']);
                } else if (array_key_exists('DateTime', $exif) && strtotime($exif['DateTime']) > 0) {
                    $fileTimeStamp = strtotime($exif['DateTime']);
                }
            }

            if ($fileTimeStamp === -1) {
                $e = new UnableToDetermineFileDate($filename);
                $e->filename = $filename;
                throw $e;
            }
            $dt = new \DateTime();
            $dt->setTimestamp($fileTimeStamp);
            return $dt;
        }
        $e = new UnableToDetermineFileDate($filename);
        $e->filename = $filename;
        throw $e;
    }

}