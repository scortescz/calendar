<?php

namespace Scortes\Calendar;

use Scortes\Calendar\Month\MonthFactory;
use Scortes\Calendar\Month\MonthAnalyzer;
use Scortes\Calendar\Month\MonthsBetweenDates;
use Scortes\Calendar\Events\Events;

class CalendarInteractor
{
    private $monthsBetween;
    private $monthAnalyzer;

    public function __construct()
    {
        $factory = new MonthFactory();
        $this->monthsBetween = new MonthsBetweenDates($factory);
        $this->monthAnalyzer = new MonthAnalyzer();
    }

    /** @return \Scortes\Calendar\CalendarResponse */
    public function __invoke(CalendarRequest $request)
    {
        $response = new CalendarResponse();
        $response->today = new Today();
        $response->events = $this->getEvents($request->events, $request->eventsDelimiter);
        $response->months = $this->getMonths($request);
        $response->monthsAnalyses = $this->getAnalyses($response->months);
        return $response;
    }

    private function getEvents(array $inputEvents, $delimiter)
    {
        $events = new Events($delimiter);
        foreach ($inputEvents as $date => $event) {
            $events->set($date, $event);
        }
        return new CalendarEvents($events);
    }

    public function getMonths(CalendarRequest $request)
    {
        $months = $this->monthsBetween->getMonths($request->dateStart, $request->dateEnd);
        return new CalendarMonths($months);
    }

    private function getAnalyses($months)
    {
        $analyses = array();
        foreach ($months as $m) {
            $analyses[] = $this->monthAnalyzer->analyze($m);
        }
        return $analyses;
    }
}
