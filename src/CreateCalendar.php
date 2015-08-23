<?php

namespace Scortes\Calendar;

use Scortes\Calendar\Month\CreateMonthsInterval;
use Scortes\Calendar\Events\Events;

class CreateCalendar
{
    private $createInterval;

    public function __construct(CreateMonthsInterval $b)
    {
        $this->createInterval = $b;
    }

    public function __invoke(CalendarRequest $request)
    {
        $response = new Calendar();
        $response->today = new Today();
        $response->events = $this->loadEvents($request);
        $response->months = $this->createInterval->__invoke($request->dateStart, $request->dateEnd);
        return $response;
    }

    private function loadEvents(CalendarRequest $request)
    {
        $events = new Events('-');
        $firstDate = null;
        $lastDate = null;
        foreach ($request->events as $dateString => $event) {
            $date = (new \DateTime($dateString));
            $firstDate = $firstDate ? min($date, $firstDate) : $date;
            $lastDate = $lastDate ? max($date, $lastDate) : $date;
            $events->set($date->format('Y-n-j'), $event);
        }
        $request->dateStart = $request->dateStart ?: $firstDate;
        $request->dateEnd = $request->dateEnd ?: $lastDate;
        return $events;
    }
}
