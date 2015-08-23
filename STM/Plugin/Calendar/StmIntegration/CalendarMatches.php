<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\StmIntegration;

use STM\Libs\FileCache\ISource;
use STM\Plugin\Calendar\CalendarInteractor;
use STM\Plugin\Calendar\CalendarRequest;
use STM\Plugin\Calendar\StmIntegration\Matches\MatchesLoader;
use STM\Plugin\Calendar\StmIntegration\Matches\MatchesToEvents;

class CalendarMatches implements ISource
{
    /** @var \STM\Plugin\Calendar\CalendarResponse */
    private $response;
    /** @var \STM\Plugin\Calendar\CalendarInteractor */
    private $interactor;
    /** @var \STM\Plugin\Calendar\CalendarRequest */
    private $request;
    /** @var \STM\Plugin\Calendar\StmIntegration\Matches\MatchesLoader */
    private $matchesLoader;
    /** @var \STM\Plugin\Calendar\StmIntegration\Matches\MatchesToEvents */
    private $matchesToEvents;
    
    public function __construct(MatchesLoader $matchesLoader)
    {
        $this->matchesLoader = $matchesLoader;
        $this->matchesToEvents = new MatchesToEvents();
        $this->interactor = new CalendarInteractor();
        $this->request = new CalendarRequest();
        $this->request->events = array();
        $this->request->analyzeMonths = true;
    }

    public function setRequest(StmCalendarRequest $request)
    {
        $this->request->eventsDelimiter = $request->dateDelimiter;
        $this->request->deleteBoundaryMonthsWithoutEvents = $request->deleteBoundaryMonthsWithoutMatches;
        $this->request->dateStart = \DateTime::createFromFormat($request->dateFormat, $request->dateMin);
        $this->request->dateEnd = \DateTime::createFromFormat($request->dateFormat, $request->dateMax);
        $this->matchesLoader->setDateFormat($request->dateFormat);
        $this->matchesLoader->setMatchSelection($request->matchSelection);
    }

    public function getContent()
    {
        return $this->response;
    }

    public function getEffectiveDate()
    {
        return $this->matchesLoader->getLastmodDateForMatchSelection();
    }

    public function reloadContent()
    {
        $this->loadEvents();
        $this->response = $this->getResponse();
    }

    private function loadEvents()
    {
        $this->request->events = $this->matchesToEvents->transform($this->matchesLoader);
    }

    private function getResponse()
    {
        return $this->interactor->execute($this->request);
    }
}
