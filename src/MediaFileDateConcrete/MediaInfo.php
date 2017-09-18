<?php

namespace dovbysh\PhotoSorterTdd\MediaFileDateConcrete;

use dovbysh\PhotoSorterTdd\Exception\UnableToDetermineFileDate;
use dovbysh\PhotoSorterTdd\SimpleMediaFileDate;

class MediaInfo extends SimpleMediaFileDate
{
    public $mediaInfoCommand = '/usr/bin/mediainfo';

    public function getDate(string $filename): \DateTime
    {
        if (file_exists($filename)) {
            if (is_dir($filename)) {
                $e = new UnableToDetermineFileDate($filename . ' is directory');
                $e->filename = $filename;
                throw $e;
            }
            $output = $this->getExecOutput($filename);
            $fileTimeStamp = null;
            if ($output) {
                foreach ($output as $o) {
                    $pairs = preg_split('~\:~', $o, 2);
                    if (!empty($pairs[0]) && !empty($pairs[1]) && preg_match('~Tagged date~i', $pairs[0]) && strtotime($pairs[1])) {
                        $fileTimeStamp = strtotime($pairs[1]);
                        break;
                    } elseif (!empty($pairs[0]) && !empty($pairs[1]) && preg_match('~Mastered date~i', $pairs[0]) && strtotime($pairs[1])) {
                        $fileTimeStamp = strtotime($pairs[1]);
                        break;
                    }
                }
                if ($fileTimeStamp !== null && $fileTimeStamp !== false) {
                    $dt = new \DateTime();
                    $dt->setTimestamp($fileTimeStamp);
                    return $dt;
                }
            }
        }
        $e = new UnableToDetermineFileDate($filename);
        $e->filename = $filename;
        throw $e;
        return $fileTimeStamp;
    }

    protected function getExecOutput(string $filename): array
    {
        $output = [];
        exec($this->mediaInfoCommand . ' ' . $filename, $output);
        return $output;
    }
}