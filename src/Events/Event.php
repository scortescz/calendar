<?php

namespace Scortes\Calendar\Events;

class Event
{
    /** @var string */
    public $date;
    /** @var array */
    public $events;

    public function __construct($date)
    {
        $this->date = $date;
        $this->events = array();
    }

    public function unwrap()
    {
        if (count($this->events) == 1) {
            return $this->events[0];
        }
        return $this->events;
    }
}
