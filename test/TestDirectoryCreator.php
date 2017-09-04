<?php

namespace dovbysh\PhotoSorterTest;

class TestDirectoryCreator
{
    private $rootPath;
    private $sourceDir = '';
    private $destinationDir = '';
    private $exiftool = '/usr/bin/exiftool';
    private $sA = '';
    private $sDate1 = '';
    private $now = 0;
    private $date1 = 0;

    private $sourceFiles = [];

    public function __construct(bool $selfInitialize = true)
    {
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
        $this->date1 = mktime(mt_rand(0, 24), mt_rand(0, 60), mt_rand(0, 60), mt_rand(1, 12), mt_rand(0, 32), mt_rand(2000, 2017));
        $this->sDate1 = $this->sourceDir . '/' . mt_rand() . '/' . mt_rand() . '/' . mt_rand();
        mkdir($this->sDate1, 0777, true);
        $this->sDate1 .= mt_rand() . '.jpg';

        $this->sA = $this->sourceDir . '/a.jpg';
        $im = imagecreatetruecolor(20, 20);
        imagefill($im, 0, 0, 255);
        imagejpeg($im, $this->sA);
        $dt = date('Y:m:d H:i:s', $this->now);
        $dataDir = __DIR__ . '/data/';
        `{$this->exiftool} -tagsfromfile {$dataDir}a.jpg -exif {$this->sA}`;
        `{$this->exiftool} -alldates="$dt" {$this->sA}`;
        `rm -f {$this->sA}_original`;

        $this->sourceFiles[] = $this->sA;

        copy($this->sA, $this->sDate1);
        $dt = date('Y:m:d H:i:s', $this->date1);
        `{$this->exiftool} -alldates="$dt" {$this->sDate1}`;
        `rm -f {$this->sDate1}_original`;

        $this->sourceFiles[] = $this->sDate1;
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
    public function getSourceFiles(): array
    {
        return $this->sourceFiles;
    }
}