<?php

namespace dovbysh\PhotoSorterTdd;


use dovbysh\PhotoSorterTdd\Exception\NotFound;

class TimeShift
{
    /**
     * @var Match
     */
    private $match;
    private $partOfPath = '';

    public function __construct(Match $match = null, string $regExp = null)
    {
        if ($match instanceof Match) {
            $this->setMatch($match);
        } else {
            $this->setMatch(new Match('~(' . preg_quote(DIRECTORY_SEPARATOR, '~') . 'TIMESHIFT' . preg_quote(DIRECTORY_SEPARATOR, '~') . '\d+' . preg_quote(DIRECTORY_SEPARATOR, '~') . ')~'));
        }

        if (isset($regExp)) {
            $this->match->setRegExp($regExp);
        }
    }

    /**
     * @param Match $match
     */
    public function setMatch(Match $match)
    {
        $this->match = $match;
    }

    public function check(string $sourceFilePath)
    {
        if ($res = $this->match->match($sourceFilePath)) {
            $this->partOfPath = $this->match->getMatched()[1];
        } else {
            $this->partOfPath = '';
        }
        return $res;
    }

    public function getPartOfPath()
    {
        if (empty($this->partOfPath)) {
            throw new NotFound();
        }
        return $this->partOfPath;
    }

}