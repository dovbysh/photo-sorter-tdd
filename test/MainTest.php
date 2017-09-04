<?php

namespace dovbysh\PhotoSorterTest;


use dovbysh\PhotoSorterTdd\Main;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testRunUnconfigured()
    {
        $main = new Main('', '');

        $this->expectException('Exception');

        $main->run();
    }

    public function testSrcCannotBeFound()
    {
        $main = new Main('/path_not_found', '');

        $this->expectException('UnexpectedValueException');

        $main->run();
    }
}
