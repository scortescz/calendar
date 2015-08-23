<?php

namespace STM\Plugin\Calendar\StmIntegration\Matches;

class MatchesMock implements Matches
{
    public $matches = array();

    public function getMatches()
    {
        return $this->matches;
    }

    public function matchDateToString($match)
    {
        return $match;
    }
}
