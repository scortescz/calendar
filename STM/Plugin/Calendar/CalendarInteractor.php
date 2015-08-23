<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar;

use STM\Plugin\Calendar\Helpers\Today;
use STM\Plugin\Calendar\Helpers\CalendarBoundary;
use STM\Plugin\Calendar\Month\MonthFactory;
use STM\Plugin\Calendar\Month\Analysis\MonthAnalyzer;
use STM\Plugin\Calendar\Month\MonthsBetweenDates;
use STM\Plugin\Calendar\Events\Events;

class CalendarInteractor implements Calendar
{
    /** @var \STM\Plugin\Calendar\Helpers\Today */
    private $today;
    /** @var \STM\Plugin\Calendar\Month\MonthsBetweenDates */
    private $monthsBetween;
    /** @var \STM\Plugin\Calendar\Helpers\CalendarBoundary */
    private $calendarBoundary;
    /** @var \STM\Plugin\Calendar\Month\Analysis\MonthAnalyzer */
    private $monthAnalyzer;

    public function __construct()
    {
        $this->today = new Today();
        $factory = new MonthFactory();
        $this->monthsBetween = new MonthsBetweenDates($factory);
        $this->calendarBoundary = new CalendarBoundary();
        $this->monthAnalyzer = new MonthAnalyzer();
    }

    public function execute(CalendarRequest $request)
    {
        $response = new CalendarResponse();
        $response->today = $this->getToday();
        $response->events = $this->getEvents($request->events, $request->eventsDelimiter);
        $response->months = $this->getMonths($request, $response->events);
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

    public function getMonths(CalendarRequest $request, CalendarEvents $events)
    {
        $months = $this->monthsBetween->getMonths($request->dateStart, $request->dateEnd);
        if ($request->deleteBoundaryMonthsWithoutEvents) {
            $this->calendarBoundary->setEvents($events);
            $this->calendarBoundary->setEventsDelimiter($request->eventsDelimiter);
            $months = $this->calendarBoundary->deleteBoundaryMonthsWithoutEvents($months, $events);
        }
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
