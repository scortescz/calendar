<?php

namespace Scortes\Calendar;

use Scortes\Calendar\Events\Events;
use Scortes\Calendar\Events\EventsIterator;

class CalendarEvents implements EventsIterator
{
    /** @var \Scortes\Calendar\Events\Events */
    private $events;
    /** @var array */
    private $cache = array();

    public function __construct(Events $events)
    {
        $this->events = $events;
    }

    public function getEvent($date)
    {
        if (!array_key_exists($date, $this->cache)) {
            $this->cache[$date] = $this->events->find($date);
        }
        return $this->cache[$date];
    }

    public function getIterator()
    {
        return $this->events->getIterator();
    }

    public function iterate($date)
    {
        return $this->events->iterate($date);
    }
}
