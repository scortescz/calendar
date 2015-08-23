<?php

namespace Scortes\Calendar;

use Scortes\Calendar\Events\Events;
use Scortes\Calendar\Events\EventsIteratorUtil;

class CalendarEventsTest extends \PHPUnit_Framework_TestCase
{
    /** @var Events */
    private $events;
    /** @var CalendarEvents */
    private $object;

    protected function setUp()
    {
        $this->events = new Events('-');
        $this->object = new CalendarEvents($this->events);
    }

    public function testGetExistingEvent()
    {
        $event = 'my event';
        $this->events->set('2009-01-01', $event);
        parent::assertEquals($event, $this->object->getEvent('2009-01-01'));
    }

    public function testGetNonExistingEvent()
    {
        parent::assertNull($this->object->getEvent('unexisting'));
    }

    public function testIteratingAllEvents()
    {
        $this->events->set('2009-01-01', 'first');
        $this->events->set('2009-12-12', 'second');
        $iterator = $this->object->getIterator();
        EventsIteratorUtil::assertIterator($iterator, array('first', 'second'));
    }

    public function testIteratingSubEvents()
    {
        $this->events->set('2009-01-01', 'first');
        $this->events->set('2009-12-12', 'second');
        $iterator = $this->object->iterate('2009-12');
        EventsIteratorUtil::assertIterator($iterator, array('second'));
    }

    public function testIteratingWithUnexistingKey()
    {
        $iterator = $this->object->iterate('unexisting');
        EventsIteratorUtil::assertIterator($iterator, array());
    }
}
