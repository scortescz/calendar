<?php

namespace Scortes\Calendar\Month;

use \DateTime;
use Prophecy\Argument;

class CreateMonthsIntervalTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldLoadMonthNumberAndYear()
    {
        $march = $this->testShouldLoadMonthsBetweenTwoDates('2013-02', '2013-04', 3)[1];
        assertThat($march->monthNumber, is(3));
        assertThat($march->year, is(2013));
    }

    /** @dataProvider provideDateInterval */
    public function testShouldLoadMonthsBetweenTwoDates($start, $end, $expectedMonthsCount)
    {
        $analyzer = $this->prophesize('Scortes\Calendar\Month\AnalyzeMonth');
        $analyzer->__invoke(Argument::any())->shouldBeCalledTimes($expectedMonthsCount);
        $uc = new CreateMonthsInterval($analyzer->reveal());
        $months = $uc(
            DateTime::createFromFormat('Y-m', $start),
            DateTime::createFromFormat('Y-m', $end)
        );
        assertThat($months, arrayWithSize($expectedMonthsCount));
        return $months;
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
}
