<?php

namespace dovbysh\PhotoSorterTest;

class TestDirectoryCreator
{
    private $rootPath;
    private $sourceDir = '';
    private $destinationDir = '';
    private $exiftool = '/usr/bin/exiftool';
    private $jpegFileWithNowDate = '';
    private $jpegFileWithSpecificDate = '';
    private $now = 0;
    private $jpegSpecificDate = 0;

    private $sourceJpegFiles = [];
    private $jpegWithoutDateTimeTag = '';
    private $jpegWithoutDateTimeOriginalTag = '';
    private $dataDir = '';
    private $sourceVideoFiles = [];

    /**
     * @return array
     */
    public function getSourceVideoFiles(): array
    {
        return $this->sourceVideoFiles;
    }

    public function __construct(bool $selfInitialize = true)
    {
        $this->dataDir = __DIR__ . '/data/';

        if ($selfInitialize) {
            $this->setUp();
        }
    }

    /**
     * set up test environmemt
     */
    public function setUp()
    {
        $this->rootPath = sys_get_temp_dir() . '/' . str_replace('\\', '/', __CLASS__) . mt_rand();
        $this->sourceDir = $this->rootPath . '/source';
        $this->destinationDir = $this->rootPath . '/destinationDir';
        mkdir($this->sourceDir, 0777, true);
        mkdir($this->destinationDir, 0777, true);

        $this->now = time();
        $this->jpegSpecificDate = mktime(mt_rand(0, 24), mt_rand(0, 60), mt_rand(0, 60), mt_rand(1, 12), mt_rand(0, 32), mt_rand(2000, 2016));
        $this->jpegFileWithSpecificDate = $this->sourceDir . '/' . mt_rand() . '/' . mt_rand() . '/' . mt_rand();
        mkdir($this->jpegFileWithSpecificDate, 0777, true);
        $this->jpegFileWithSpecificDate .= mt_rand() . '.jpg';

        $this->jpegFileWithNowDate = $this->sourceDir . '/a.jpg';
        $im = imagecreatetruecolor(20, 20);
        imagefill($im, 0, 0, 255);
        imagejpeg($im, $this->jpegFileWithNowDate);
        $dt = date('Y:m:d H:i:s', $this->now);
        `{$this->exiftool} -tagsfromfile {$this->dataDir}a.jpg -exif {$this->jpegFileWithNowDate}`;
        `{$this->exiftool} -alldates="$dt" {$this->jpegFileWithNowDate}`;
        `rm -f {$this->jpegFileWithNowDate}_original`;

        $this->sourceJpegFiles[] = $this->jpegFileWithNowDate;

        copy($this->jpegFileWithNowDate, $this->jpegFileWithSpecificDate);
        $dt = date('Y:m:d H:i:s', $this->jpegSpecificDate);
        `{$this->exiftool} -alldates="$dt" {$this->jpegFileWithSpecificDate}`;
        `rm -f {$this->jpegFileWithSpecificDate}_original`;

        $this->sourceJpegFiles[] = $this->jpegFileWithSpecificDate;
    }

    public function setUpVideo()
    {
        copy($this->dataDir . "/v.mp4", $this->sourceDir . '/v.mp4');
        //copy($this->dataDir . "/v2.thm", $this->sourceDir . '/v2.thm');//jpeg
        $this->sourceVideoFiles = [
            $this->sourceDir . '/v.mp4',
        //    $this->sourceDir . '/v2.thm'//jpeg
        ];
    }

    /**
     * @return \DateTime
     */
    public function getJpegSpecificDate(): \DateTime
    {
        $dt = new \DateTime();
        $dt->setTimestamp($this->jpegSpecificDate);
        return $dt;
    }

    /**
     * @return string
     */
    public function getJpegWithoutDateTimeTag(): string
    {
        return $this->jpegWithoutDateTimeTag;
    }

    public function createJpegWithoutDateTimeTag()
    {
        $this->jpegWithoutDateTimeTag = dirname($this->getJpegFileWithSpecificDate()) . '/a_WithoutDateTimeTag.jpg';
        copy($this->getJpegFileWithSpecificDate(), $this->jpegWithoutDateTimeTag);
        `{$this->exiftool} -ModifyDate='' {$this->jpegWithoutDateTimeTag}`;
        `rm -f {$this->jpegWithoutDateTimeTag}_original`;
    }

    /**
     * @return string
     */
    public function getJpegFileWithSpecificDate(): string
    {
        return $this->jpegFileWithSpecificDate;
    }

    /**
     * @return string
     */
    public function getJpegWithoutDateTimeOriginalTag(): string
    {
        return $this->jpegWithoutDateTimeOriginalTag;
    }

    public function createJpegWithout_DateTime_and_DateTimeOriginal_Tag()
    {
        $this->jpegWithoutDateTimeOriginalTag = dirname($this->getJpegFileWithSpecificDate()) . '/a_WithoutOriginalTag.jpg';
        copy($this->getJpegFileWithSpecificDate(), $this->jpegWithoutDateTimeOriginalTag);
        `{$this->exiftool} -ModifyDate='' {$this->jpegWithoutDateTimeOriginalTag}`;
        `{$this->exiftool} -DateTimeOriginal='' {$this->jpegWithoutDateTimeOriginalTag}`;
        `rm -f {$this->jpegWithoutDateTimeOriginalTag}_original`;
    }

    /**
     * @return string
     */
    public function getSourceDir(): string
    {
        return $this->sourceDir;
    }

    public function __destruct()
    {
        $this->tearDown();
    }

    public function tearDown()
    {
        `rm -rf {$this->rootPath}`;
    }

    /**
     * @return array
     */
    public function getSourceJpegFiles(): array
    {
        return $this->sourceJpegFiles;
    }
}