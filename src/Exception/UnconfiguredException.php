<?php

namespace dovbysh\PhotoSorterTdd\Exception;

class UnconfiguredException extends \Exception
{
    public $parametrName = '';
}