<?php

namespace Scortes\Calendar\Helpers;

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
}
