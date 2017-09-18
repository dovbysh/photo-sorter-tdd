<?php

namespace dovbysh\PhotoSorterTest\MediaFileDateConcrete;


use dovbysh\PhotoSorterTdd\MediaFileDateConcrete\MediaInfo;

class MediaInfoStub extends MediaInfo
{
    /**
     * @var \DateTime
     */
    public $actualDate;

    public function __construct()
    {
        $this->actualDate = new \DateTime('2010-01-04 22:01:48');
    }

    protected function getExecOutput(string $filename): array
    {
        $o = <<<"ZZZ"
General
Complete name                            : /media/250_1/d1/test/src/MVI_3289.AVI
Format                                   : AVI
Format/Info                              : Audio Video Interleave
File size                                : 49.4 MiB
Duration                                 : 1mn 27s
Overall bit rate                         : 4 736 Kbps
Mastered date                            : MON JAN 04 22:01:48 2010
Writing application                      : CanonMVI02

Video
ID                                       : 0
Format                                   : JPEG
Codec ID                                 : MJPG
Duration                                 : 1mn 27s
Bit rate                                 : 4 642 Kbps
Width                                    : 320 pixels
Height                                   : 240 pixels
Display aspect ratio                     : 4:3
Frame rate                               : 30.000 fps
Color space                              : YUV
Chroma subsampling                       : 4:2:2
Bit depth                                : 8 bits
Scan type                                : Progressive
Compression mode                         : Lossy
Bits/(Pixel*Frame)                       : 2.015
Stream size                              : 48.4 MiB (98%)

Audio
ID                                       : 1
Format                                   : PCM
Format settings, Endianness              : Little
Format settings, Sign                    : Unsigned
Codec ID                                 : 1
Duration                                 : 1mn 27s
Bit rate mode                            : Constant
Bit rate                                 : 88.2 Kbps
Channel(s)                               : 1 channel
Sampling rate                            : 11.024 KHz
Bit depth                                : 8 bits
Stream size                              : 942 KiB (2%)
Alignment                                : Aligned on interleaves
Interleave, duration                     : 995 ms (29.84 video frames)
Interleave, preload duration             : 1000 ms
ZZZ;
        return explode("\n", $o);
    }

}