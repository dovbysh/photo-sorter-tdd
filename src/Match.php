<?php

namespace dovbysh\PhotoSorterTdd;

use dovbysh\PhotoSorterTdd\Exception\InvalidRegExp;

class Match
{
    private $regExp;
    private $matched;

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
     * @return mixed
     */
    public function getMatched()
    {
        return $this->matched;
    }

    /**
     * @param string $subject
     * @return bool
     */
    public function match(string $subject): bool
    {
        if (is_string($this->regExp)) {
            return (bool)preg_match($this->regExp, $subject, $this->matched);
        } else {
            foreach ($this->regExp as $regExp) {
                if (preg_match($regExp, $subject, $this->matched)) {
                    return true;
                }
            }
        }
        return false;
    }
}