<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\Events;

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

    public function hasEvents()
    {
        return count($this->events) > 0;
    }

    public function unwrap()
    {
        if (count($this->events) == 1) {
            return $this->events[0];
        }
        return $this->events;
    }

    public function __toString()
    {
        return (string) $this->unwrap();
    }
}
