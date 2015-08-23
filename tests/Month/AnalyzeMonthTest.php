<?php

namespace Scortes\Calendar\Month;

use Scortes\Calendar\Month\Month;

class AnalyzeMonthTest extends \PHPUnit_Framework_TestCase
{
    /** @dataProvider provideMonth */
    public function testShouldAnalyzeMonth(
        Month $month,
        $expectedDays,
        $expectedWeeks,
        $expectedFirstDay,
        $expectedFirstWeekNumber
    ) {
        $analyzer = new AnalyzeMonth;
        $analyzer($month);
        assertThat($month->daysCount, is($expectedDays));
        assertThat($month->weeksCount, is($expectedWeeks));
        assertThat($month->firstDayOfWeek, is($expectedFirstDay));
        assertThat($month->firstWeekNumber, is($expectedFirstWeekNumber));
    }

    public function provideMonth()
    {
        return [
            'January 2014' => [new Month(1, 2014), 31, 5, 3, 1],
            'September 2014' => [new Month(9, 2014), 30, 5, 1, 36],
            'September 2013' => [new Month(9, 2013), 30, 6, 7, 35]
        ];
    }
}
