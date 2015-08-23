<?php

namespace Scortes\Calendar\Events;

class DepthFirstSearch implements \IteratorAggregate
{
    /** @var array */
    private $stack;
    /** @var array */
    private $events;

    public function __construct(EventNode $firstNode = null)
    {
        if (is_null($firstNode)) {
            $this->loadEmptyEvents();
        } else {
            $this->prepareStack($firstNode);
        }
    }

    private function loadEmptyEvents()
    {
        $this->events = array();
    }

    private function prepareStack($firstNode)
    {
        $this->stack = array($firstNode);
    }

    public function getIterator()
    {
        if ($this->eventsNotLoaded()) {
            $this->loadEvents();
        }
        return new \ArrayIterator($this->events);
    }

    private function eventsNotLoaded()
    {
        return is_null($this->events);
    }

    private function loadEvents()
    {
        $this->events = array();
        while ($this->areEventsInStack()) {
            $this->processNextEvent();
        }
    }

    private function areEventsInStack()
    {
        return count($this->stack) > 0;
    }

    public function processNextEvent()
    {
        $removedEvent = array_shift($this->stack);
        $this->addEvents($removedEvent);
        $this->pushChildsToStack($removedEvent);
    }

    private function addEvents(EventNode $removedEvent)
    {
        $event = $removedEvent->getEvent();
        if ($event->events) {
            $this->events[] = $event->unwrap();
        }
    }

    private function pushChildsToStack(EventNode $removedEvent)
    {
        $this->stack = array_merge($removedEvent->getSubEvents(), $this->stack);
    }
}
