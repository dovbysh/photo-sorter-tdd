<?php

namespace dovbysh\PhotoSorterTdd;

use dovbysh\PhotoSorterTdd\Exception\InvalidRegExp;
use dovbysh\PhotoSorterTdd\Exception\NotFound;

class Match
{
    private $regExp;
    private $matched = [];
    private $notFound = true;

    /**
     * @param mixed $regExp
     * @throws InvalidRegExp
     */
    public function __construct($regExp)
    {
        $this->setRegExp($regExp);
    }

    /**
     * @param mixed $regExp
     * @throws InvalidRegExp
     */
    public function setRegExp($regExp)
    {
        if (!is_string($regExp) && !is_array($regExp)) {
            throw new InvalidRegExp('regExp must be a sring or array');
        }
        $this->regExp = $regExp;
    }

    /**
     * @return array
     * @throws NotFound
     */
    public function getMatched()
    {
        if ($this->notFound) {
            throw new NotFound();
        }
        return $this->matched;
    }

    /**
     * @param string $subject
     * @return bool
     */
    public function match(string $subject): bool
    {
        $this->notFound = false;
        if (is_string($this->regExp)) {
            return (bool)preg_match($this->regExp, $subject, $this->matched);
        } else {
            foreach ($this->regExp as $regExp) {
                if (preg_match($regExp, $subject, $this->matched)) {
                    return true;
                }
            }
        }
        $this->notFound = true;
        return false;
    }
}