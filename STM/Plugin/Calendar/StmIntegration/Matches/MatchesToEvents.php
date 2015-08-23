<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\StmIntegration\Matches;

class MatchesToEvents
{
    /** @var array */
    private $events;
    /** @var Matches */
    private $matches;
    /** @var \DateTime */
    private $matchDate;

    public function transform(Matches $matches)
    {
        $this->initTransformation($matches);
        $this->transformMatches();
        return $this->events;
    }

    private function initTransformation($matches)
    {
        $this->events = array();
        $this->matches = $matches;
    }

    private function transformMatches()
    {
        foreach ($this->matches->getMatches() as $match) {
            $this->loadMatchDate($match);
            $this->addEvent($match);
        }
    }

    private function loadMatchDate($match)
    {
        $this->matchDate = $this->matches->matchDateToString($match);
    }

    private function addEvent($match)
    {
        $date = $this->matches->matchDateToString($match);
        $this->events[$date] = $match;
    }
}
