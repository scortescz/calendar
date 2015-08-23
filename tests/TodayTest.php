<?php

namespace Scortes\Calendar;

use Scortes\Calendar\Month\Month;

class TodayTest extends \PHPUnit_Framework_TestCase
{
    /** @dataProvider provideDates */
    public function testShouldExtractPartOfDate($unit, $expectedDate)
    {
        $today = new Today();
        assertThat($today->date, anInstanceOf('DateTime'));
        assertThat($today->{$unit}, is(date($expectedDate)));
    }

    public function provideDates()
    {
        return [
            ['day', 'j'],
            ['monthNumber', 'n'],
            ['year', 'Y'],
            ['weekNumber', 'W'],
        ];
    }

    public function testShouldRecognizeCurrentDayWeekAndMonth()
    {
        $today = new Today(new \DateTime('2015-08-08'));
        $month = new Month(7, 2015);
        $month->daysCount = 31;
        assertThat($today->isCurrentMonth($month), is(false));
        $month->monthNumber = $today->monthNumber;
        assertThat($today->isCurrentMonth($month), is(true));
        assertThat($today->isCurrentWeek($month, 0), is(false));
        assertThat($today->isCurrentMonth($month, 1), is(true));
        list($isDayInMonth, $isCurrentDay) = $today->isCurrentDay($month, $month->firstDayOfWeek, $today->day);
        assertThat($isDayInMonth, is(true));
        assertThat($isCurrentDay, is(true));
    }
}
