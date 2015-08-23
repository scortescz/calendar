<?php

namespace Scortes\Calendar;

use \DateTime;
use Prophecy\Argument as arg;

class CreateCalendarTest extends \PHPUnit_Framework_TestCase
{
    private $interval;

    protected function setUp()
    {
        $this->interval = $this->prophesize('Scortes\Calendar\Month\CreateMonthsInterval');
    }

    /** @dataProvider provideDates */
    public function testShouldLoadMonthsAndEvents($dateStart, $dateEnd)
    {
        $this->interval->__invoke(arg::cetera())->shouldBeCalled()->willReturn([]);
        $r = new CalendarRequest();
        $r->dateStart = $dateStart;
        $r->dateEnd = $dateEnd;
        $r->events = array('2013-9-5' => 'irrelevant event');
        $uc = new CreateCalendar($this->interval->reveal());
        $uc($r);
    }

    public function provideDates()
    {
        return [
            'use dates from events' => [null, null],
            'use startDate from events' => [null, new DateTime('now')],
            'use endDate from events' => [new DateTime('now'), null],
            'define both dates' => [new DateTime('now'), new DateTime('now')],
        ];
    }
}
