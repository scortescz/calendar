<?php

namespace STM\Plugin\Calendar;

use STM\Plugin\Calendar\Month\Month;
use STM\Plugin\Calendar\Events\Event;

class CalendarAsserts extends \PHPUnit_Framework_TestCase
{
    /** @var \STM\Plugin\Calendar\CalendarResponse */
    private $response;

    public function setCalendarResponse(CalendarResponse $response)
    {
        $this->response = $response;
    }

    public function assertFirstMonthInCalendar($expectedMonth, $expectedYear)
    {
        $firstMonth = $this->response->months->getFirstMonth();
        $this->assertMonth($firstMonth, $expectedMonth, $expectedYear);
    }

    public function assertLastMonthInCalendar($expectedMonth, $expectedYear)
    {
        $lastMonth = $this->response->months->getLastMonth();
        $this->assertMonth($lastMonth, $expectedMonth, $expectedYear);
    }

    public function assertMonth(Month $m, $expectedMonth, $expectedYear)
    {
        parent::assertEquals($expectedYear, $m->year);
        parent::assertEquals($expectedMonth, $m->monthNumber);
    }

    public function assertNumberOfMonthsInCalendar($expectedCount)
    {
        parent::assertEquals($expectedCount, $this->response->months->getMonthsCount());
    }

    public function assertExistingEvent($date, $expectedEvent)
    {
        parent::assertEquals($expectedEvent, $this->response->events->getEvent($date));
    }

    public function assertExistingEventsFromIterator($datePart, $expectedEvents)
    {
        $index = 0;
        $iterated = iterator_to_array($this->response->events->iterate($datePart));
        foreach ($expectedEvents as $date => $event) {
            $this->assertEventFromIterator($iterated[$index++], $date, $event);
        }
    }

    private function assertEventFromIterator(Event $iteratorEvent, $expectedDate, $expectedEvent)
    {
        parent::assertEquals($expectedDate, $iteratorEvent->date);
        parent::assertEquals($expectedEvent, $iteratorEvent->unwrap());
    }
}
