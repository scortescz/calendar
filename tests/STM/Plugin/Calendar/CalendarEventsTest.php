<?php

namespace STM\Plugin\Calendar;

use STM\Plugin\Calendar\Events\Events;
use STM\Plugin\Calendar\Events\EventsIteratorUtil;

/**
 * @group calendar
 */
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

    public function testExistingEvent()
    {
        $this->events->set('2009-01-01', 'event');
        parent::assertTrue($this->object->existsEvent('2009-01-01'));
    }

    public function testNonExistingEvent()
    {
        parent::assertFalse($this->object->existsEvent('unexisting'));
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
