<?php

namespace Scortes\Calendar;

use Scortes\Calendar\Helpers\Today;
use Scortes\Calendar\Month\MonthFactory;
use Scortes\Calendar\Month\Analysis\MonthAnalyzer;
use Scortes\Calendar\Month\MonthsBetweenDates;
use Scortes\Calendar\Events\Events;

class CalendarInteractor
{
    /** @var \Scortes\Calendar\Helpers\Today */
    private $today;
    /** @var \Scortes\Calendar\Month\MonthsBetweenDates */
    private $monthsBetween;
    /** @var \Scortes\Calendar\Month\Analysis\MonthAnalyzer */
    private $monthAnalyzer;

    public function __construct()
    {
        $this->today = new Today();
        $factory = new MonthFactory();
        $this->monthsBetween = new MonthsBetweenDates($factory);
        $this->monthAnalyzer = new MonthAnalyzer();
    }

    /** @return \Scortes\Calendar\CalendarResponse */
    public function __invoke(CalendarRequest $request)
    {
        $response = new CalendarResponse();
        $response->today = $this->getToday();
        $response->events = $this->getEvents($request->events, $request->eventsDelimiter);
        $response->months = $this->getMonths($request);
        $response->monthsAnalyses = $this->getMonthsAnalyses($request, $response->months);
        return $response;
    }

    private function getToday()
    {
        return $this->today;
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

    private function getMonthsAnalyses(CalendarRequest $request, CalendarMonths $months)
    {
        if ($request->analyzeMonths) {
            return $this->getAnalyses($months);
        } else {
            return array();
        }
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
