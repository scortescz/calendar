<?php

namespace Scortes\Calendar;

use Scortes\Calendar\Month\CreateMonthsInterval;
use Scortes\Calendar\Events\Events;

class CalendarInteractor
{
    private $createInterval;

    public function __construct(CreateMonthsInterval $b)
    {
        $this->createInterval = $b;
    }

    /** @return \Scortes\Calendar\CalendarResponse */
    public function __invoke(CalendarRequest $request)
    {
        $response = new CalendarResponse();
        $response->today = new Today();
        $response->events = $this->getEvents($request->events, $request->eventsDelimiter);
        $response->months = $this->getMonths($request);
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
        $months = $this->createInterval->__invoke($request->dateStart, $request->dateEnd);
        return new CalendarMonths($months);
    }
}
