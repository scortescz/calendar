<?php

namespace Scortes\Calendar\Month;

use \DateTime;

class MonthsBetweenDatesTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldLoadMonthNumberAndYear()
    {
        $march = $this->getMonths('2013-02', '2013-04')[1];
        assertThat($march->monthNumber, is(3));
        assertThat($march->year, is(2013));
    }

    /** @dataProvider provideDateInterval */
    public function testShouldLoadMonthsBetweenTwoDates($start, $end, $expectedMonthsCount)
    {
        assertThat($this->getMonths($start, $end), arrayWithSize($expectedMonthsCount));
    }

    public function provideDateInterval()
    {
        return [
            ['2013-10', '2013-11', 2],
            ['2013-12', '2014-01', 2],
            ['2014-01', '2014-01', 1],
            ['2013-01', '2013-12', 12],
            ['2013-08', '2015-02', 19],
            ['2013-01', '2015-12', 36],
        ];
    }

    private function getMonths($startDate, $endDate)
    {
        $start = DateTime::createFromFormat('Y-m', $startDate);
        $end = DateTime::createFromFormat('Y-m', $endDate);
        $uc = new MonthsBetweenDates();
        return $uc->getMonths($start, $end);
    }
}
