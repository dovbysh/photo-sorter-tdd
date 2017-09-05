<?php

namespace dovbysh\PhotoSorterTdd\MediaFileDateConcrete;


use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;
use dovbysh\PhotoSorterTdd\SimpleMediaFileDate;

class Exif extends SimpleMediaFileDate
{
    public function getDate(string $filename): \DateTime
    {
        @$exif = exif_read_data($filename);
        $fileTimeStamp = -1;
        if ($exif !== false) {
            if (array_key_exists('DateTime', $exif) && strtotime($exif['DateTime']) > 0) {
                $fileTimeStamp = strtotime($exif['DateTime']);
            } else {
                if (array_key_exists('DateTimeOriginal', $exif) && strtotime($exif['DateTimeOriginal']) > 0) {
                    $fileTimeStamp = strtotime($exif['DateTimeOriginal']);
                } else {
                    if (array_key_exists('DateTimeDigitized', $exif) && strtotime($exif['DateTimeDigitized']) > 0) {
                        $fileTimeStamp = strtotime($exif['DateTimeDigitized']);
                    }
                }
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

}