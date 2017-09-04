<?php

namespace dovbysh\PhotoSorterTdd\Exception;

use Throwable;

class EmptyDst extends Unconfigured
{
    const NAME = 'dstPath';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->parametrName = static::NAME;
    }
}