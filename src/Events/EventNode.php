<?php

namespace Scortes\Calendar\Events;

class EventNode
{
    /** @var \Scortes\Calendar\Events\Event */
    private $event;
    /** @var array */
    private $subEvents = array();

    public function __construct($date)
    {
        $this->event = new Event($date);
    }

    public function add($event)
    {
        $this->event->events[] = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function unwrapEvent()
    {
        return $this->event->unwrap();
    }

    public function setSubEvent($key, EventNode $event)
    {
        $this->subEvents[$key] = $event;
    }

    public function getSubEvent($key)
    {
        return $this->subEvents[$key];
    }

    public function existsSubEvent($key)
    {
        return array_key_exists($key, $this->subEvents);
    }

    public function getSubEvents()
    {
        return $this->subEvents;
    }
}
