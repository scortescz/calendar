<?php

namespace Scortes\Calendar;

use \DateTime;
use Prophecy\Argument as arg;
use Scortes\Calendar\Month\Month;
use Scortes\Calendar\Events\Event;

class CalendarInteractorTest extends \PHPUnit_Framework_TestCase
{
    private $interval;
    private $analyzer;
    /** @var \Scortes\Calendar\CalendarResponse */
    private $response;

    protected function setUp()
    {
        $this->interval = $this->prophesize('Scortes\Calendar\Month\CreateMonthsInterval');
        $this->analyzer = $this->prophesize('Scortes\Calendar\Month\AnalyzeMonth');
    }

    public function testShouldLoadAnalyzedMonthsAndEvents()
    {
        $this->interval->__invoke(arg::cetera())->shouldBeCalled()->willReturn([Month::dummy()]);
        $this->analyzer->__invoke(arg::type('Scortes\Calendar\Month\Month'))->shouldBeCalled();
        $events = array(
            '2013-9-5' => 'Shopping',
            '2013-10-6' => 'School exam',
            '2013-10-30' => 'Vacations'
        );
        $this->loadEventsResponse($events);
        $this->assertExistingEvent('2013-10-30', 'Vacations');
        $this->assertExistingEventsFromIterator(
            '2013-10',
            array(
                '2013-10-6' => 'School exam',
                '2013-10-30' => 'Vacations'
            )
        );
    }

    private function loadEventsResponse(array $events)
    {
        $r = new CalendarRequest();
        $r->dateStart = new DateTime('now');
        $r->dateEnd = new DateTime('now');
        $r->events = $events;
        $r->eventsDelimiter = '-';
        $uc = new CalendarInteractor($this->interval->reveal(), $this->analyzer->reveal());
        $this->response = $uc($r);
    }

    private function assertExistingEvent($date, $expectedEvent)
    {
        parent::assertEquals($expectedEvent, $this->response->events->getEvent($date));
    }

    private function assertExistingEventsFromIterator($datePart, $expectedEvents)
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
