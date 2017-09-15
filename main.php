<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use dovbysh\PhotoSorterTdd\FactoryImpl;
use dovbysh\PhotoSorterTdd\Main;

(new Main($argv[1] ?? '', $argv[2] ?? '', new FactoryImpl()))->run();
