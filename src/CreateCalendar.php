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
        $response->events = new Events($request->eventsDelimiter, $request->events);
        $response->months = $this->createInterval->__invoke($request->dateStart, $request->dateEnd);
        return $response;
    }
}
