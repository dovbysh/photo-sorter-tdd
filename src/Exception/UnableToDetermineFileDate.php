<?php

namespace dovbysh\PhotoSorterTdd\Exception;

class UnableToDetermineFileDate extends \Exception
{
    public $filename = '';
}