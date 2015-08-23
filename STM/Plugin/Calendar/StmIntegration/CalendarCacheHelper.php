<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\StmIntegration;

use STM\Plugin\Calendar\StmIntegration\Matches\MatchesLoader;

class CalendarCacheHelper
{
    /** @var \STM\Plugin\Calendar\StmIntegration\StmCalendarRequest */
    private $stmRequest;
    /** @var string */
    private $cacheDir;
    /** @var \STM\Plugin\Calendar\StmIntegration\CalendarMatches */
    private $source;

    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
        $matchesLoader = new MatchesLoader();
        $this->source = new CalendarMatches($matchesLoader);
    }

    public function getCalendarSource()
    {
        return $this->source;
    }

    public function setRequest(StmCalendarRequest $request)
    {
        $this->stmRequest = $request;
        $this->addDatesToMatchSelection();
        $this->source->setRequest($this->stmRequest);
    }

    private function addDatesToMatchSelection()
    {
        $this->stmRequest->matchSelection['dates'] = array(
            'min' => $this->stmRequest->dateMin,
            'max' => $this->stmRequest->dateMax
        );
    }

    public function getCacheFilePath()
    {
        $filename = "from-{$this->stmRequest->dateMin}-to-{$this->stmRequest->dateMax}";
        $filename .= $this->getTeams();
        $filename .= $this->getCompetition();
        return $this->cacheDir . '/' . $filename;
    }

    private function getTeams()
    {
        $string = '';
        if ($this->isKeyDefinedInMatchSelection('teams')) {
            $teams = $this->stmRequest->matchSelection['teams'];
            $string .= '-teams-' . implode('+', $teams);
        }
        return $string;
    }

    private function getCompetition()
    {
        $string = '';
        if ($this->isKeyDefinedInMatchSelection('competition')) {
            $string .= '-competition-' . $this->stmRequest->matchSelection['competition'];
        }
        return $string;
    }

    private function isKeyDefinedInMatchSelection($key)
    {
        return array_key_exists($key, $this->stmRequest->matchSelection);
    }
}
