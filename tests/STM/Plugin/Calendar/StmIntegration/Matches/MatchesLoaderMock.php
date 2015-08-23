<?php

namespace STM\Plugin\Calendar\StmIntegration\Matches;

class MatchesLoaderMock extends MatchesLoader
{

    public function setDateFormat($dateFormat)
    {
    }

    public function setMatchSelection(array $matchSelection)
    {
    }

    public function getLastmodDateForMatchSelection()
    {
        return 10;
    }

    public function getMatches()
    {
        return array('2009-9-9');
    }

    public function matchDateToString($match)
    {
        return $match;
    }
}
