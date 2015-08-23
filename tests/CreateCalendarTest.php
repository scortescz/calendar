<?php

namespace Scortes\Calendar;

use \DateTime;
use Prophecy\Argument as arg;

class CreateCalendarTest extends \PHPUnit_Framework_TestCase
{
    /** @dataProvider provideDates */
    public function testShouldLoadMonthsAndEvents($dateStart, $dateEnd)
    {
        $r = new CalendarRequest();
        $r->dateStart = $dateStart;
        $r->dateEnd = $dateEnd;
        $r->events = ['2013-9-5' => 'irrelevant event'];
        $r->addEvent(new \DateTime(), 'another event');

        $interval = $this->prophesize('Scortes\Calendar\Month\CreateMonthsInterval');
        $interval->__invoke(arg::cetera())->shouldBeCalled()->willReturn([]);
        $uc = new CreateCalendar($interval->reveal());
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
