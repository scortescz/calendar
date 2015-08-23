<?php

namespace Scortes\Calendar\Events;

/**
 * @group events
 */
class EventTest extends \PHPUnit_Framework_TestCase
{
    /** @var Event */
    private $event;

    public function testCreatedInstanceHasNoEvents()
    {
        $this->event = new Event('date');
        parent::assertFalse($this->event->hasEvents());
    }

    public function testUnwrappingInstanceWithOneEvent()
    {
        $this->event = new Event('date');
        $this->event->events[] = 'first';
        parent::assertEquals('first', $this->event->unwrap());
    }

    public function testUnwrappingInstanceWithTwoEvents()
    {
        $events = array('first', 'second');
        $this->event = new Event('date');
        $this->event->events = $events;
        parent::assertEquals($events, $this->event->unwrap());
    }

    public function testToStringInstanceWithOneEvent()
    {
        $this->event = new Event('date');
        $this->event->events[] = 'first';
        parent::assertEquals('first', (string) $this->event);
    }

    public function testToStringInstanceWithTwoEvents()
    {
        $this->event = new Event('date');
        $this->event->events = array('first', 'second');
        parent::assertEquals('Array', (string) $this->event);
    }
}
