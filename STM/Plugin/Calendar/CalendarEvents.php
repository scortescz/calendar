<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar;

use STM\Plugin\Calendar\Events\Events;
use STM\Plugin\Calendar\Events\EventsIterator;

class CalendarEvents implements EventsIterator
{
    /** @var \STM\Plugin\Calendar\Events\Events */
    private $events;
    /** @var array */
    private $eventsCache = array();

    public function __construct(Events $events)
    {
        $this->events = $events;
    }

    public function existsEvent($date)
    {
        if (!array_key_exists($date, $this->eventsCache)) {
            $this->eventsCache[$date] = $this->events->find($date);
        }
        return $this->eventsCache[$date]->exist;
    }

    public function getEvent($date)
    {
        if (!array_key_exists($date, $this->eventsCache)) {
            $this->eventsCache[$date] = $this->events->find($date);
        }
        return $this->eventsCache[$date]->event;
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
